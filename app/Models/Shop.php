<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shop extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "city_id",
        "category_id",
        "name",
        "slug",
        "description",
        "profile_photo",
        "cover_photo",
        "type",
        "address",
        "latitude",
        "longitude",
        "is_active",
        "is_recommanded",
        "is_verified",
        "is_featured",
        "is_suspended",
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function socialAccounts()
    {
        return $this->hasMany(SocialAccount::class);
    }


    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
