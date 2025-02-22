<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SocialAccount extends Model
{
    use HasFactory;

    protected $fillable=[
        'shop_id',
        'account',
        'link',
        'is_active',
    ];

    public function shop()
    {
        return $this->belongsTo(Shop::class);
    }

}
