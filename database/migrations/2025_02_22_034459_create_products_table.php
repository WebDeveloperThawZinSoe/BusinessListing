<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId("shop_id")->nullable()->constrained("shops")->cascadeOnDelete();
            $table->string("type")->default("product");
            $table->string("name");
            $table->text("description")->nullable();
            $table->string("price")->default(0);
            $table->text("photo")->nullable();
            $table->boolean("is_active")->default(true);
            $table->boolean("is_suspended")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
