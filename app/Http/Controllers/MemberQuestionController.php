<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\MemberQuestion;
use App\Http\Requests\StoreMemberQuestionRequest;
use App\Http\Requests\UpdateMemberQuestionRequest;
use App\Models\MemberQuiz;
use App\Models\Question;
use Illuminate\Http\Request;

class MemberQuestionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
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
    //they will send this
    //user_id:1
    // quiz_id:2
    // choice[1]:0
    // answer[1]:
    // open_question[1]:
    // question_id[1]:19
    // choice[2]:1
    // answer[2]:
    // open_question[2]:
    // question_id[2]:20
    // choice[3]:1
    // answer[3]:
    // open_question[3]:Pertanyaan OQ
    // question_id[3]:26
    // choice[4]:
    // answer[4]:Jawaban Refleksi
    // open_question[4]:
    // question_id[4]:27
    $member_quiz = MemberQuiz::create([
        'member_id' => $request->user_id,
        'quiz_id' => $request->quiz_id,
        'reflection'=> $request->answer[6],
        'open_answer'=> $request->open_question[7]
    ]);
    foreach($request->question_id as $key => $question_id){
        if(Question::find($question_id) == null){
            return ResponseHelper::error('Question not found (ID = '.$question_id.')',404);
        }

        $memberQuestion = MemberQuestion::create([
            'member_id' => $request->user_id,
            'question_id' => $question_id,
            'answer' => $request->choice[$key],
            'member_quiz_id' => $member_quiz->id
        ]);
    }


    return ResponseHelper::success($memberQuestion);
    }
    /**
     * Display the specified resource.
     */
    public function show(MemberQuestion $memberQuestion)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MemberQuestion $memberQuestion)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberQuestionRequest $request, MemberQuestion $memberQuestion)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberQuestion $memberQuestion)
    {
        //
    }
}
