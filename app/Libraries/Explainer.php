<?php

namespace App\Libraries;

class Explainer
{

    protected $explanations = [];

    public function add($title, $detail)
    {
        $this->explanations[] = [
            "title" => $title,
            "detail" => $detail,
        ];
    }

    public function addTable($title, array $heads, array $rows)
    {
        $row = function($data, $tag = "td") {
            $tr = "<tr>";
            foreach ($data as $d) {
                $tr .= "<{$tag}>{$d}</{$tag}>";
            }
            $tr .= "</tr>";
            return $tr;
        };

        $tbodyRows = array_map(function($data) use ($row) {
            return $row($data);
        }, $rows);

        $thead = "<thead>".$row($heads)."</thead>";
        $tbody = "<tbody>".implode("", $tbodyRows)."</tbody>";

        $detail = "
            <table class='table table-bordered table-hover'>
                {$thead}
                {$tbody}
            </table>
        ";

        return $this->add($title, $detail);
    }

    public function getExplanations()
    {
        return $this->explanations;
    }

}
