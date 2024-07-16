<?php

namespace App\Filament\Resources\QuestionnaireResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionnaireQuestionsRelationManager extends RelationManager
{
    protected static string $relationship = 'questionnaire_questions';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('question')
                    ->label('Pertanyaan')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('min_scale')
                    ->label('Skala Minimal')
                    ->numeric()
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('max_scale')
                    ->label('Skala Maksimal')
                    ->required()
                    ->numeric()
                    ->maxLength(255),
                Forms\Components\TextInput::make('min_word')
                    ->label('Label Skala Terendah')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('max_word')
                    ->label('Label Skala Tertinggi')
                    ->required()
                    ->maxLength(255),
                
               
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('question')
            ->heading('Pertanyaan Kuisioner')
            ->columns([
                Tables\Columns\TextColumn::make('question')
                    ->label('Pertanyaan'),
                Tables\Columns\TextColumn::make('min_scale')
                    ->label('Skala Minimal'),
                Tables\Columns\TextColumn::make('max_scale')
                    ->label('Skala Maksimal'),
                Tables\Columns\TextColumn::make('min_word')
                    ->label('Label Skala Terendah'),
                Tables\Columns\TextColumn::make('max_word')
                    ->label('Label Skala Tertinggi'),
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
