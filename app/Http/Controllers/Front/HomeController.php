<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $popular_products = Product::inRandomOrder()->take(6)->get();
        $newest_products = Product::orderBy('product_id', 'desc')->take(8)->get();

        return view('front.pages.home', [
            'popular_products' => $popular_products,
            'newest_products' => $newest_products,
        ]);
    }
}
