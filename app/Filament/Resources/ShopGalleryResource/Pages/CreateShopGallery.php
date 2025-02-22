<?php

namespace App\Filament\Resources\ShopGalleryResource\Pages;

use App\Filament\Resources\ShopGalleryResource;
use App\Models\ShopGallery;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Actions\RedirectAction;

class CreateShopGallery extends CreateRecord
{
    protected static string $resource = ShopGalleryResource::class;

    protected function handleRecordCreation(array $data): Model
    {
        $photos = $data['photos'] ?? []; // Get uploaded images

        // Store images in the database
        foreach ($photos as $photo) {
            ShopGallery::create([
                'shop_id' => $data['shop_id'],
                'title'   => $data['title'],
                'photo'   => $photo, // Save each image separately
            ]);
        }

        // Return the first created ShopGallery record (or any single record if you prefer)
        return ShopGallery::first(); // Make sure to return a model instance here
    }

    protected function afterSave()
    {
        // Redirect after saving the model
        return redirect()->route('filament.resources.shop-galleries.index');
    }
}
