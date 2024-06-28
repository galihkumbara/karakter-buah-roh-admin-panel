<?php

namespace App\Filament\Resources\ModuleResource\Pages;

use App\Filament\Resources\ModuleResource;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentNestedResources\Concerns\NestedPage;
use Guava\FilamentNestedResources\Pages\CreateRelatedRecord;
use Filament\Forms\Components\TextInput;

class CreateModulesCharacter extends CreateRelatedRecord
{
    use NestedPage;

    protected static string $resource = ModuleResource::class;

    protected static string $relationship = 'characters';

    // public function form(Form $form): Form
    // {
    //     return $form
    //         ->schema([
    //             ::make('name')
    //                 ->required()
    //                 ->maxLength(255),
    //         ]);
    // }

}