<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BRIEF SUMMARY DIARY OF CHARACTER</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2pdf.js/0.9.2/html2pdf.bundle.min.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">
    <div class="container mx-auto p-8">
        <div class="text-right mb-4">
            <button id="downloadPdf" class="bg-blue-500 text-white px-4 py-2 rounded">Download PDF</button>
        </div>
        <div id="mainExport" class="bg-white shadow-md rounded-lg p-6">
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
            
                @foreach ($member->finished_character()->where('module_id', $module->id) as $character)
                    <p class="text-lg "><span class="font-semibold">Karakter:</span> {{$character->name}}</p>
                    @php
                    $commitment = "";
                    $this_quiz = $member->quizzes->where('character_id', $character->id)->count();
                    if($this_quiz >= 6){
                        $commitment = "Baik";
                    } elseif($this_quiz >= 3){
                        $commitment = "Cukup";
                    } else {
                        $commitment = "Kurang";
                    }
                    @endphp
                    <p class="text-lg "><span class="font-semibold">Komitmen: {{$commitment}} </span> </p>
                    @php
                        $correctAnswerList = [];
                    @endphp
                    @foreach ($character->quizzes->take(7) as $quiz)
                        @php
                            $memberAnswer = $member->member_questions->whereIn('question_id', $quiz->questions->pluck('id'));
                            $correctAnswer = $memberAnswer->where('answer', 1)->count();
                            $correctAnswerList[] = $correctAnswer;
                        @endphp
                    @endforeach
                    <canvas id="lineChart-{{$character->id}}" width="400" height="200"></canvas>
         
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
                            <tr>
                            @foreach ($character->quizzes->take(7) as $quiz)
                                @if($member->quizzes->pluck('quiz_id')->contains($quiz->id))
                                    <td class="h-6" bgcolor="green"></td>
                                @else
                                    <td class="h-6" bgcolor="gray"></td>
                                @endif
                            @endforeach
                            </tr>
                        </tbody>
                    </table>

                    <script>
                        var ctx = document.getElementById('lineChart-{{$character->id}}').getContext('2d');
                        var lineChart = new Chart(ctx, {
                            type: 'line',
                            data: {
                                labels: ['Hari 1', 'Hari 2', 'Hari 3', 'Hari 4', 'Hari 5', 'Hari 6', 'Hari 7'],
                                datasets: [{
                                    label: 'Values',
                                    data: @json($correctAnswerList),
                                    borderColor: 'rgba(75, 192, 192, 1)',
                                    borderWidth: 2,
                                    fill: false
                                }]
                            },
                            options: {
                                scales: {
                                    x: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Hari'
                                        }
                                    },
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Value'
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                @endforeach
            @endforeach
        </div>
    </div>
    <script>
        document.getElementById('downloadPdf').addEventListener('click', function () {
            var element = document.getElementById('mainExport');
            html2pdf(element, {
                margin: 1,
                filename: 'Brief_Summary_Diary_of_Character.pdf',
                image: { type: 'jpeg', quality: 0.98 },
                html2canvas: { scale: 2 },
                jsPDF: { unit: 'in', format: 'letter', orientation: 'portrait' }
            });
        });
    </script>
</body>
</html>
