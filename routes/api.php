<?php

use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionnaireQuestionMemberController;
use App\Http\Controllers\TransactionController;
use App\Models\QuestionnaireQuestionMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::apiResource('/admin/transactions', TransactionController::class);
Route::apiResource('/questionnaires', QuestionnaireController::class);
Route::apiResource('/questionnairemembers', QuestionnaireQuestionMemberController::class);







