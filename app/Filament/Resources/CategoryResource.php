<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CategoryResource\Pages;
use App\Models\Category;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class CategoryResource extends Resource
{
    protected static ?string $model = Category::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    protected static ?int $navigationSort = 16;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->required()
                    ->maxLength(255),
                    
                Forms\Components\TextInput::make('slug')
                    ->required()
                    ->unique(Category::class, 'slug', fn ($record) => $record) // Ignore current record when updating
                    ->maxLength(255)
                    ->disableAutocomplete(),
    
                RichEditor::make('description')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'blockquote',
                        'bulletList', 'orderedList',
                        'link', 'codeBlock'
                    ])
                    ->columnSpanFull(), 
                        
                Forms\Components\Select::make('parent_id')
                    ->label('Parent Category')
                    ->nullable()
                    ->options(
                        Category::all()->pluck('title', 'id') // Pluck 'title' and 'id' for the select options
                    )
                    ->searchable(),
    
                Forms\Components\TextInput::make('order')
                    ->default(0)
                    ->numeric()
                    ->maxLength(3),


                    FileUpload::make('icon')
                    ->image()
                    ->required()
                    ->directory('category_icons')
                    ->disk('public')
                    ->maxSize(10240) // 10MB
                    ->label('Upload New Icon')
                    ->preserveFilenames()
                    ->previewable()
                    ->getUploadedFileNameForStorageUsing(fn ($file) => $file->hashName()),
                         
                
                Forms\Components\Toggle::make('is_active')
                    ->default(true),
    
         
            ]);
    }
    

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
                    ->sortable()
                    ->searchable(),

                    Tables\Columns\TextColumn::make('parent.title') // Reference relationship
                    ->label('Parent Category')
                    ->sortable()
                    ->searchable(),
                
                
                Tables\Columns\TextColumn::make('order')
                    ->sortable(),

                Tables\Columns\BooleanColumn::make('is_active')
                    ->sortable()
                    ->label('Active'),

                    Tables\Columns\ImageColumn::make('icon')
                    ->label('Icon')
                    ->width(50)
                    ->height(50)
                    ->getStateUsing(fn ($record) => $record->icon ? asset('storage/' . $record->icon) : null),
               
                    
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->label('Created At'),
            ])
            ->filters([
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
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            // Add any related resources if needed
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCategories::route('/'),
            'create' => Pages\CreateCategory::route('/create'),
            'edit' => Pages\EditCategory::route('/{record}/edit'),
        ];
    }
}