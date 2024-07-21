<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Quiz;
use App\Http\Requests\StoreQuizRequest;
use App\Http\Requests\UpdateQuizRequest;
use App\Models\MemberQuestion;
use App\Models\MemberQuiz;

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

    public static function formatQuizForComplete($quiz, $member) {
        $quiz->load('members');
        $quiz['status'] = $quiz['is_active'] ? 1 : 0;
        unset($quiz['is_active']);
        $quiz['order'] = $quiz['order_number'];
        unset($quiz['order_number']);
        $quiz['complete'] = MemberQuiz::where('member_id', $member)->where('quiz_id', $quiz->id)->first() ? 1 : 0;
        $quiz['completed_at'] = Date('Y-m-d H:i:s');

       $quiz['members'] = $quiz['members']->map(function ($member) {
            MemberQuizController::formatMemberQuiz($member);
            return $member;
        });

        $quiz["users"] = $quiz["members"];
        unset($quiz["members"]);
        
        return $quiz;


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
                unset($question['created_at']);
                unset($question['updated_at']);
                $question['questiontype_id'] = 1;
                $question['questiontyoe'] = [
                    "id" => 1,
                    "name" => "Berhasil/Gagal",
                    "created_at" => "2021-07-07T07:00:00.000000Z",
                    "updated_at" => "2021-07-07T07:00:00.000000Z"
                ];
            }
        }


        
        return ResponseHelper::success($quiz);
    }

    public function results($quiz, $member){
        $quiz = Quiz::find($quiz);
        $quiz["status"] = $quiz["is_active"] ? 1 : 0;
        unset($quiz["is_active"]);
        $quiz["order"] = $quiz["order_number"];
        unset($quiz["order_number"]);
        unset($quiz["character_id"]);
        unset($quiz["created_at"]);
        unset($quiz["updated_at"]);

        $this_quiz_questions = $quiz->questions->pluck('id');
        $member_questions = MemberQuestion::where('member_id', $member)->whereIn('question_id', $this_quiz_questions)->get();
        $quiz["answers"] = $member_questions->map(function($question) use ($quiz){
            return [
                "id" => $question->id,
                "choice" => $question->answer,
                "answer" => $quiz->open_question,
                "status" => 1,
                "user_id" => $question->member_id,
                "question_id" => $question->question_id,
                "quiz_id" => $quiz->id,
                "created_at" => $question->created_at,
                "updated_at" => $question->updated_at

            ];
        });

        //append to quiz['answers'] another mock answer

        $quiz["answers"][] = [
            "id" => 1,
            "choice" => null,
            "answer" => MemberQuiz::where('member_id', $member)->where('quiz_id', $quiz->id)->first()->reflection,
            "status" => 1,
            "user_id" => $member,
            "question_id" => 1,
            "quiz_id" => $quiz->id,
            "created_at" => "2021-07-07T07:00:00.000000Z",
            "updated_at" => "2021-07-07T07:00:00.000000Z"
        ];
        
      
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

            $question['questiontype_id'] = 1;

            $question['questiontype'] = [
                "id" => 1,
                "name" => "Berhasil/Gagal",
                "created_at" => "2021-07-07T07:00:00.000000Z",
                "updated_at" => "2021-07-07T07:00:00.000000Z"
            ];


        }

        $quiz['questions'][] = [
            "id" => 1,
            "question" => "Pertanyaan Refleksi",
            "order" => 999,
            "path" => null,
            "questiontype_id" => 3,
            "questiontype" => [
                "id" => 3,
                "name" => "Refleksi",
                "created_at" => "2021-07-07T07:00:00.000000Z",
                "updated_at" => "2021-07-07T07:00:00.000000Z"
            ]
        ];
        
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
