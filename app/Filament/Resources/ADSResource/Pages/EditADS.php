<?php

namespace App\Filament\Resources\ADSResource\Pages;

use App\Filament\Resources\ADSResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditADS extends EditRecord
{
    protected static string $resource = ADSResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
