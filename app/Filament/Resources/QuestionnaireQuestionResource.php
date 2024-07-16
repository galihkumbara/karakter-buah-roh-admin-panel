<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionnaireQuestionResource\Pages;
use App\Filament\Resources\QuestionnaireQuestionResource\RelationManagers;
use App\Models\QuestionnaireQuestion;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentNestedResources\Ancestor;
use Guava\FilamentNestedResources\Concerns\NestedResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionnaireQuestionResource extends Resource
{
    use NestedResource;
    
    public static function getAncestor(): ?Ancestor
    {
        return Ancestor::make(
            'questionnaire_questions',
            'questionnaire'
        );
    }
    protected static ?string $model = QuestionnaireQuestion::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        
        return $form
            ->schema([

                Forms\Components\Textarea::make('question')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('max_scale')
                    ->label('Max Scale')
                    ->required()
                    ->columnSpanFull(),
                Forms\Components\Textarea::make('option_2')
                    ->required()
                    ->columnSpanFull(),
   
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('questionnaire_id')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
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
            'index' => Pages\ListQuestionnaireQuestions::route('/'),
            'create' => Pages\CreateQuestionnaireQuestion::route('/create'),
            'edit' => Pages\EditQuestionnaireQuestion::route('/{record}/edit'),
        ];
    }
}
