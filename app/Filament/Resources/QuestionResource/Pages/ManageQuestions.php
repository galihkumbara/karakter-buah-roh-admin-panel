<?php

namespace App\Filament\Resources\QuestionResource\Pages;

use App\Filament\Resources\QuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;
use Guava\FilamentNestedResources\Concerns\NestedPage;

class ManageQuestions extends ManageRecords
{
    protected static string $resource = QuestionResource::class;
    use NestedPage;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
