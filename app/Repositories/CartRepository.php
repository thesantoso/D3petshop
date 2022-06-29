<?php

namespace App\Repositories;

use App\Models\Product;

class CartRepository
{
    public function all()
    {
        $items = $this->getItems();
        $product_ids = array_keys($items);

        if (empty($product_ids)) {
            return [];
        }

        $products = Product::whereIn('product_id', $product_ids)->get()->keyBy('product_id');

        $results = [];
        foreach ($products as $product) {
            $results[] = [
                'product' => $product,
                'qty' => array_get($items, $product->getKey()),
            ];
        }

        return $results;
    }

    public function add($product_id)
    {
        $items = $this->getItems();
        $qty = array_get($items, $product_id, 0);

        return $this->setQty($product_id, $qty + 1);
    }

    public function setQty($product_id, $qty)
    {
        if ($qty == 0) {
            return $this->remove($product_id);
        }

        $items = $this->getItems();
        $items[$product_id] = $qty;

        $this->saveItems($items);
    }

    public function remove($product_id)
    {
        $items = $this->getItems();
        if (isset($items[$product_id])) {
            unset($items[$product_id]);
        }

        $this->saveItems($items);
    }

    public function clear()
    {
        session()->forget('cart');
    }

    public function saveItems(array $items)
    {
        session()->put('cart', $items);
    }

    public function getItems()
    {
        return session('cart') ?: [];
    }
}
