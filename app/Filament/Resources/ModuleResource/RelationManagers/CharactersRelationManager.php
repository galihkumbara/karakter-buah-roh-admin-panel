<?php

namespace App\Filament\Resources\ModuleResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentNestedResources\Concerns\NestedRelationManager;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use stdClass;

class CharactersRelationManager extends RelationManager
{
    use NestedRelationManager;
    protected static string $relationship = 'characters';

    public function form(Form $form): Form
    {
        return $form
        ->schema([
            Forms\Components\TextInput::make('name')
                ->label('Nama Karakter')
                ->required()
                ->maxLength(255),
            Forms\Components\TextInput::make('bible_verse')
                ->label('Ayat Alkitab')
                ->maxLength(255),
            Forms\Components\Textarea::make('bible_verse_text')
                ->label('Teks Ayat Alkitab')
                ->columnSpanFull(),
            Forms\Components\Select::make('is_active')
                ->label('Status')
                ->options([
                    1 => 'Aktif',
                    0 => 'Tidak Aktif',
                ])
                ->required(),

      
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->heading('Daftar Karakter')
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Karakter'),
                Tables\Columns\TextColumn::make('bible_verse')->label('Ayat Alkitab'),
                Tables\Columns\TextColumn::make('bible_verse_text')->label('Teks Ayat Alkitab'),
                Tables\Columns\IconColumn::make('is_active')->label('Status')->boolean()->alignCenter(),
                

            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make(),
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
}
