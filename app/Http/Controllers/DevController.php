<?php

namespace App\Http\Controllers;

use App\Libraries\ItemBasedCF;
use App\Libraries\PearsonCorrelation;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Book;
use App\Models\Rating;
use App\Models\Prediction;
use Illuminate\Support\Facades\Artisan;

class DevController extends Controller
{
    public function index(Request $request)
    {
        $members = User::where('type', 'member')->orderBy('user_id')->get();
        $books = Book::orderBy('book_id')->take(10)->get();

        $predictions = Prediction::with(['book', 'user'])->get();

        return view('dev.index', [
            'members' => $members,
            'books' => $books,
            'predictions' => $predictions,
        ]);
    }

    public function pearsonCorrelation(Request $request)
    {
        $bookId1 = $request->get('book_id_1');
        $bookId2 = $request->get('book_id_2');

        if (is_numeric($bookId1) && is_numeric($bookId2)) {
            $book1 = Book::findOrFail($bookId1);
            $book2 = Book::findOrFail($bookId2);

            $book1Ratings = $book1->ratings()->pluck('rating', 'user_id')->toArray();
            $book2Ratings = $book2->ratings()->pluck('rating', 'user_id')->toArray();

            $pearsonCorrelation = new PearsonCorrelation($book1Ratings, $book2Ratings);

            $data['explainer'] = $pearsonCorrelation->explain($book1->title, $book2->title);
        }

        $data['books'] = Book::orderBy('title')->get();

        return view('dev.pearson-correlation', $data);
    }

    public function submitRatings(Request $request)
    {
        $this->validate($request, [
            'ratings.*.user_id' => 'required|exists:users,user_id',
            'ratings.*.book_id' => 'required|exists:books,book_id',
            'ratings.*.rating' => 'required|numeric|min:1|max:5',
        ]);

        $ratings = $request->get('ratings');
        $users = User::whereIn('user_id', collect($ratings)->pluck('user_id')->toArray())->get()->keyBy('user_id');
        $books = Book::whereIn('book_id', collect($ratings)->pluck('book_id')->toArray())->get()->keyBy('book_id');

        foreach ($ratings as $rating) {
            $user = $users[$rating['user_id']];
            $book = $books[$rating['book_id']];
            $user->setRating($book, $rating['rating']);
        }

        Artisan::call('update-predictions');

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function resetRatings()
    {
        Rating::truncate();
        Prediction::truncate();

        return response()->json([
            'status' => 'ok'
        ]);
    }

    public function prediction(Request $request)
    {
        $userId = $request->get('user_id');
        $bookId = $request->get('book_id');

        if ($userId && $bookId) {
            $user = User::findOrfail($userId);
            $book = Book::findOrfail($bookId);

            $cf = new ItemBasedCF($user, $book);

            $data['explainer'] = $cf->explain();
        }

        $data['users'] = User::where('type', User::TYPE_MEMBER)->orderBy('name')->get();
        $data['books'] = Book::orderBy('title')->get();

        return view('dev/prediction', $data);
    }
}
