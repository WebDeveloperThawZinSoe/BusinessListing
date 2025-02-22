<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
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
use Filament\Forms\Components\Toggle;
use Filament\Forms\Components\FileUpload;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\RichEditor;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            Select::make('shop_id')
                ->relationship('shop', 'name')
                ->required()
                ->searchable(),
            TextInput::make('name')
                ->required()
                ->maxLength(255),
            // Select box for predefined types
            Select::make('type')
            ->label('Select Type')
            ->options([
                'product' => 'Product',
                'service' => 'Service'
            ])
            ->default('product') // Set default value
            ->required(),
            RichEditor::make('description')
            ->toolbarButtons([
                'bold', 'italic', 'underline', 'strike',
                'h2', 'h3', 'blockquote',
                'bulletList', 'orderedList',
                'link', 'codeBlock', 'image'
            ])
            ->fileAttachmentsDisk('public') // Store images in the public disk
            ->fileAttachmentsDirectory('uploads/products') // Specify the directory
            ->fileAttachmentsVisibility('public') // Ensure visibility
            ->columnSpanFull(),
        

            TextInput::make('price')
                ->numeric()
                ->required(),
            FileUpload::make('photo')
                ->required()
                ->image(),
            Forms\Components\Toggle::make('is_active')
                ->default(true),
            Forms\Components\Toggle::make('is_suspended')
                ->default(false),
        ]);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
            TextColumn::make('shop.name')->sortable()->searchable(),
            TextColumn::make('name')->sortable()->searchable(),
            TextColumn::make('price')->sortable(),
            ImageColumn::make('photo'),
            BooleanColumn::make('is_active'),
            BooleanColumn::make('is_suspended'),
            TextColumn::make('created_at')->dateTime()->sortable(),
        ])
        ->filters([
            Tables\Filters\Filter::make('Active')
            ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
            Tables\Filters\Filter::make('Inactive')
            ->query(fn (Builder $query): Builder => $query->where('is_active', false)),
            Tables\Filters\Filter::make('Suspeneded')
            ->query(fn (Builder $query): Builder => $query->where('is_suspended', true)),
            SelectFilter::make('Shop')
            ->relationship('shop', 'name'),
            SelectFilter::make('type')
            ->label('Filter by Type')
            ->options([
                'product' => 'Product',
                'service' => 'Service'
            ]),
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
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
