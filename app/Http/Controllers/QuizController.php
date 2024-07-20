<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Quiz;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;

class QuizController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public static function formatQuiz($quiz) {
        $quiz->load('members');
        $quiz['status'] = $quiz['is_active'] ? 1 : 0;
        unset($quiz['is_active']);
        $quiz['order'] = $quiz['order_number'];
        unset($quiz['order_number']);
        $quiz['complete'] = 0;
        $quiz['completed_at'] = Date('Y-m-d H:i:s');

        foreach ($quiz->members as $member) {
            MemberQuizController::formatMemberQuiz($member);
        }


    }
    public function index()
    {
        $quiz = Quiz::all()
                    ->load('questions');
        
        foreach ($quiz as $q) {
            foreach ($q->questions as $question) {
                $question['order'] = $question['order_number'];
                unset($question['order_number']);
                $question['path'] = null;
            }
        }


        
        return ResponseHelper::success($quiz);
    }

    public function results($quiz){
        $quiz = Quiz::find($quiz);
        $quiz["answers"] = [];
        $quiz["status"] = $quiz["is_active"] ? 1 : 0;
        unset($quiz["is_active"]);
        $quiz["order"] = $quiz["order_number"];
        unset($quiz["order_number"]);
        unset($quiz["character_id"]);
        unset($quiz["created_at"]);
        unset($quiz["updated_at"]);

      
        return ResponseHelper::success($quiz);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreQuizRequest $request)
    {
        $name = $request->name;
        $is_active = $request->status;
        $character_id = $request->character_id;

        $quiz = Quiz::create([
            'name' => $name,
            'is_active' => $is_active,
            'character_id' => $character_id
        ]);

        $quiz->load('questions');

        foreach ($quiz->questions as $question) {
            $question['order'] = $question['order_number'];
            unset($question['order_number']);
            $question['path'] = null;
        }

        return ResponseHelper::success($quiz);
    }

    /**
     * Display the specified resource.
     */
    public function show(Quiz $quiz)
    {
        if (!$quiz) {
            return ResponseHelper::error('Quiz not found',404);
        }
        $quiz->load('questions');

        foreach ($quiz->questions as $question) {
            $question['order'] = $question['order_number'];
            unset($question['order_number']);
            $question['path'] = null;
        }
        return ResponseHelper::success($quiz);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Quiz $quiz)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateQuizRequest $request, Quiz $quiz)
    {
        $name = $request->name;
        $is_active = $request->status;
        $character_id = $request->character_id;

        $quiz->update([
            'name' => $name,
            'is_active' => $is_active,
            'character_id' => $character_id
        ]);

        $quiz->load('questions');

        foreach ($quiz->questions as $question) {
            $question['order'] = $question['order_number'];
            unset($question['order_number']);
            $question['path'] = null;
        }

        return ResponseHelper::success($quiz);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Quiz $quiz)
    {
        $quiz->delete();
        return ResponseHelper::success('Quiz deleted successfully');
    }
}
