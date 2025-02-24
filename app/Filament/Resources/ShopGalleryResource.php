<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShopGalleryResource\Pages;
use App\Filament\Resources\ShopGalleryResource\RelationManagers;
use App\Models\ShopGallery;
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

class ShopGalleryResource extends Resource
{
    protected static ?string $model = ShopGallery::class;

    protected static ?string $navigationIcon = 'heroicon-c-camera';

    protected static ?int $navigationSort = 14;

    public static function form(Form $form): Form
    {
        $isEditPage = request()->route()->getName() === 'filament.resources.shop-galleries.edit';

        return $form
            ->schema([
                Select::make('shop_id')
                    ->relationship('shop', 'name')
                    ->required()
                    ->searchable(),
                TextInput::make('title')
                    ->nullable()
                    ->maxLength(255),
    
                // Conditionally apply 'multiple' based on the current route
                FileUpload::make('photos')
                ->required()
                ->image()
                ->multiple(!$isEditPage) // Allow multiple files only if not on the edit page
                ->maxFiles($isEditPage ? 1 : 10) // Allow 1 file for editing, 10 for creating
                ->preserveFilenames(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shop.name')->sortable()->searchable(),
                TextColumn::make('title')->sortable()->searchable(),
                ImageColumn::make('photo')
            ])
            ->filters([
                SelectFilter::make('Shop')
                ->relationship('shop', 'name'),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
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
            'index' => Pages\ListShopGalleries::route('/'),
            'create' => Pages\CreateShopGallery::route('/create'),
            'edit' => Pages\EditShopGallery::route('/{record}/edit'),
        ];
    }
}
