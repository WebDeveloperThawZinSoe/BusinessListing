<?php

namespace App\Filament\ShopPanel\Resources\ProductRelatedResource\Pages;

use App\Filament\ShopPanel\Resources\ProductRelatedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditProductRelated extends EditRecord
{
    protected static string $resource = ProductRelatedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
