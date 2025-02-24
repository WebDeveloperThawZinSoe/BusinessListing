<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ADS extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 
        'link',  
        'type',
        'image',
        'is_active',
    ];

  
    // Override delete method to delete subcategories
    public function delete()
    {
        // Delete category icon from storage
        if ($this->image) {
            \Storage::disk('public')->delete($this->image);
        }
        // // Delete all subcategories first
        // $this->children()->delete();

        // // Then delete the category itself
        return parent::delete();
    }
}
