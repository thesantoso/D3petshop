<?php

namespace App\Models;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const TYPE_MEMBER = 'member';
    const TYPE_ADMIN = 'admin';

    const STATUS_PENDING = 'pending';
    const STATUS_ACTIVE = 'active';
    const STATUS_BLOCKED = 'blocked';

    protected $primaryKey = "user_id";

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'type',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getUrlAvatarAttribute()
    {
        return "https://www.fiaregion1.com/wp-content/uploads/2018/06/gdpr_profile-picture.jpg";
    }

    public function isAdmin()
    {
        return $this->type == static::TYPE_ADMIN;
    }

    public function isMember()
    {
        return $this->type == static::TYPE_MEMBER;
    }

    public function getRating(Product $product)
    {
        $rating = $this->ratings()->where('product_id', $product->product_id)->first();
        return (int) ($rating ? $rating->rating : null);
    }

    public function setRating(Product $product, int $num)
    {
        $rating = $this->ratings()->where('product_id', $product->product_id)->first();
        if (!$rating) {
            $rating = new Rating;
            $rating->product_id = $product->product_id;
            $rating->user_id = $this->user_id;
        }
        $rating->rating = $num;
        return $rating->save();
    }

    public function member_profile()
    {
        return $this->hasOne(MemberProfile::class, 'user_id', 'user_id');
    }

    public function member_addresses()
    {
        return $this->hasMany(MemberAddress::class, 'user_id', 'user_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'member_user_id', 'user_id');
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class, 'user_id', 'user_id');
    }
}
