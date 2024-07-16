<?php

namespace App\Filament\Resources\QuestionnaireResource\Pages;

use App\Filament\Resources\QuestionnaireResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class CreateQuestionnaire extends CreateRecord
{
    use NestedPage;
    protected static string $resource = QuestionnaireResource::class;
}
