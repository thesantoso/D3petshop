<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberProfile extends Model
{
    protected $primaryKey = "user_profile_id";

    protected $fillable = [
        'user_id',
        'birth_date',
        'gender',
        'phone',
    ];

    public function getAgeAttribute()
    {
        return date('Y') - date('Y', strtotime($this->birth_date));
    }
}
