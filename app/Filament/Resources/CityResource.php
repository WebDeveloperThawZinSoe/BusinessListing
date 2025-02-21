<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CityResource\Pages;
use App\Models\City;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

class CityResource extends Resource
{
    protected static ?string $model = City::class;

    protected static ?string $navigationIcon = 'heroicon-o-building-office';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('name')
                    ->required()
                    ->maxLength(255),

                TextInput::make('slug')
                    ->required()
                    ->unique(City::class, 'slug', fn ($record) => $record)
                    ->maxLength(255)
                    ->disableAutocomplete(),

                RichEditor::make('description')
                    ->toolbarButtons([
                        'bold', 'italic', 'underline', 'strike',
                        'h2', 'h3', 'blockquote',
                        'bulletList', 'orderedList',
                        'link', 'codeBlock'
                    ])
                    ->columnSpanFull(),

                TextInput::make('latitude')
                    ->nullable()
                    ->maxLength(255),

                TextInput::make('longitude')
                    ->nullable()
                    ->maxLength(255),

             

                TextInput::make('order')
                    ->default(0)
                    ->numeric()
                    ->maxLength(3),

                FileUpload::make('icon')
                    ->image()
                    ->directory('city_icons')
                    ->disk('public')
                    ->maxSize(10240)
                    ->label('Upload City Icon')
                    ->preserveFilenames()
                    ->previewable()
                    ->getUploadedFileNameForStorageUsing(fn ($file) => $file->hashName())->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->sortable()
                    ->searchable(),

                Tables\Columns\TextColumn::make('slug')
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
        return [];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCities::route('/'),
            'create' => Pages\CreateCity::route('/create'),
            'edit' => Pages\EditCity::route('/{record}/edit'),
        ];
    }
}
