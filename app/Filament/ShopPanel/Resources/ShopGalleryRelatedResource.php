<?php

namespace App\Filament\ShopPanel\Resources;

use App\Filament\ShopPanel\Resources\ShopGalleryRelatedResource\Pages;
use App\Filament\ShopPanel\Resources\ShopGalleryRelatedResource\RelationManagers;
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
use Illuminate\Support\Facades\Auth;

class ShopGalleryRelatedResource extends Resource
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
                ->multiple(!$isEditPage)
                ->maxFiles($isEditPage ? 1 : 10)
                ->preserveFilenames(false) // This ensures unique names
                ->storeFileNamesIn('photos') // Optionally store the names in the database
                ->directory('shop-gallery') // Store files in a dedicated directory
                ->getUploadedFileNameForStorageUsing(fn ($file) => uniqid() . '.' . $file->getClientOriginalExtension()),            
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
            ->defaultSort('created_at', 'desc')
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

    public static function getEloquentQuery(): Builder
    {
        // Ensure that the user can only access products related to their own shops
        $shopIds = Auth::user()->shops->pluck('id');  // Fetch the shop IDs for the authenticated user
        
        return parent::getEloquentQuery()
            ->whereIn('shop_id', $shopIds);  // Only products related to the authenticated user's shops
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
            'index' => Pages\ListShopGalleryRelated::route('/'),
            'create' => Pages\CreateShopGalleryRelated::route('/create'),
            'edit' => Pages\EditShopGalleryRelated::route('/{record}/edit'),
        ];
    }
}
