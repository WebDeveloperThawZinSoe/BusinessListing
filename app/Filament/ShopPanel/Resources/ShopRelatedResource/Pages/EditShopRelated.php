<?php

namespace App\Filament\ShopPanel\Resources\ShopRelatedResource\Pages;

use App\Filament\ShopPanel\Resources\ShopRelatedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditShopRelated extends EditRecord
{
    protected static string $resource = ShopRelatedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
