<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Product;

class RatingController extends Controller
{
    public function rating(Request $request)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,product_id',
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        $user = auth()->user();
        $product = Product::findOrFail($request->get('product_id'));
        $rating = $request->get('rating');

        $user->setRating($product, $rating);

        return response()->json([
            'status' => 'success'
        ]);
    }
}
