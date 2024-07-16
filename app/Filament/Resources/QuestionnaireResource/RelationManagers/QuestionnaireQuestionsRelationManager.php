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
                Forms\Components\TextInput::make('option_1')
                    ->label('Label Opsi 1')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('option_2')
                    ->label('Label Opsi 2')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('option_3')
                    ->label('Label Opsi 3')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('option_4')
                    ->label('Label Opsi 4')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('option_5')
                    ->label('Label Opsi 5')
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
