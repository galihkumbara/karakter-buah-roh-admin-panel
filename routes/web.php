<?php

use App\Models\Member;
use App\Models\MemberQuiz;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});
Route::get('/login', function () {
    return redirect('admin');
})->name('login');


Route::get('/fixer', function(){
    //read public/importer.csv
    $csvData = array_map('str_getcsv', file(public_path('importer.csv')));
    $header = array_shift($csvData);
    $rows = array_map(function($row) use ($header){
        return array_combine($header, $row);
    }, $csvData);

    foreach($rows as $row){
        if($row["answer"] != "NULL" || $row["open_question"] != "NULL"){
            MemberQuiz::where('quiz_id', $row["quiz_id"])->where('member_id', $row["user_id"])->update([
                'open_answer' => $row["open_question"],
                'reflection' => $row["answer"]
            ]);
            print_r("Updated member_quiz with quiz_id: " . $row["quiz_id"] . " and member_id: " . $row["user_id"] . "\n");
        }
    }
});

Route::post('/api/generate-token', function (Request $request) {
    $request->validate([
        'email' => 'required|email',
        'password' => 'required'
    ]);
    $credentials = $request->only('email', 'password');

    // Attempt to authenticate the user
    if (Auth::attempt($credentials)) {
        /** @var \App\Models\User $user **/
        $user = Auth::user();
        // Create the token with a specified name
        $token = $user->createToken('token')->plainTextToken;
        return response()->json(['token' => $token]);
    }
    return response()->json(['error' => 'Unauthorized'], 401);
})->withoutMiddleware(VerifyCsrfToken::class);
