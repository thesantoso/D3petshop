<?php

namespace App\Libraries;

use Illuminate\Support\Arr;

class PearsonCorrelation
{

    protected $data1;
    protected $data2;

    public function __construct(array $data1, array $data2)
    {
        $this->data1 = $data1;
        $this->data2 = $data2;
    }

    public function calculate(): float
    {
        $avg1 = $this->getAvg($this->data1);
        $avg2 = $this->getAvg($this->data2);

        list($isec1, $isec2) = $this->getIntersect(
            $this->data1,
            $this->data2
        );

        $top = $this->calculateTop($avg1, $avg2, $isec1, $isec2);
        $bottom = $this->calculateBottom($avg1, $avg2, $isec1, $isec2);

        if (!$bottom) {
            return 0;
        }

        return $top / $bottom;
    }

    public function getAvg(array $data): float
    {
        $data = array_filter($data, function($value) {
            return is_numeric($value);
        });

        if (count($data) == 0) {
            return 0;
        }

        $sum = array_sum($data);
        return $sum / count($data);
    }

    public function getIntersect(array $data1, array $data2): array
    {
        $data1 = array_filter($data1, function($val) {
            return is_numeric($val);
        });
        $data2 = array_filter($data2, function($val) {
            return is_numeric($val);
        });

        $keys1 = array_keys($data1);
        $keys2 = array_keys($data2);

        $intersects = array_intersect($keys1, $keys2);

        $isec1 = [];
        $isec2 = [];
        foreach ($intersects as $key) {
            $isec1[$key] = $data1[$key];
            $isec2[$key] = $data2[$key];
        }

        return [$isec1, $isec2];
    }

    /**
     * sum(($isec1[n] - $avg1) * ($isec2[n] - $avg2))
     */
    public function calculateTop(float $avg1, float $avg2, array $isec1, array $isec2): float
    {
        $top = 0;
        foreach ($isec1 as $key => $val1) {
            $val2 = $isec2[$key];
            $top += ($val1 - $avg1) * ($val2 - $avg2);
        }
        return $top;
    }

    /**
     * root(sum(($isec1[n] - $avg1)^2)) * root(sum(($isec2[n] - $avg2)^2))
     */
    public function calculateBottom(float $avg1, float $avg2, array $isec1, array $isec2): float
    {
        $calc = function($avg, $isec) {
            $sum = 0;
            foreach ($isec as $v) {
                $sum += pow($v - $avg, 2);
            }
            return sqrt($sum);
        };

        return $calc($avg1, $isec1) * $calc($avg2, $isec2);
    }

    /**
     * @param string $itemLabel1
     * @param string $itemLabel2
     *
     * @return Explainer
     */
    public function explain($itemLabel1, $itemLabel2)
    {
        $explainer = new Explainer;

        $this->explainData($explainer, $this->data1, $this->data2, $itemLabel1, $itemLabel2);

        $avg1 = $this->getAvg($this->data1);
        $this->explainAvg($explainer, $itemLabel1, $this->data1);

        $avg2 = $this->getAvg($this->data2);
        $this->explainAvg($explainer, $itemLabel2, $this->data2);

        list($isec1, $isec2) = $this->getIntersect(
            $this->data1,
            $this->data2
        );

        $this->explainIntersect($explainer, $this->data1, $this->data2, $itemLabel1, $itemLabel2);

        $top = $this->calculateTop($avg1, $avg2, $isec1, $isec2);
        $this->explainTop($explainer, $avg1, $avg2, $isec1, $isec2);

        $bottom = $this->calculateBottom($avg1, $avg2, $isec1, $isec2);
        $this->explainBottom($explainer, $avg1, $avg2, $isec1, $isec2);

        $final = $top / $bottom;

        $explainer->add("RESULT", "{$top} / {$bottom} = {$final}");

        return $explainer;
    }

    private function explainData(Explainer $explainer, $data1, $data2, $itemLabel1, $itemLabel2)
    {
        $heads = [$itemLabel1, $itemLabel2];
        $rows = [];
        $keys = array_unique(array_merge(array_keys($data1), array_keys($data2)));
        foreach ($keys as $k) {
            $rows[] = [Arr::get($data1, $k), Arr::get($data2, $k)];
        }

        $explainer->addTable("DATA", $heads, $rows);
    }

    private function explainAvg(Explainer $explainer, $title, $data)
    {
        $result = $this->getAvg($data);

        $numbers = array_filter($data, function($value) {
            return is_numeric($value);
        });

        if (empty($numbers)) {
            return ["title" => "AVG($title)", "detail" => ""];
        }

        $top = implode(" + ", $numbers);
        $count = count($numbers);

        $explainer->add("AVG($title)", "($top) / {$count} = {$result}");
    }

    private function explainIntersect(Explainer $explainer, $data1, $data2, $itemLabel1, $itemLabel2)
    {
        list($isec1, $isec2) = $this->getIntersect($data1, $data2);

        $heads = [$itemLabel1, $itemLabel2];
        $rows = [];
        foreach ($isec1 as $k => $v) {
            $rows[] = [$isec1[$k], $isec2[$k]];
        }

        $explainer->addTable("INTERSECT", $heads, $rows);
    }

    private function explainTop(Explainer $explainer, $avg1, $avg2, $isec1, $isec2)
    {
        $result = $this->calculateTop($avg1, $avg2, $isec1, $isec2);

        $sum = [];
        foreach ($isec1 as $key => $val1) {
            $val2 = $isec2[$key];
            $sum[] = "($val1 - $avg1) * ($val2 - $avg2)";
        }

        $explainer->add("TOP", implode(" + ", $sum)." = ".$result);
    }

    private function explainBottom(Explainer $explainer, $avg1, $avg2, $isec1, $isec2)
    {
        $result = $this->calculateBottom($avg1, $avg2, $isec1, $isec2);

        $calc = function($avg, $isec) {
            $sum = [];
            foreach ($isec as $v) {
                $sum[] = "($v - $avg)^2";
            }
            return "sqrt(".implode(" + ", $sum).")";
        };

        $r1 = $calc($avg1, $isec1);
        $r2 = $calc($avg2, $isec2);

        $explainer->add("BOTTOM", "{$r1} * {$r2} = {$result}");
    }

}
