<?php

namespace App\Filament\Resources\ShopGalleryResource\Pages;

use App\Filament\Resources\ShopGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShopGalleries extends ListRecords
{
    protected static string $resource = ShopGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
