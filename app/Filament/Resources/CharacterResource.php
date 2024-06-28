<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CharacterResource\Pages;
use App\Filament\Resources\CharacterResource\RelationManagers;
use App\Models\Character;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Guava\FilamentNestedResources\Ancestor;
use Guava\FilamentNestedResources\Concerns\NestedResource;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CharacterResource extends Resource
{
    use NestedResource;
    


    public static function getAncestor(): ?Ancestor
    {
        return Ancestor::make(
            'characters',
            'module'
        );
    }
    
    protected static ?string $model = Character::class;
    protected static ?string $label = 'Karakter';

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
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

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')->label('Nama Karakter'),
                Tables\Columns\TextColumn::make('bible_verse')->label('Ayat Alkitab'),
                Tables\Columns\TextColumn::make('bible_verse_text')->label('Teks Ayat Alkitab'),
                Tables\Columns\IconColumn::make('is_active')->label('Status')->boolean()->alignCenter(),
                
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
            ])
            ->reorderable('order_number')
            ->defaultSort('order_number', 'asc');
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\QuizzesRelationManager::class,
            
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCharacters::route('/'),
            'create' => Pages\CreateCharacter::route('/create'),
            'edit' => Pages\EditCharacter::route('/{record}/edit'),
            'quizzes.create' => Pages\CreateCharactersQuiz::route('/{record}//create'),
        ];
    }
}
