<?php

namespace App\Filament\Resources\QuestionnaireQuestionResource\Pages;

use App\Filament\Resources\QuestionnaireQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class CreateQuestionnaireQuestion extends CreateRecord
{
    use NestedPage;
    protected static string $resource = QuestionnaireQuestionResource::class;
}
