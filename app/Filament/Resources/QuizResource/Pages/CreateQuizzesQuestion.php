<?php

namespace App\Filament\Resources\QuizResource\Pages;

use App\Filament\Resources\QuizResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentNestedResources\Concerns\NestedPage;
use Guava\FilamentNestedResources\Pages\CreateRelatedRecord;
use Filament\Forms\Components\TextInput;


class CreateQuizzesQuestion extends CreateRelatedRecord
{
    use NestedPage;

    protected static string $resource = QuizResource::class;

    protected static string $relationship = 'questions';


}