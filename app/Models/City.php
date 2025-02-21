<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;

    protected $fillable=[
        'name',
        'slug',
        'order',
        'is_active',
        'icon',
        'description',
        'latitude',
        'longitude',
        'timezone'
    ];

    // Define parent category relationship
    public function parent()
    {
        return $this->belongsTo(City::class, 'parent_id');
    }

    // Define children categories (subcategories)
    public function children(): HasMany
    {
        return $this->hasMany(City::class, 'parent_id');
    }

    // Override delete method to delete subcategories
    public function delete()
    {
        // Delete category icon from storage
        if ($this->icon) {
            \Storage::disk('public')->delete($this->icon);
        }
        // Delete all subcategories first
        $this->children()->delete();

        // Then delete the category itself
        return parent::delete();
    }
}
