<?php

namespace App\Filament\Resources\ShopGalleryResource\Pages;

use App\Filament\Resources\ShopGalleryResource;
use App\Models\ShopGallery;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;
use Filament\Actions;

class CreateShopGallery extends CreateRecord
{
    protected static string $resource = ShopGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Create Other')
                ->url(fn () => ShopGalleryResource::getUrl('create'))
                ->icon('heroicon-o-plus')
                ->button(),
        ];
    }

    protected function handleRecordCreation(array $data): Model
    {
        $photos = $data['photos'] ?? []; // Get uploaded images

        $lastCreated = null; // Track the last created record

        foreach ($photos as $photo) {
            $lastCreated = ShopGallery::create([
                'shop_id' => $data['shop_id'],
                'title'   => $data['title'],
                'photo'   => $photo, // Save each image separately
            ]);
        }

        return $lastCreated; // Return the last created model
    }

    protected function getRedirectUrl(): string
    {
        // Redirect to the table (list view) after creation
        return $this->getResource()::getUrl('index');
    }
}
