<?php

namespace App\Filament\Resources;

use App\Filament\Resources\QuestionnaireResource\Pages;
use App\Filament\Resources\QuestionnaireResource\RelationManagers;
use App\Filament\Resources\QuestionnaireResource\RelationManagers\QuestionnaireQuestionsRelationManager;
use App\Models\Questionnaire;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentNestedResources\Ancestor;
use Guava\FilamentNestedResources\Concerns\NestedResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class QuestionnaireResource extends Resource
{
    use NestedResource;

    public static function getAncestor(): ?Ancestor
    {
        return null;
    }

    protected static ?string $model = Questionnaire::class;
    protected static ?string $navigationGroup = 'Manajemen Konten';
    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';
    protected static ?string $label = 'Kuisioner';
    

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('title')
                    ->label('Judul')
                    ->required()
                    ->maxLength(255),
                Forms\Components\RichEditor::make('description')
                    ->columnSpanFull(),
                Forms\Components\Select::make('is_active')
                    ->label('Status')
                    ->options([
                        1 => 'Aktif',
                        0 => 'Tidak Aktif',
                    ])
                    ->default(1)
                    ->required(),
                Forms\Components\DateTimePicker::make('start_date')
                    ->label('Tanggal Mulai'),
                Forms\Components\DateTimePicker::make('end_date')
                    ->label('Tanggal Selesai'),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('title')
                    ->label('Judul')
                    ->searchable(),
                Tables\Columns\TextColumn::make('is_active')
                    ->label('Status')
                    ->formatStateUsing(fn($state) => $state ? 'Aktif' : 'Tidak Aktif'),
                Tables\Columns\TextColumn::make('start_date')
                    ->dateTime()
                    ->label('Tanggal Mulai')
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->dateTime()
                    ->label('Tanggal Selesai')
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
            QuestionnaireQuestionsRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListQuestionnaires::route('/'),
            'create' => Pages\CreateQuestionnaire::route('/create'),
            'edit' => Pages\EditQuestionnaire::route('/{record}/edit'),
            'question.create' => Pages\CreateQuestionnaireQuestion::route('/{record}/albums/create'),

        ];
    }
}
