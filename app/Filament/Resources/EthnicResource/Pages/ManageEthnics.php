<?php

namespace App\Filament\Resources\EthnicResource\Pages;

use App\Filament\Resources\EthnicResource;
use Filament\Actions;
use Filament\Resources\Pages\ManageRecords;

class ManageEthnics extends ManageRecords
{
    protected static string $resource = EthnicResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
