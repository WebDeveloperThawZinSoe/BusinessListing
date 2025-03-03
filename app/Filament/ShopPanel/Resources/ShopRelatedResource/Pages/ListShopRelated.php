<?php

namespace App\Filament\ShopPanel\Resources\ShopRelatedResource\Pages;

use App\Filament\ShopPanel\Resources\ShopRelatedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShopRelated extends ListRecords
{
    protected static string $resource = ShopRelatedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
