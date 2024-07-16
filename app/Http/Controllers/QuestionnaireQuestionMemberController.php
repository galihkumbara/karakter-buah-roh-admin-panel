<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\StoreQuestionnaireQuestionMemberRequest;
use App\Http\Requests\UpdateQuestionnaireQuestionMemberRequest;
use App\Models\QuestionnaireQuestionMember;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class QuestionnaireQuestionMemberController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        try {
            $query = QuestionnaireQuestionMember::query();

            if ($request->has('member_id')) {
                $query->where('member_id', $request->member_id);
            }

            if ($request->has('questionnaireQuestion_id')) {
                $query->where('question_id', $request->questionnaireQuestion_id);
            } elseif ($request->has('questionnaire_id')) {
                $query->whereHas('question', function($q) use ($request) {
                    $q->where('questionnaire_id', $request->questionnaire_id);
                });
            }

            $questionnaireQuestionMembers = $query->get();
            return ResponseHelper::success($questionnaireQuestionMembers);
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
        try {
            $validatedData = $request->validate([
                'question_id' => 'required|integer|exists:questions,id',
                'member_id' => 'required|integer|exists:members,id',
                'answer' => 'required|string',
            ]);

            $questionnaireQuestionMember = QuestionnaireQuestionMember::create($validatedData);

            return ResponseHelper::success($questionnaireQuestionMember, 'Questionnaire Question Member created successfully', 201);
        } catch (ValidationException $e) {
            return ResponseHelper::error($e->errors(), 422);
        } catch (Exception $e) {
            return ResponseHelper::error(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(QuestionnaireQuestionMember $questionnaireQuestionMember)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(QuestionnaireQuestionMember $questionnaireQuestionMember)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionnaireQuestionMemberRequest $request, QuestionnaireQuestionMember $questionnaireQuestionMember)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(QuestionnaireQuestionMember $questionnaireQuestionMember)
    {
        //
    }
}
