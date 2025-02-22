<?php

namespace App\Filament\Resources;

use App\Filament\Resources\SocialAccountResource\Pages;
use App\Filament\Resources\SocialAccountResource\RelationManagers;
use App\Models\SocialAccount;
use App\Models\Shop;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Forms\Components\RichEditor;

class SocialAccountResource extends Resource
{
    protected static ?string $model = SocialAccount::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('shop_id')
                    ->label('Shop')
                    ->nullable()
                    ->options(fn () => Shop::pluck('name', 'id')->toArray())
                    ->searchable(),
                Select::make('account')
                    ->label('Social Media Account')
                    ->options([
                        'email' => 'Email',
                        'phone' => 'Phone',
                        'facebook' => 'Facebook',
                        'messenger' => 'Messenger',
                        'instagram' => 'Instagram',
                        'twitter' => 'Twitter (X)',
                        'tiktok' => 'TikTok',
                        'youtube' => 'YouTube',
                        'linkedin' => 'LinkedIn',
                        'viber' => 'Viber',
                        'wechat' => 'WeChat',
                        'telegram' => 'Telegram',
                    ])
                    ->searchable()
                    ->required(),
                TextInput::make('link')
                    ->label('Profile/Channel Link')
                    ->required(),
                    Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('shop.name')
                ->label('Shop')
                ->sortable(),
            TextColumn::make('account')
                ->label('Social Media'),
            TextColumn::make('link')
                ->label('Profile/Channel Link')
                ->url(fn ($record) => $record->link)
                ->limit(50),
            Tables\Columns\BooleanColumn::make('is_active')
                ->sortable()
                ->label('Active'),
        ])
        ->filters([
            // Add filters if needed
        ])
        ->actions([
            Tables\Actions\EditAction::make(),
            Tables\Actions\DeleteAction::make(),
        ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListSocialAccounts::route('/'),
            'create' => Pages\CreateSocialAccount::route('/create'),
            'edit' => Pages\EditSocialAccount::route('/{record}/edit'),
        ];
    }
}
