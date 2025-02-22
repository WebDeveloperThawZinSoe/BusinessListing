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
        Schema::create('shop_galleries', function (Blueprint $table) {
            $table->id();
            $table->foreignId("shop_id")->nullable()->constrained("shops")->cascadeOnDelete();
            $table->string("title")->nullable();
            $table->text("photo");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_galleries');
    }
};
