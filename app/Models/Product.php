<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;



    protected $fillable = [
        "shop_id",
        "type",
        "name",
        "description",
        "price",
        "photo",
        "is_active",
        "is_suspended"
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }
}
