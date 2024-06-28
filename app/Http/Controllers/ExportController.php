<?php

namespace App\Http\Controllers;

use App\Models\Character;
use App\Models\Member;
use App\Models\Module;
use App\Models\Quiz;
use Illuminate\Http\Request;

class ExportController extends Controller
{
    public function exportModulesData($members){
        $csvConvert = [
            "Nama Lengkap", "Email", "Tahun lahir", "Agama", "Suku", "Telp", "Alamat", "Kota", 
            "Institusi", "Pendidikan", "Modul", "Karakter", "Timestamp pengisian_H1", "H1_Q1", 
            "H1_Q2", "H1_Q3", "H1_Q4", "H1_Q5", "H1_Q6", "H1_Q7", "H1_Q8", "Total_H1_Berhasil", 
            "Total_H1_Gagal", "Timestamp pengisian_H2", "H2_Q1", "H2_Q2", "H2_Q3", "H2_Q4", 
            "H2_Q5", "H2_Q6", "H2_Q7", "H2_Q8", "Total_H2_Berhasil", "Total_H2_Gagal", 
            "Timestamp pengisian_H3", "H3_Q1", "H3_Q2", "H3_Q3", "H3_Q4", "H3_Q5", "H3_Q6", 
            "H3_Q7", "H3_Q8", "Total_H3_Berhasil", "Total_H3_Gagal", "Timestamp pengisian_H4", 
            "H4_Q1", "H4_Q2", "H4_Q3", "H4_Q4", "H4_Q5", "H4_Q6", "H4_Q7", "H4_Q8", 
            "Total_H4_Berhasil", "Total_H4_Gagal", "Timestamp pengisian_H5", "H5_Q1", "H5_Q2", 
            "H5_Q3", "H5_Q4", "H5_Q5", "H5_Q6", "H5_Q7", "H5_Q8", "Total_H5_Berhasil", 
            "Total_H5_Gagal", "Timestamp pengisian_H6", "H6_Q1", "H6_Q2", "H6_Q3", "H6_Q4", 
            "H6_Q5", "H6_Q6", "H6_Q7", "H6_Q8", "Total_H6_Berhasil", "Total_H6_Gagal", 
            "Timestamp pengisian_H7", "H7_Q1", "H7_Q2", "H7_Q3", "H7_Q4", "H7_Q5", "H7_Q6", 
            "H7_Q7", "H7_Q8", "Total_H7_Berhasil", "Total_H7_Gagal", "Total_H1_H7_Berhasil", 
            "Total_H1_H7_Gagal"
        ];

        $filename = "export_modules_data.csv";
        $handle = fopen($filename, 'w+');

        // Write the headers
        fputcsv($handle, $csvConvert);

        foreach ($members as $member) {
            $finishedCharacter = Character::whereIn('id', Quiz::whereIn('id', $member->questions->pluck('quiz_id'))->pluck('character_id')->toArray())->get();
            foreach ($finishedCharacter as $character) {
                $exportTemplate = array_fill_keys($csvConvert, null);
                
                $exportTemplate["Nama Lengkap"] = $member->name;
                $exportTemplate["Email"] = $member->email;
                $exportTemplate["Tahun lahir"] = $member->birthdate->format('D, d M Y');
                $exportTemplate["Agama"] = $member->religion->name;
                $exportTemplate["Suku"] = $member->ethnic->name;
                $exportTemplate["Alamat"] = $member->address;
                $exportTemplate["Institusi"] = $member->institution->name;
                $exportTemplate["Pendidikan"] = $member->education->name;
                $exportTemplate["Karakter"] = $character->name;
                $exportTemplate["Modul"] = $character->module->name;

                $quizzes = $character->quizzes->take(7);
                foreach ($quizzes as $key => $quiz) {
                    $questionsSorted = $quiz->questions->sortBy('order_number');
                    $exportTemplate["Timestamp pengisian_H" . ($key + 1)] = $quiz->created_at->format('D, d M Y H:i:s');
                    foreach ($questionsSorted as $key2 => $question) {
                        $memberAnswer = $member->questions->where('id', $question->id)->first();
                        if ($memberAnswer) {
                            $exportTemplate["H" . ($key + 1) . "_Q" . ($key2 + 1)] = $memberAnswer->pivot->answer;
                        }
                    }
                    $exportTemplate["H" . ($key + 1) . "_Q8"] = $quiz->open_answer;
                    $exportTemplate["Total_H" . ($key + 1) . "_Berhasil"] = $quiz->questions->where('answer', '1')->count();
                    $exportTemplate["Total_H" . ($key + 1) . "_Gagal"] = $quiz->questions->where('answer', '0')->count();
                }

                $exportTemplate["Total_H1_H7_Berhasil"] = $character->quizzes->where('answer', '1')->count();
                $exportTemplate["Total_H1_H7_Gagal"] = $character->quizzes->where('answer', '0')->count();

                // Write the data row
                fputcsv($handle, $exportTemplate);
            }
        }

        fclose($handle);

        $headers = array(
            'Content-Type' => 'text/csv',
        );

        return response()->download($filename, 'export_modules_data.csv', $headers);
    }
}
