<?php

use App\Helpers\ResponseHelper;
use App\Models\Member;
use App\Models\MemberQuestion;
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

Route::get('/superFixer', function(){
    $mq = MemberQuestion::all();
    $edited = 0;
    foreach($mq as $m){
        if(!$m->question){
            print_r("Skipped " . $m->id . " because question is null\n");
            continue;
        }
        $m->member_quiz_id = MemberQuiz::where('quiz_id', $m->question->quiz->id)->where('member_id', $m->member_id)->first()->id;
        $m->save();
        $edited++;
    }
    print_r("Edited " . $edited . " rows");

});

Route::get('/individual-report/{member}', function(){
    return view('individual-report')->with('member', Member::find(request()->route('member')));
})->name('individual-report');




Route::post('/api/login', function (Request $request) {
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
    }else{
      if(Auth::guard('members')->attempt($credentials)){
        $user = Auth::guard('members')->user();
        $token = $user->createToken('token')->plainTextToken;
        return ResponseHelper::success(
            [
                "token_type" => "Bearer",
                "expires_in" => 31536000,
                "access_token" => $token,
                "refresh_token" => $token,
                "user_id" => $user->id,
                "role_id" => 1
            ]
        );
      }
        
    }
    return response()->json(['error' => 'Unauthorized'], 401);
})->withoutMiddleware(VerifyCsrfToken::class);
