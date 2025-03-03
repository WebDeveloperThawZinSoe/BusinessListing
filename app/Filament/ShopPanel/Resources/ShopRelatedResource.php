<?php

namespace App\Filament\ShopPanel\Resources;

use App\Filament\ShopPanel\Resources\ShopRelatedResource\Pages;
use App\Filament\ShopPanel\Resources\ShopRelatedResource\RelationManagers;
use App\Models\Shop;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Illuminate\Support\Facades\Auth;
use Filament\Facades\Filament;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\RichEditor;

class ShopRelatedResource extends Resource
{
    protected static ?string $model = Shop::class;
    protected static ?string $navigationIcon = 'heroicon-c-shopping-bag';
  
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Hidden::make('user_id')
                ->default(Auth::id()),     
                Select::make('city_id')
                    ->relationship('city', 'name')
                    ->searchable()
                    ->required(),
                Select::make('category_id')
                    ->relationship('category', 'title')
                    ->searchable()
                    ->required(),
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('slug')
                    ->unique(Shop::class, 'slug', fn ($record) => $record)
                    ->required()
                    ->maxLength(255),
                RichEditor::make('description')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'blockquote',
                        'bulletList', 'orderedList',
                        'link', 'codeBlock'
                    ])
                    ->columnSpanFull(),
                FileUpload::make('profile_photo')
                    ->image()
                    ->required(),
                FileUpload::make('cover_photo')
                    ->image()
                    ->nullable(),
                TextInput::make('type')
                    ->required()
                    ->maxLength(255),
                TextInput::make('address')
                    ->nullable()
                    ->maxLength(255),
                TextInput::make('latitude')
                    ->nullable()
                    ->maxLength(255),
                TextInput::make('longitude')
                    ->nullable()
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
                Forms\Components\Toggle::make('is_recommanded')
                ->default(false)
                ->hidden(),
                Forms\Components\Toggle::make('is_verified')
                ->default(false)
                ->hidden(),
                Forms\Components\Toggle::make('is_featured')
                ->default(false)
                ->hidden(),
                Forms\Components\Toggle::make('is_suspended')
                ->default(false)
                ->hidden(),
            ]);
    }

    public static function table(Tables\Table $table): Tables\Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->sortable()->searchable(),
                Tables\Columns\TextColumn::make('city.name')->sortable(),
                Tables\Columns\TextColumn::make('category.title')->sortable(),
                ImageColumn::make('profile_photo')->circular(),
                Tables\Columns\BooleanColumn::make('is_active')->boolean(),
                Tables\Columns\BooleanColumn::make('is_verified')->boolean(),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ]);
    }
    

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()->where('user_id', Auth::id());
    }

    public static function getRelations(): array
    {
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShopRelated::route('/'),
            'create' => Pages\CreateShopRelated::route('/create'),
            'edit' => Pages\EditShopRelated::route('/{record}/edit'),
        ];
    }
}
