<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    public $timestamps = false;

    public function getSubtotalLabelAttribute()
    {
        return number_format($this->qty * $this->price, 0, ',', '.');
    }

    public function getPriceLabelAttribute()
    {
        return number_format($this->price, 0, ',', '.');
    }

    public function product()
    {
        return $this->hasOne(Product::class, 'product_id', 'product_id');
    }
}
