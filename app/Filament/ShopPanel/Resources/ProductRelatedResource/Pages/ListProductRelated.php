<?php

namespace App\Filament\ShopPanel\Resources\ProductRelatedResource\Pages;

use App\Filament\ShopPanel\Resources\ProductRelatedResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListProductRelated extends ListRecords
{
    protected static string $resource = ProductRelatedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
