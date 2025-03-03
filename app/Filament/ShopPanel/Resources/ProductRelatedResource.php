<?php 

namespace App\Filament\ShopPanel\Resources;

use App\Filament\ShopPanel\Resources\ProductRelatedResource\Pages;
use App\Models\Product;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Columns\BooleanColumn;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Illuminate\Support\Facades\Auth;

class ProductRelatedResource extends Resource
{
    protected static ?string $model = Product::class;
    protected static ?string $navigationIcon = 'heroicon-s-currency-dollar';
    protected static ?int $navigationSort = 12;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                // Set the shop_id automatically to the current user's shop
                Select::make('shop_id')
                ->options(function () {
                    return \App\Models\Shop::where('user_id', auth()->id()) // Filter by authenticated user's ID
                        ->pluck('name', 'id') // Get the shop names and ids
                        ->toArray();
                })
                ->required() 
                ->searchable(),
            
                    TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                    TextInput::make('price')
                    ->numeric()
                    ->required(),
                // RichEditor::make('description')
                // ->toolbarButtons([
                //     'bold', 'italic', 'underline', 'strike',
                //     'h2', 'h3', 'blockquote',
                //     'bulletList', 'orderedList',
                //     'link', 'codeBlock', 'image'
                // ])
                // ->fileAttachmentsDisk('public') // Store images in the public disk
                // ->fileAttachmentsDirectory('uploads/products') // Specify the directory
                // ->fileAttachmentsVisibility('public') // Ensure visibility
                // ->columnSpanFull(),
            
    
                
                FileUpload::make('photo')
                    ->required()
                    ->image()->columnSpanFull(),
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
                Forms\Components\Toggle::make('is_suspended')
                    ->default(false)
                    ->hidden(),
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
            ->defaultSort('created_at', 'desc')
            ->filters([
                Tables\Filters\Filter::make('Active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
                Tables\Filters\Filter::make('Inactive')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', false)),
                Tables\Filters\Filter::make('Suspended')
                    ->query(fn (Builder $query): Builder => $query->where('is_suspended', true)),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\DeleteBulkAction::make(),
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProductRelated::route('/'),
            'create' => Pages\CreateProductRelated::route('/create'),
            'edit' => Pages\EditProductRelated::route('/{record}/edit'),
        ];
    }
}
