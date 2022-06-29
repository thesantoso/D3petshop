<?php

namespace App\Console\Commands;

use App\Libraries\ItemBasedCF;
use App\Models\Book;
use App\Models\Prediction;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Console\Command;

class UpdatePredictions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'update-predictions {user_id?} {book_id?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update prediction data';

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
        $userId = $this->argument("user_id");
        $bookId = $this->argument("book_id");

        if ($userId) {
            $user = User::findOrFail($userId);
            if ($bookId) {
                $book = Book::findOrFail($bookId);
                return $this->updatePrediction($user, $book);
            }

            return $this->updateUserPredictions($user);
        }

        return $this->updateAllPredictions();
    }

    public function updateAllPredictions()
    {
        Prediction::truncate();
        $users = User::where('type', User::TYPE_MEMBER)->get();
        $books = Book::all();
        foreach ($users as $user) {
            foreach ($books as $book) {
                $this->updatePrediction($user, $book);
            }
        }
    }

    public function updateUserPredictions(User $user)
    {
        $books = Book::all();
        foreach ($books as $book) {
            $this->updatePrediction($user, $book);
        }
    }

    public function updatePrediction(User $user, Book $book)
    {
        if ($this->userHasRating($user, $book)) {
            return $this->removePrediction($user, $book);
        }

        $cf = new ItemBasedCF($user, $book);
        $prediction = $cf->predict();

        Prediction::savePrediction($user, $book, $prediction);

        $userId = $user->getKey();
        $bookId = $book->getKey();
        $this->info("Set prediction user:$userId book:$bookId = $prediction");
    }

    public function userHasRating(User $user, Book $book)
    {
        return Rating::query()
            ->where('user_id', $user->getKey())
            ->where('book_id', $book->getKey())
            ->count() > 0;
    }

    public function removePrediction(User $user, Book $book)
    {
        $userId = $user->getKey();
        $bookId = $book->getKey();
        Prediction::removePrediction($user, $book);
        $this->warn("Remove prediction user:{$userId} book:$bookId");
    }
}
