<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Question;
use App\Http\Requests\StoreQuestionRequest;
use App\Http\Requests\UpdateQuestionRequest;

class QuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ResponseHelper::success(Question::all());
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
    public function store(StoreQuestionRequest $request)
    {
        $question = Question::create([
            'question' => $request->question,
            'quiz_id' => $request->quiz_id
        ]);

        return ResponseHelper::success($question);
    }

    /**
     * Display the specified resource.
     */
    public function show(Question $question)
    {
        if (!$question) {
            return ResponseHelper::error('Question not found',404);
        }
        return ResponseHelper::success($question);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Question $question)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuestionRequest $request, Question $question)
    {
        $question->update([
            'question' => $request->question,
            'quiz_id' => $request->quiz_id
        ]);

        return ResponseHelper::success($question);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return ResponseHelper::success('Question deleted successfully');
    }
}
