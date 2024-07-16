<?php

namespace App\Filament\Resources\QuestionnaireQuestionResource\Pages;

use App\Filament\Resources\QuestionnaireQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditQuestionnaireQuestion extends EditRecord
{
    protected static string $resource = QuestionnaireQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
