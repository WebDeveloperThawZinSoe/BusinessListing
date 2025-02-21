<?php

namespace App\Filament\Resources\ADSResource\Pages;

use App\Filament\Resources\ADSResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListADS extends ListRecords
{
    protected static string $resource = ADSResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
