<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ADSResource\Pages;
use App\Filament\Resources\ADSResource\RelationManagers;
use App\Models\ADS;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;

class ADSResource extends Resource
{
    protected static ?string $model = ADS::class;

    protected static ?string $navigationIcon = 'heroicon-c-banknotes';

    protected static ?int $navigationSort = 20;

    public static function form(Form $form): Form
    {
        return $form
        ->schema([
            TextInput::make('title')
                ->required()
                ->maxLength(255),

            TextInput::make('link')
                ->required()
                ->maxLength(255),

            // Select box for predefined types
            Select::make('type')
                ->label('Select Position')
                ->options([
                    'banner' => 'Banner',
                    'left_side' => 'Left Side',
                    'right_side' => 'Right Side',
                    'content_center' => 'Content Center',
                    'footer' => 'Footer',
                ])
                ->default('banner') // Set default value
                ->required(),

            FileUpload::make('image')
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

              
                    Tables\Columns\BadgeColumn::make('type')
                    ->label('Position')
                    ->getStateUsing(fn ($record) => [
                        'banner' => 'Banner',
                        'left_side' => 'Left Side',
                        'right_side' => 'Right Side',
                        'content_center' => 'Content Center',
                        'footer' => 'Footer',
                    ][$record->type] ?? 'Unknown') // Default to 'Unknown' if no matching type is found
                    ->colors([
                        'banner' => 'primary',
                        'left_side' => 'success',
                        'right_side' => 'warning',
                        'content_center' => 'info',
                        'footer' => 'danger',
                        'default' => 'secondary', // Use for 'Unknown' or unhandled types
                    ]),
                

                Tables\Columns\BooleanColumn::make('is_active')
                    ->sortable()
                    ->label('Active'),

                    Tables\Columns\ImageColumn::make('image')
                    ->label('Image')
                    ->width(50)
                    ->height(50)
                    ->getStateUsing(fn ($record) => $record->image ? asset('storage/' . $record->image) : null),
               
                    
                // Tables\Columns\TextColumn::make('created_at')
                //     ->dateTime()
                //     ->sortable()
                //     ->label('Created At'),
            ])
            ->filters([
                Tables\Filters\Filter::make('Active')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', true)),
                Tables\Filters\Filter::make('Inactive')
                    ->query(fn (Builder $query): Builder => $query->where('is_active', false)),
                Tables\Filters\Filter::make('Banner')
                    ->query(fn (Builder $query): Builder => $query->where('type','banner')),
                Tables\Filters\Filter::make('Left Side')
                    ->query(fn (Builder $query): Builder => $query->where('type','left_size')),
                Tables\Filters\Filter::make('Right Side')
                    ->query(fn (Builder $query): Builder => $query->where('type','right_size')),
                Tables\Filters\Filter::make('Content Center')
                    ->query(fn (Builder $query): Builder => $query->where('type','content_center')),
                Tables\Filters\Filter::make('Footer')
                    ->query(fn (Builder $query): Builder => $query->where('type','footer')),
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
            'index' => Pages\ListADS::route('/'),
            'create' => Pages\CreateADS::route('/create'),
            'edit' => Pages\EditADS::route('/{record}/edit'),
        ];
    }
}
