<?php

namespace App\Filament\Resources\TransactionResource\Pages;

use App\Filament\Resources\TransactionResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use TomatoPHP\FilamentApi\Traits\InteractWithAPI;

class CreateTransaction extends CreateRecord
{
    use InteractWithAPI;
    protected static string $resource = TransactionResource::class;
}
