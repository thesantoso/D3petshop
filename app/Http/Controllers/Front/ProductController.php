<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\ProductCategory;
use App\Models\Prediction;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::query();

        $keyword = $request->get('keyword');
        if ($keyword) {
            $query->where(function($q) use ($keyword) {
                $q->where('title', 'like', "%{$keyword}%");
                $q->orWhere('description', 'like', "%{$keyword}%");
            });
        }

        $category_slug = $request->get('category');
        if ($category_slug) {
            $category = Category::where('slug', $category_slug)->first();
            if ($category) {
                $product_ids = ProductCategory::where('category_id', $category->getKey())->pluck('product_id')->toArray();
                if ($product_ids) {
                    $query->whereIn('product_id', $product_ids);
                } else {
                    $query->where('product_id', 0);
                }
            }
        }

        $products = $query->paginate(12);
        $categories = Category::orderBy('name')->get();

        if (auth()->id()) {
            $recommendation = Prediction::with('product')
                ->where('user_id', auth()->id())
                ->where('rating', '>', 3)
                ->orderBy('rating', 'desc')
                ->first();
        } else {
            $recommendation = null;
        }

        return view('front.pages.product.index', [
            'products' => $products,
            'categories' => $categories,
            'recommendation' => $recommendation,
        ]);
    }

    public function show(Request $request, $slug)
    {
        $product = Product::where('slug', $slug)->first();
        if (!$product) {
            return abort(404, "Produk tidak ditemukan.");
        }

        $other_products = Product::whereNotIn('product_id', [$product->product_id])
            ->inRandomOrder()
            ->take(6)
            ->get();

        return view('front.pages.product.show', [
            'product' => $product,
            'other_products' => $other_products,
        ]);
    }
}
