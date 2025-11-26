<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedalReport;
use Illuminate\Support\Facades\DB;

class MedalController extends Controller
{
    public function create(Request $request)
    {
        $selectedQuarter = $request->input('quarter');
        $selectedGrade = $request->input('grade_level');
        $selectedSport = $request->input('focus_sports');

        $quarters = MedalReport::select('quarter')->distinct()->orderBy('quarter')->get();
        $gradeLevels = MedalReport::select('grade_level')->distinct()->orderBy('grade_level')->get();
        $sports = MedalReport::select('focus_sports')->distinct()->orderBy('focus_sports')->get();

        $query = MedalReport::query();

        if ($selectedQuarter) {
            $query->where('quarter', $selectedQuarter);
        }
        if ($selectedGrade) {
            $query->where('grade_level', $selectedGrade);
        }
        if ($selectedSport) {
            $query->where('focus_sports', $selectedSport);
        }

        $data = $query->select(
            DB::raw('COALESCE(SUM(national_gold), 0) as nat_gold'),
            DB::raw('COALESCE(SUM(national_silver), 0) as nat_silver'),
            DB::raw('COALESCE(SUM(national_bronze), 0) as nat_bronze'),
            DB::raw('COALESCE(SUM(international_gold), 0) as int_gold'),
            DB::raw('COALESCE(SUM(international_silver), 0) as int_silver'),
            DB::raw('COALESCE(SUM(international_bronze), 0) as int_bronze')
        )->first();

        $chartData = [
            'labels' => ['Gold', 'Silver', 'Bronze'],
            'datasets' => [
                [
                    'label' => 'National',
                    'data' => [$data->nat_gold, $data->nat_silver, $data->nat_bronze],
                    'backgroundColor' => 'rgba(54, 162, 235, 0.7)', // Blue
                ],
                [
                    'label' => 'International',
                    'data' => [$data->int_gold, $data->int_silver, $data->int_bronze],
                    'backgroundColor' => 'rgba(255, 99, 132, 0.7)', // Red
                ]
            ]
        ];
        
        $total_national = $data->nat_gold + $data->nat_silver + $data->nat_bronze;
        $total_international = $data->int_gold + $data->int_silver + $data->int_bronze;

        return view('reports.create-medals', [
            'chartData' => $chartData,
            'quarters' => $quarters,
            'gradeLevels' => $gradeLevels,
            'sports' => $sports,
            'selectedQuarter' => $selectedQuarter,
            'selectedGrade' => $selectedGrade,
            'selectedSport' => $selectedSport,
            'total_national' => $total_national,
            'total_international' => $total_international
        ]);
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'quarter' => 'required|string',
            'grade_level' => 'required|string',
            'focus_sports' => 'required|string',
            'national_gold' => 'required|integer|min:0',
            'national_silver' => 'required|integer|min:0',
            'national_bronze' => 'required|integer|min:0',
            'international_gold' => 'required|integer|min:0',
            'international_silver' => 'required|integer|min:0',
            'international_bronze' => 'required|integer|min:0',
        ]);

        MedalReport::create($validatedData);

        return redirect()->route('reports.create-medals', [
            'quarter' => $request->quarter,
            'grade_level' => $request->grade_level,
            'focus_sports' => $request->focus_sports
        ])->with('success', 'Medal Report submitted successfully!');
    }
}