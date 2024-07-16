<?php

namespace App\Filament\Resources\QuestionnaireResource\Pages;

use App\Filament\Resources\ModuleResource;
use App\Models\Questionnaire;
use Filament\Actions;
use Filament\Forms\Form;
use Filament\Resources\Pages\CreateRecord;
use Guava\FilamentNestedResources\Concerns\NestedPage;
use Guava\FilamentNestedResources\Pages\CreateRelatedRecord;
use Filament\Forms\Components\TextInput;

class CreateQuestionnaireQuestion extends CreateRelatedRecord
{
    use NestedPage;

    protected static string $resource = Questionnaire::class;

    protected static string $relationship = 'questions';

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