<?php

use App\Helpers\ResponseHelper;
use App\Http\Controllers\CharacterController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\DistrictController;
use App\Http\Controllers\EducationController;
use App\Http\Controllers\EthnicController;
use App\Http\Controllers\InstitutionController;
use App\Http\Controllers\MemberController;
use App\Http\Controllers\MemberModuleController;
use App\Http\Controllers\MemberQuestionController;
use App\Http\Controllers\ModuleController;
use App\Http\Controllers\ProvinceController;
use App\Http\Controllers\QuestionnaireController;
use App\Http\Controllers\QuestionnaireQuestionMemberController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\RegencyController;
use App\Http\Controllers\ReligionController;
use App\Http\Controllers\TransactionController;
use App\Http\Controllers\VillageController;
use App\Models\Character;
use App\Models\MemberModule;
use App\Models\QuestionnaireQuestionMember;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
//route group auth:sanct
Route::apiResource('/transactions', TransactionController::class);
Route::apiResource('/questionnaires', QuestionnaireController::class);
Route::apiResource('/questionnairemembers', QuestionnaireQuestionMemberController::class);

Route::post('/membermodules', [MemberModuleController::class, 'ModuleByMember']);
Route::post('/register', [MemberController::class, 'store']);
Route::apiResource('user/module', ModuleController::class);
Route::apiResource('user/character', CharacterController::class);
Route::get('user/character/{user_id}/result', [CharacterController::class, 'result']);

Route::apiResource('user/religion', ReligionController::class);
Route::apiResource('user/tribe', EthnicController::class);
Route::apiResource('user/institute', InstitutionController::class);
Route::apiResource('user/quiz', QuizController::class);
Route::apiResource('user/userquestion', MemberQuestionController::class);
Route::apiResource('user/education', EducationController::class);
Route::get('user/{id}', [MemberController::class, 'show']);
Route::patch('user/{id}', [MemberController::class, 'update']);
Route::post('user/{id}/module/add', [MemberController::class, 'addModuleToMember']);
Route::apiResource('location/province', ProvinceController::class);
Route::apiResource('location/village', VillageController::class);
Route::apiResource('location/city', RegencyController::class);
Route::apiResource('location/district', DistrictController::class);
Route::apiResource('/contents', ContentController::class);
Route::get('user/quiz/{id}/results/{member}', [QuizController::class, 'results']);

Route::get('user/{user_id}/transactions/onprogress', [TransactionController::class, 'onProgress']);

Route::get('/user/{user_id}/questionnaires/not_finished', [QuestionnaireController::class, 'userNotDoneQuestionnaire']);



Route::post('logout', function(){
    return ResponseHelper::success([
        'message' => 'Logout success'
    ]);
});

Route::get('env', function(){
    return ResponseHelper::success([
        "status" => "dev",
        "id" => 1,
        "created_at" => "2021-08-02T07:00:00.000000Z",
        "updated_at" => "2021-08-02T07:00:00.000000Z"
    ]);
});







