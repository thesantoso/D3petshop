<?php

namespace App\Models;

use App\Libraries\PearsonCorrelation;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $primaryKey = "product_id";

    public function getUrlCoverAttribute()
    {
        return asset('uploads/products/'.$this->cover);
    }

    public function getCategoryAttribute()
    {
        return $this->categories()->first();
    }

    public function getCategoryNameAttribute()
    {
        $category = $this->category;
        return $category ? $category->name : null;
    }

    public function getUrlShowAttribute()
    {
        return route('front::products.show', ['slug' => $this->slug]);
    }

    public function getPriceLabelAttribute()
    {
        return "Rp ".number_format($this->price, 0, ',', '.');
    }

    public function getStockLabelAttribute()
    {
        return number_format($this->stock, 0, ',', '.');
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_categories', 'product_id', 'category_id');
    }

    public function getPearsonCorrelation(Product $other)
    {
        $productRatings = $this->ratings()->pluck('rating', 'user_id')->toArray();
        $otherRatings = $other->ratings()->pluck('rating', 'user_id')->toArray();

        $pc = new PearsonCorrelation($productRatings, $otherRatings);
        return $pc->calculate();
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'product_id', 'product_id');
    }
}
