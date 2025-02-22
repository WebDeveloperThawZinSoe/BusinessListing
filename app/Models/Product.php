<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // $table->foreignId("shop_id")->nullable()->constrained("shops")->cascadeOnDelete();
    // $table->string("type")->default("product");
    // $table->string("name");
    // $table->text("description")->nullable();
    // $table->string("price")->default(0);
    // $table->text("photo")->nullable();
    // $table->boolean("is_active")->default(true);
    // $table->boolean("is_suspended")->default(false);

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
