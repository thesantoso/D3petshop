<?php

namespace App\Http\Controllers\Front;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\CartRepository;

class CartController extends Controller
{
    public function items(Request $request, CartRepository $cart)
    {
        $items = $cart->all();

        return response()->json([
            'items' => collect($items)->map(function($item) {
                return [
                    'product' => [
                        'product_id' => (int) $item['product']->product_id,
                        'title' => $item['product']->title,
                        'url_cover' => $item['product']->url_cover,
                        'url_show' => $item['product']->url_show,
                        'price' => (int) $item['product']->price,
                        'stock' => (int) $item['product']->stock,
                    ],
                    'qty' => (int) $item['qty']
                ];
            })
        ]);
    }

    public function add(Request $request, CartRepository $cart)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,product_id'
        ]);

        $cart->add($request->get('product_id'));
        return response()->json([
            'message' => 'ok'
        ]);
    }

    public function update(Request $request, CartRepository $cart)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,product_id',
            'qty' => 'required|numeric'
        ]);

        $cart->setQty($request->get('product_id'), $request->get('qty'));
        return response()->json([
            'message' => 'ok'
        ]);
    }

    public function delete(Request $request, CartRepository $cart)
    {
        $this->validate($request, [
            'product_id' => 'required|exists:products,product_id',
        ]);

        $cart->remove($request->get('product_id'));
        return response()->json([
            'message' => 'ok'
        ]);
    }
}
