<?php

namespace App\Filament\Resources\MemberQuestionResource\Pages;

use App\Filament\Resources\MemberQuestionResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageMemberQuestions extends ManageRecords
{
    protected static string $resource = MemberQuestionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
