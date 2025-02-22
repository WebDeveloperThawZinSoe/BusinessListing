<?php

namespace App\Filament\Resources\ShopGalleryResource\Pages;

use App\Filament\Resources\ShopGalleryResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShopGallery extends EditRecord
{
    protected static string $resource = ShopGalleryResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
