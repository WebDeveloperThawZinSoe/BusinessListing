<?php

namespace App\Filament\ShopPanel\Resources\ShopGalleryRelatedResource\Pages;

use App\Filament\ShopPanel\Resources\ShopGalleryRelatedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShopGalleryRelated extends ListRecords
{
    protected static string $resource = ShopGalleryRelatedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
