<?php

namespace App\Filament\Resources\CharacterResource\Pages;

use App\Filament\Resources\CharacterResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentNestedResources\Concerns\NestedPage;
use Guava\FilamentNestedResources\Pages\CreateRelatedRecord;
use Filament\Forms\Components\TextInput;

class CreateCharactersQuiz extends CreateRelatedRecord
{
    use NestedPage;

    protected static string $resource = CharacterResource::class;

    protected static string $relationship = 'quizzes';

}