<?php

use App\Models\Member;
use App\Models\MemberQuiz;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/admin');
});


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