<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Prediction extends Model
{
    public $timestamps = false;

    public static function savePrediction(User $user, Product $product, float $rating)
    {
        $prediction = static::query()
            ->where('user_id', $user->getKey())
            ->where('product_id', $product->getKey())
            ->first();

        if (!$prediction) {
            $prediction = new static;
            $prediction->user_id = $user->getKey();
            $prediction->product_id = $product->getKey();
        }
        $prediction->rating = $rating;

        return $prediction->save();
    }

    public static function removePrediction(User $user, Product $product)
    {
        return static::query()
            ->where('user_id', $user->getKey())
            ->where('product_id', $product->getKey())
            ->delete();
    }

    public function user()
    {
        return $this->hasOne(User::class, 'user_id', 'user_id');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }
}
