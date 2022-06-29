<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Order extends Model
{
    const STATUS_PENDING = 'pending';
    const STATUS_PROCESSING = 'processing';
    const STATUS_SHIPPING = 'shipping';
    const STATUS_FINISH = 'finish';
    const STATUS_CANCELED = 'canceled';
    const STATUS_EXPIRED = 'expired';

    protected $primaryKey = "order_id";

    public static function generateCode()
    {
        do {
            $code = date('ymd') . strtoupper(str_random(3));
        } while (static::where('code', $code)->count() > 0);

        return $code;
    }

    public function getDetailsAmountAttribute()
    {
        $data = OrderDetail::where('order_id', $this->order_id)->select(DB::raw('sum(price * qty) as details_amount'))->first();
        return (int) $data->details_amount;
    }

    public function getTotalAmountAttribute()
    {
        return $this->details_amount + $this->shipping_cost;
    }

    public function getDetailsAmountLabelAttribute()
    {
        return number_format($this->details_amount, 0, ',', '.');
    }

    public function getTotalAmountLabelAttribute()
    {
        return number_format($this->total_amount, 0, ',', '.');
    }

    public function getShippingCostLabelAttribute()
    {
        return number_format($this->shipping_cost, 0, ',', '.');
    }

    public function getMemberNameAttribute()
    {
        return $this->member ? $this->member->name : '';
    }

    public function getMemberEmailAttribute()
    {
        return $this->member ? $this->member->email : null;
    }

    public function getProvinceNameAttribute()
    {
        return $this->province ? $this->province->name : null;
    }

    public function getRegencyNameAttribute()
    {
        return $this->regency ? $this->regency->name : null;
    }

    public function getDistrictNameAttribute()
    {
        return $this->district ? $this->district->name : null;
    }

    public function getSubdistrictNameAttribute()
    {
        return $this->subdistrict ? $this->subdistrict->name : null;
    }

    public function details()
    {
        return $this->hasMany(OrderDetail::class, 'order_id', 'order_id');
    }

    public function member()
    {
        return $this->hasOne(User::class, 'user_id', 'member_user_id');
    }

    public function member_address()
    {
        return $this->hasOne(MemberAddress::class, 'member_address_id', 'member_address_id');
    }

    public function province()
    {
        return $this->hasOne(Province::class, 'id', 'province_id');
    }

    public function regency()
    {
        return $this->hasOne(Regency::class, 'id', 'regency_id');
    }

    public function district()
    {
        return $this->hasOne(District::class, 'id', 'district_id');
    }

    public function subdistrict()
    {
        return $this->hasOne(Subdistrict::class, 'id', 'subdistrict_id');
    }

    public function payment_confirmations()
    {
        return $this->hasMany(PaymentConfirmation::class, 'order_id', 'order_id');
    }
}
