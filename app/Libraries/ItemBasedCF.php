<?php

namespace App\Libraries;

use App\Models\Book;
use App\Models\User;
use Illuminate\Support\Arr;

class ItemBasedCF
{
    public function __construct(User $user, Book $book, $countNeighbors = 2)
    {
        $this->user = $user;
        $this->book = $book;
        $this->countNeighbors = $countNeighbors;
    }

    public function predict()
    {
        $user = $this->user;
        $book = $this->book;
        $countNeighbors = $this->countNeighbors;

        // Step 1: menghitung similaritas buku yang ingin diprediksi dengan buku-buku lain
        $similarities = $this->getSimilarities($book);

        // Step 2: mencari tahu neighbors
        $userRatings = $user->ratings()->pluck('rating', 'book_id')->toArray();
        $neighbors = $this->getNeighbors($similarities, $userRatings, $countNeighbors);

        // Step 3: menghitung prediksi dengan weighted sum terhadap neighbors dan userRatings
        $prediction = $this->calculateWeightedSum($neighbors, $userRatings);

        return $prediction;
    }

    public function getSimilarities(Book $book)
    {
        $otherBooks = Book::whereNotIn('book_id', [$book->getKey()])->get();
        $sims = [];
        $bookRatings = $book->ratings()->pluck('rating', 'user_id')->toArray();

        foreach ($otherBooks as $otherBook) {
            $otherBookRatings = $otherBook->ratings()->pluck('rating', 'user_id')->toArray();

            $pearsonCorrelation = new PearsonCorrelation($bookRatings, $otherBookRatings);
            $sims[$otherBook->getKey()] = $pearsonCorrelation->calculate();
        }
        return $sims;
    }

    public function getNeighbors($similarities, $userRatings, $countNeighbors)
    {
        // Hapus similarities <= 0
        $similarities = array_filter($similarities, function($sim) {
            return $sim > 0;
        });

        // Ambil similaritas dari buku yang pernah dirating user saja
        $hasRatingBookIds = array_keys($userRatings);
        $similarities = Arr::only($similarities, $hasRatingBookIds);

        // Urutkan similaritas dari yang tertinggi
        uasort($similarities, function($a, $b) {
            return $b > $a;
        });

        // Kembalikan sebanyak jumlah yang ditentukan
        return array_slice($similarities, 0, $countNeighbors, true);
    }

    public function calculateWeightedSum($neighbors, $userRatings)
    {
        $top = 0;
        $bottom = 0;

        foreach ($neighbors as $bookId => $sim) {
            $rating = $userRatings[$bookId];
            $top += ($rating * $sim);
            $bottom += abs($sim);
        }

        if ($bottom == 0) {
            return 0;
        }

        return $top / $bottom;
    }

    /**
     * @return Explainer
     */
    public function explain()
    {
        $explainer = new Explainer;

        $user = $this->user;
        $book = $this->book;
        $countNeighbors = $this->countNeighbors;
        $userRatings = $user->ratings()->pluck('rating', 'book_id')->toArray();
        $bookId = $book->getKey();

        $inputs = [
            ["user", $user->name],
            ["book", $book->title],
            ["countNeighbours", $countNeighbors],
        ];
        $explainer->addTable("INPUT", ["Parameter", "Value"], $inputs);

        // Step 1: menghitung similaritas buku yang ingin diprediksi dengan buku-buku lain
        $similarities = $this->getSimilarities($book);
        $sims = [];
        foreach ($similarities as $otherBookId => $sim) {
            $sims[] = [$bookId, $otherBookId, $sim, Arr::get($userRatings, $otherBookId)];
        }
        $explainer->addTable("BOOK SIMILARITIES", ["book_id", "other_book_id", "similarity", "user_rating"], $sims);

        // Step 2: mencari tahu neighbors
        $neighbors = $this->getNeighbors($similarities, $userRatings, $countNeighbors);
        $nhs = [];
        foreach ($neighbors as $otherBookId => $sim) {
            $nhs[] = [$bookId, $otherBookId, $sim, Arr::get($userRatings, $otherBookId)];
        }
        $explainer->addTable("NEIGHBORS", ["book_id", "other_book_id", "similarity", "user_rating"], $nhs);

        // Step 3: menghitung prediksi dengan weighted sum terhadap neighbors dan userRatings
        $prediction = $this->calculateWeightedSum($neighbors, $userRatings);
        $this->explainWeightedSum($explainer, $neighbors, $userRatings);

        return $explainer;
    }

    public function explainWeightedSum(Explainer $explainer, $neighbors, $userRatings)
    {
        $result = $this->calculateWeightedSum($neighbors, $userRatings);
        $top = [];
        $bottom = [];

        foreach ($neighbors as $bookId => $sim) {
            $rating = $userRatings[$bookId];
            $top[] = "($rating * $sim)";
            $bottom[] = "|{$sim}|";
        }

        $explainer->add("WEIGHTED SUM", "(".implode(" + ", $top).') / ('.implode(" + ", $bottom).") = {$result}");
    }
}
