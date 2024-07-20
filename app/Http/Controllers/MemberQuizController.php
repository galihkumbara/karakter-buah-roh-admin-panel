<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMemberQuizRequest;
use App\Http\Requests\UpdateMemberQuizRequest;
use App\Models\MemberQuiz;

class MemberQuizController extends Controller
{

    public static function formatMemberQuiz($memberQuiz) {
        $memberQuiz['status'] = 1;
        $memberQuiz['user_id'] = $memberQuiz['member_id'];
        unset($memberQuiz['member_id']);
        unset($memberQuiz['reflection']);
        unset($memberQuiz['open_answer']);
    }
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
    public function store(StoreMemberQuizRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(MemberQuiz $memberQuiz)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(MemberQuiz $memberQuiz)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMemberQuizRequest $request, MemberQuiz $memberQuiz)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MemberQuiz $memberQuiz)
    {
        //
    }
}
