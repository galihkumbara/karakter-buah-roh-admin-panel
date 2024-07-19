
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRIEF SUMMARY DIARY OF CHARACTER</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-8">
        <div class="bg-white shadow-md rounded-lg p-6">
            <div class="text-center mb-6">
                <h1 class="text-3xl font-bold text-blue-600">BRIEF SUMMARY DIARY OF CHARACTER</h1>
            </div>
            <div class="mb-4">
                <p class="text-lg"><span class="font-semibold">Nama Institusi:</span> {{$member->institution->name}}</p>
                <p class="text-lg"><span class="font-semibold">Nama Siswa:</span> {{$member->name}}</p>
                <p class="text-lg"><span class="font-semibold">Jenis Kelamin:</span> {{$member->gender}}</p>
                <p class="text-lg"><span class="font-semibold">Kelas:</span> {{$member->education->name}}</p>
            </div>
            @foreach ($member->modules as $module)
                <p class="text-lg "><span class="font-semibold">Modul:</span> {{$module->name}}</p> 
            
                @foreach ($member->finished_character() as $character)
                    <p class="text-lg "><span class="font-semibold">Karakter:</span> {{$character->name}}</p>
                    @php
                    $commitment = "";
                    //if 6-7 quiz is done, then commitment is Baik
                    //if 3-5 quiz is done, then commitment is Cukup
                    //if 0-2 quiz is done, then commitment is Kurang
                    $this_quiz = $member->quizzes->pluck('quiz_id')->intersect($character->quizzes->pluck('id'))->count();
                    if($this_quiz >= 6){
                        $commitment = "Baik";
                    }elseif($this_quiz >= 3){
                        $commitment = "Cukup";
                    }else{
                        $commitment = "Kurang";
                    }

                    @endphp
                    <p class="text-lg "><span class="font-semibold">Komitmen: {{$commitment}} </span> </p>
                    <table>
                        <thead>
                            <tr>
                                <th class="border px-4 py-1">H1</th>
                                <th class="border px-4 py-1">H2</th>
                                <th class="border px-4 py-1">H3</th>
                                <th class="border px-4 py-1">H4</th>
                                <th class="border px-4 py-1">H5</th>
                                <th class="border px-4 py-1">H6</th>
                                <th class="border px-4 py-1">H7</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($character->quizzes->take(7) as $quiz)
                                @if($member->quizzes->pluck('quiz_id')->contains($quiz->id))
                                    <td class="h-6" bgcolor="green"></td>
                                @else
                                    <td class="h-6" bgcolor="gray"></td>
                                @endif
                            @endforeach
                        </tbody>
                    </table>


                @endforeach
            @endforeach
        </div>
    </div>
</body>
</html>
