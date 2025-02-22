<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShopResource\Pages;
use App\Filament\Resources\ShopResource\RelationManagers;
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

class ShopResource extends Resource
{
    protected static ?string $model = Shop::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 3;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('user_id')
            ->relationship('user', 'name', function ($query) {
                return $query->whereHas('roles', function ($q) {
                    $q->where('name', 'shop'); // Only users with "shop" role
                });
            })
            ->searchable()
            ->required(),        
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
                ->unique()
                ->required()
                ->maxLength(255),
            RichEditor::make('description')
                ->toolbarButtons([
                    'bold', 'italic', 'underline', 'strike',
                    'h2', 'h3', 'blockquote',
                    'bulletList', 'orderedList',
                    'link', 'codeBlock'
                ])
                ->columnSpanFull(),
            FileUpload::make('profile_photo')
                ->image()
                ->nullable(),
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
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('user.name')->label('User')->sortable(),
                TextColumn::make('city.name')->label('City')->sortable(),
                TextColumn::make('category.title')->label('Category')->sortable(),
                TextColumn::make('name')->sortable()->searchable(),
                ImageColumn::make('profile_photo')->label('Profile Photo'),
                TextColumn::make('type')->sortable(),
                TextColumn::make('address')->searchable(),
                Tables\Columns\BooleanColumn::make('is_active')
                    ->sortable()
                    ->label('Active'),
                TextColumn::make('created_at')->dateTime()->sortable(),
            ])
            ->filters([
                SelectFilter::make('city_id')
                    ->relationship('city', 'name'),
                SelectFilter::make('category_id')
                    ->relationship('category', 'title'),
                Tables\Filters\Filter::make('Active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
                Tables\Filters\Filter::make('Inactive')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', false)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
            'index' => Pages\ListShops::route('/'),
            'create' => Pages\CreateShop::route('/create'),
            'edit' => Pages\EditShop::route('/{record}/edit'),
        ];
    }
}
