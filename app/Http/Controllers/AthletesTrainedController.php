<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AthletesTrainedReport;
use Illuminate\Support\Facades\DB;

class AthletesTrainedController extends Controller
{
    /**
     * Ipakita ang form at ang graph para sa OP No. 2
     */
    public function create(Request $request)
    {
        // 1. Kunin ang mga filters
        $selectedQuarter = $request->input('quarter');
        $selectedGrade = $request->input('grade_level');
        $selectedSport = $request->input('focus_sports');

        // 2. Kunin ang data para sa filter dropdowns
        $quarters = AthletesTrainedReport::select('quarter')->distinct()->orderBy('quarter')->get();
        $gradeLevels = AthletesTrainedReport::select('grade_level')->distinct()->orderBy('grade_level')->get();
        $sports = AthletesTrainedReport::select('focus_sports')->distinct()->orderBy('focus_sports')->get();

        // 3. Simulan ang query para sa graph
        $query = AthletesTrainedReport::query();

        if ($selectedQuarter) {
            $query->where('quarter', $selectedQuarter);
        }
        if ($selectedGrade) {
            $query->where('grade_level', $selectedGrade);
        }
        if ($selectedSport) {
            $query->where('focus_sports', $selectedSport);
        }

        // 4. Kunin ang data na naka-grupo bawat sports
        $data = $query->select(
            'focus_sports',
            DB::raw('COALESCE(SUM(male_count), 0) as total_male'),
            DB::raw('COALESCE(SUM(female_count), 0) as total_female')
        )
        ->groupBy('focus_sports')
        ->orderBy('focus_sports')
        ->get();

        // 5. Ihanda ang data para sa Chart.js (Stacked Bar Chart)
        $chartData = [
            'labels' => $data->pluck('focus_sports'),
            'datasets' => [
                [
                    'label' => 'Male',
                    'data' => $data->pluck('total_male'),
                    'backgroundColor' => 'rgba(54, 162, 235, 0.7)', // Blue
                ],
                [
                    'label' => 'Female',
                    'data' => $data->pluck('total_female'),
                    'backgroundColor' => 'rgba(255, 99, 132, 0.7)', // Red
                ]
            ]
        ];

        // 6. Kunin ang total para sa Scorecards
        $total_male = $data->sum('total_male');
        $total_female = $data->sum('total_female');

        // 7. Ipasa lahat ng data sa bagong view
        return view('reports.create-athletes-trained', [
            'chartData' => $chartData,
            'quarters' => $quarters,
            'gradeLevels' => $gradeLevels,
            'sports' => $sports,
            'selectedQuarter' => $selectedQuarter,
            'selectedGrade' => $selectedGrade,
            'selectedSport' => $selectedSport,
            'total_male' => $total_male,
            'total_female' => $total_female
        ]);
    }

    /**
     * I-save ang data mula sa OP No. 2 form
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'quarter' => 'required|string',
            'grade_level' => 'required|string',
            'focus_sports' => 'required|string',
            'male_count' => 'required|integer|min:0',
            'female_count' => 'required|integer|min:0',
        ]);

        AthletesTrainedReport::create($validatedData);

        // "Smart Redirect"
        return redirect()->route('reports.create-athletes-trained', [
            'quarter' => $request->quarter,
            'grade_level' => $request->grade_level,
            'focus_sports' => $request->focus_sports
        ])->with('success', 'Athletes Trained Report submitted successfully!');
    }
}