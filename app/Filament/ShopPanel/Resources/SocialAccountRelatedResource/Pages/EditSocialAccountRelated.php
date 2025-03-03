<?php

namespace App\Filament\ShopPanel\Resources\SocialAccountRelatedResource\Pages;

use App\Filament\ShopPanel\Resources\SocialAccountRelatedResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditSocialAccountRelated extends EditRecord
{
    protected static string $resource = SocialAccountRelatedResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
