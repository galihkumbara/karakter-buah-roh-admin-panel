<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Models\Character;
use App\Http\Requests\StoreCharacterRequest;
use App\Http\Requests\UpdateCharacterRequest;
use App\Models\MemberQuiz;
use Illuminate\Http\Request;

class CharacterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public static function formatCharacter($character, $user_id) {
        $character['verse_number'] = $character['bible_verse'];
        unset($character['bible_verse']);
        $character['verse'] = $character['bible_verse_text'];
        unset($character['bible_verse_text']);
        $character['order'] = $character['order_number'];
        unset($character['order_number']);
        $character['status'] = $character['is_active'] ? 1 : 0;
        unset($character['is_active']);
        $character['quizzes_count'] = $character->quizzes->whereIn('id',MemberQuiz::where('member_id', $user_id)->pluck('quiz_id'))->count();
        $character['qu_count'] = $character->quizzes->count(); 
        $character['complete'] = $character['quizzes_count'] == $character['qu_count'] ? 1 : 0;
        $character->load('quizzes');


       $character["quizzes"] = $character["quizzes"]->map(function ($quiz) use ($user_id) {
            return QuizController::formatQuizForComplete($quiz, $user_id);
        });
    }

    public function index()
    {
        $characters = Character::all();
        // $characters->map(function ($character) {
        //     self::formatCharacter($character);
        //     return $character;
        // });

        return ResponseHelper::success($characters);
    }

    public function result($user_id)
    {
        $characters = Character::all();
        $characters->map(function ($character) use ($user_id) {
            self::formatCharacter($character, $user_id);
            return $character;
        });

        return ResponseHelper::success($characters);
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
    public function store(Request $request)
    {
        //expect name, status, module_id

        $name = $request->name;
        $is_active = $request->status;
        $module_id = $request->module_id;

        $character = Character::create([
            'name' => $name,
            'is_active' => $is_active,
            'module_id' => $module_id
        ]);

        return ResponseHelper::success($character);
    }

    /**
     * Display the specified resource.
     */
    public function show(Character $character)
    {
        if (!$character) {
            return ResponseHelper::error('Character not found',404);
        }
        $character['verse_number'] = $character['bible_verse'];
        unset($character['bible_verse']);
        $character['verse'] = $character['bible_verse_text'];
        unset($character['bible_verse_text']);
        $character['order'] = $character['order_number'];
        unset($character['order_number']);
        $character['status'] = $character['is_active'];
        unset($character['is_active']);

        $character->load('quizzes');

        foreach ($character->quizzes as $quiz) {
            $quiz['order'] = $quiz['order_number'];
            unset($quiz['order_number']);
            $quiz['status'] = $quiz['is_active'] ? 1 : 0;
            unset($quiz['is_active']);
            $quiz['path'] = null;
        }

        return ResponseHelper::success($character);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Character $character)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCharacterRequest $request, Character $character)
    {
        $name = $request->name;
        $is_active = $request->status;
        $module_id = $request->module_id;

        if($name) {
            $character->name = $name;
        }

        if($is_active) {
            $character->is_active = $is_active;
        }

        if($module_id) {
            $character->module_id = $module_id;
        }

        $character->save();

        return ResponseHelper::success($character);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Character $character)
    {
        if(!$character) {
            return ResponseHelper::error('Character not found',404);
        }
        $character->delete();
        return ResponseHelper::success('Character deleted successfully');
    }
}
