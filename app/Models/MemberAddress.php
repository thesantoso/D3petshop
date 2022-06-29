<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberAddress extends Model
{
    protected $primaryKey = "member_address_id";

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

    public function shipping_cost()
    {
        return $this->hasOne(ShippingCost::class, 'regency_id', 'regency_id');
    }
}
