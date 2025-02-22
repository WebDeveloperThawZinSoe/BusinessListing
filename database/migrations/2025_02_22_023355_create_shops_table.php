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
        Schema::create('shops', function (Blueprint $table) {
            $table->id();
            $table->foreignId("user_id")->nullable()->constrained("users")->cascadeOnDelete();
            $table->foreignId("city_id")->nullable()->constrained("cities")->nullOnDelete();
            $table->foreignId("category_id")->nullable()->constrained("categories")->nullOnDelete();
            $table->string("name");
            $table->string("slug")->unique();
            $table->text("description")->nullable();
            $table->string("profile_photo")->nullable();
            $table->string("cover_photo")->nullable();
            $table->string("type");
            $table->string("address")->nullable();
            $table->string("latitude")->nullable();
            $table->string("longitude")->nullable();
            $table->boolean("is_active")->default(true);
            $table->boolean("is_recommanded")->default(false);
            $table->boolean("is_verified")->default(false);
            $table->boolean("is_featured")->default(false);
            $table->boolean("is_suspended")->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shops');
    }
};
