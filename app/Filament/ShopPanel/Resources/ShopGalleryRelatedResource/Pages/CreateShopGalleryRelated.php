<?php

namespace App\Filament\ShopPanel\Resources\ShopGalleryRelatedResource\Pages;

use App\Filament\ShopPanel\Resources\ShopGalleryRelatedResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Models\ShopGallery;
use Illuminate\Database\Eloquent\Model;

class CreateShopGalleryRelated extends CreateRecord
{
    protected static string $resource = ShopGalleryRelatedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\Action::make('Create Other')
                ->url(fn () => ShopGalleryRelatedResource::getUrl('create'))
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
