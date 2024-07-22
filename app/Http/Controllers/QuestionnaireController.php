<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Questionnaire;
use App\Models\QuestionnaireQuestion;
use App\Models\QuestionnaireQuestionMember;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;

class QuestionnaireController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {
            $questionnaires = Questionnaire::with('questionnaire_questions')->get();
            return ResponseHelper::success($questionnaires->load('questionnaire_questions'));
        } catch (Exception $e) {
            return ResponseHelper::error(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        try {
            $questionnaire = Questionnaire::with('questionnaire_questions')->findOrFail($id);
            return ResponseHelper::success($questionnaire->load('questionnaire_questions'));
        } catch (ModelNotFoundException $e) {
            return ResponseHelper::error('Questionnaire not found', 404);
        } catch (Exception $e) {
            return ResponseHelper::error(['message' => $e->getMessage()], 500);
        }
    }

    public function userNotDoneQuestionnaire($user_id)
    {
        try {
            $userAnswers = QuestionnaireQuestionMember::where('member_id', $user_id)->pluck('question_id');
            $questionnaire = QuestionnaireQuestion::whereIn('id', $userAnswers)->pluck('questionnaire_id');
            $questionnaire = $questionnaire->unique();
            $questionnaires = Questionnaire::whereNotIn('id', $questionnaire)->get();
            return ResponseHelper::success($questionnaires->load('questionnaire_questions'));
            
        } catch (Exception $e) {
            return ResponseHelper::error(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Questionnaire $questionnaire)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Questionnaire $questionnaire)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Questionnaire $questionnaire)
    {
        //
    }
}
