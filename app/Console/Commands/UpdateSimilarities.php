<?php

namespace App\Console\Commands;

use App\Libraries\PearsonCorrelation;
use App\Models\Book;
use Illuminate\Console\Command;

class UpdateSimilarities extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-similarities {book_id?} {book_id_2?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update similarities';

    protected $results = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->results = [];
        $bookId1 = $this->argument('book_id');
        $bookId2 = $this->argument('book_id_2');

        if ($bookId1) {
            $book1 = Book::findOrFail($bookId1);

            if ($bookId2) {
                $book2 = Book::findOrFail($bookId2);
                return $this->updateSimilarity($book1, $book2);
            }

            return $this->updateBookSimilarities($book1);
        }

        return $this->updateAllSimilarities();
    }

    public function updateAllSimilarities()
    {
        $books = Book::all();
        foreach ($books as $book1) {
            foreach ($books as $book2) {
                if ($book1->getKey() != $book2->getKey()) {
                    $this->updateSimilarity($book1, $book2);
                }
            }
        }
    }

    public function updateBookSimilarities(Book $book1)
    {
        $otherBooks = Book::whereNotIn('book_id', [$book1->getKey()])->get();
        foreach ($otherBooks as $book2) {
            $this->updateSimilarity($book1, $book2);
        }
    }

    public function updateSimilarity(Book $book1, Book $book2)
    {
        list($book1, $book2) = $this->swapIfNeeded($book1, $book2);

        $book1Id = $book1->getKey();
        $book2Id = $book2->getKey();

        $key = "{$book1Id}:{$book2Id}";
        if (isset($this->results[$key])) {
            return;
        }

        $book1Ratings = $book1->ratings->pluck('rating', 'user_id')->toArray();
        $book2Ratings = $book2->ratings->pluck('rating', 'user_id')->toArray();

        $similarity = (new PearsonCorrelation($book1Ratings, $book2Ratings))->calculate();

        $this->info("PC($book1Id, $book2Id) = {$similarity}");

        $this->results[$key] = $similarity;
    }

    public function swapIfNeeded(Book $book1, Book $book2)
    {
        return $book1->getKey() > $book2->getKey()
            ? [$book2, $book1]
            : [$book1, $book2];
    }
}
