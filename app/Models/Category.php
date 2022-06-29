<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $primaryKey = "category_id";

    public function product()
    {
        $this->belongsToMany(Product::class, 'product_categories', 'category_id', 'product_id');
    }
}
