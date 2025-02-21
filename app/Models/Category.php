<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'slug',  
        'parent_id',
        'order',
        'icon',
        'is_active',
        'description'
    ];

    // Define parent category relationship
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    // Define children categories (subcategories)
    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
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

