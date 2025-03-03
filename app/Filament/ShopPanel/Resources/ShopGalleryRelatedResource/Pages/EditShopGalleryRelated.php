<?php

namespace App\Filament\ShopPanel\Resources\ShopGalleryRelatedResource\Pages;

use App\Filament\ShopPanel\Resources\ShopGalleryRelatedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShopGalleryRelated extends EditRecord
{
    protected static string $resource = ShopGalleryRelatedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
