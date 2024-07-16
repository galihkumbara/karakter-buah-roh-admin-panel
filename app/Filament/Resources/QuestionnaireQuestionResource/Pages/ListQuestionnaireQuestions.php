<?php

namespace App\Filament\Resources\QuestionnaireQuestionResource\Pages;

use App\Filament\Resources\QuestionnaireQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class ListQuestionnaireQuestions extends ListRecords
{
    use NestedPage;
    protected static string $resource = QuestionnaireQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
