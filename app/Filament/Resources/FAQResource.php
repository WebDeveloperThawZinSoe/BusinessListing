<?php

namespace App\Filament\Resources;

use App\Filament\Resources\FAQResource\Pages;
use App\Filament\Resources\FAQResource\RelationManagers;
use App\Models\FAQ;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\RichEditor;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\TextInput;

class FAQResource extends Resource
{
    protected static ?string $model = FAQ::class;

    protected static ?int $navigationSort = 22;

    protected static ?string $navigationIcon = 'heroicon-c-question-mark-circle';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                TextInput::make('question')
                ->required()
                ->maxLength(255)->columnSpanFull(),

          

            RichEditor::make('answer')
                ->toolbarButtons([
                    'bold', 'italic', 'underline', 'strike',
                    'h2', 'h3', 'blockquote',
                    'bulletList', 'orderedList',
                    'link', 'codeBlock'
            ])->required()
                ->columnSpanFull(),

                Forms\Components\Toggle::make('is_active')
                ->default(true),
            ]);

           
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('question')
                ->sortable()
                ->searchable(),
            ])
            ->filters([
                //
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
            'index' => Pages\ListFAQS::route('/'),
            'create' => Pages\CreateFAQ::route('/create'),
            'edit' => Pages\EditFAQ::route('/{record}/edit'),
        ];
    }
}
