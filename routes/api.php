<?php

use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EthnicController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberModuleController;
use App\Http\Controllers\MemberQuestionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionnaireQuestionMemberController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\TransactionController;
use App\Models\Character;
use App\Models\MemberModule;
use App\Models\QuestionnaireQuestionMember;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::apiResource('/admin/transactions', TransactionController::class);
Route::apiResource('/questionnaires', QuestionnaireController::class);
Route::apiResource('/questionnairemembers', QuestionnaireQuestionMemberController::class);
Route::post('/membermodules', [MemberModuleController::class, 'ModuleByMember']);
Route::apiResource('user/module', ModuleController::class);
Route::apiResource('user/character', CharacterController::class);
Route::apiResource('user/religion', ReligionController::class);
Route::apiResource('user/tribe', EthnicController::class);
Route::apiResource('user/institute', InstitutionController::class);
Route::apiResource('user/quiz', QuizController::class);
Route::apiResource('user/userquestion', MemberQuestionController::class);


Route::apiResource('user/education', EducationController::class);
Route::get('user/{id}', [MemberController::class, 'show']);
Route::patch('user/{id}', [MemberController::class, 'update']);
Route::post('user/{id}/module/add', [MemberController::class, 'addModuleToMember']);








Route::apiResource('/contents', ContentController::class);





