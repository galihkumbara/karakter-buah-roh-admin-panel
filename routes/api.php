<?php

use App\Http\Controllers\ContentController;
use App\Http\Controllers\MemberModuleController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionnaireQuestionMemberController;
use App\Http\Controllers\TransactionController;
use App\Models\MemberModule;
use App\Models\QuestionnaireQuestionMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::apiResource('/admin/transactions', TransactionController::class);
Route::apiResource('/questionnaires', QuestionnaireController::class);
Route::apiResource('/questionnairemembers', QuestionnaireQuestionMemberController::class);
Route::post('/membermodules', [MemberModuleController::class, 'index']);

Route::apiResource('/contents', ContentController::class);





