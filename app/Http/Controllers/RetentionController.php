<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RetentionReport;
use Illuminate\Support\Facades\DB;

class RetentionController extends Controller
{
    /**
     * Ipakita ang form at ang graph para sa OC No. 2
     */
    public function create(Request $request)
    {
        // --- 1. Kunin ang Filters ---
        $selectedQuarter = $request->input('quarter');
        $selectedGrade = $request->input('grade_level');

        $quarters = RetentionReport::select('quarter')->distinct()->orderBy('quarter')->get();
        $gradeLevels = RetentionReport::select('grade_level')->distinct()->orderBy('grade_level')->get();

        // --- 2. Query para sa OVERALL TOTALS (para sa Scorecards) ---
        $query_overall = RetentionReport::query();
        if ($selectedQuarter) { $query_overall->where('quarter', $selectedQuarter); }
        if ($selectedGrade) { $query_overall->where('grade_level', $selectedGrade); }

        $data_overall = $query_overall->select(
            DB::raw('COALESCE(SUM(initial_enrollment_male), 0) as total_im'),
            DB::raw('COALESCE(SUM(initial_enrollment_female), 0) as total_if'),
            DB::raw('COALESCE(SUM(transfer_male), 0) as total_tm'),
            DB::raw('COALESCE(SUM(transfer_female), 0) as total_tf'),
            DB::raw('COALESCE(SUM(dropped_male), 0) as total_dm'),
            DB::raw('COALESCE(SUM(dropped_female), 0) as total_df')
        )->first();

        // Kalkulahin ang totals para sa Scorecards
        $total_initial = $data_overall->total_im + $data_overall->total_if;
        $total_transfer = $data_overall->total_tm + $data_overall->total_tf;
        $total_dropped = $data_overall->total_dm + $data_overall->total_df;
        $total_attrition = $total_transfer + $total_dropped;
        $total_retained = $total_initial - $total_attrition;

        if ($total_initial > 0) {
            $retention_rate = ($total_retained / $total_initial) * 100;
            $attrition_rate = ($total_attrition / $total_initial) * 100;
        } else {
            $retention_rate = 0;
            $attrition_rate = 0;
        }

        // --- 3. BAGONG Query para sa STACKED BAR CHART (Male/Female Kada Sports) ---
        $query_per_sport = RetentionReport::query();
        if ($selectedQuarter) { $query_per_sport->where('quarter', $selectedQuarter); }
        if ($selectedGrade) { $query_per_sport->where('grade_level', $selectedGrade); }

        $data_per_sport = $query_per_sport->select(
            'focus_sports',
            DB::raw('COALESCE(SUM(initial_enrollment_male), 0) as total_im'),
            DB::raw('COALESCE(SUM(initial_enrollment_female), 0) as total_if'),
            DB::raw('COALESCE(SUM(transfer_male), 0) as total_tm'),
            DB::raw('COALESCE(SUM(transfer_female), 0) as total_tf'),
            DB::raw('COALESCE(SUM(dropped_male), 0) as total_dm'),
            DB::raw('COALESCE(SUM(dropped_female), 0) as total_df')
        )
        ->groupBy('focus_sports')
        ->orderBy('focus_sports')
        ->get();

        // --- 4. I-proseso ang data para sa Bar Chart (MALE vs FEMALE) ---
        $labels = [];
        $retained_male_data = [];
        $retained_female_data = [];

        foreach ($data_per_sport as $sport) {
            $labels[] = $sport->focus_sports;
            
            // Kalkulahin ang retained male/female
            $retained_male = $sport->total_im - ($sport->total_tm + $sport->total_dm);
            $retained_female = $sport->total_if - ($sport->total_tf + $sport->total_df);

            $retained_male_data[] = $retained_male;
            $retained_female_data[] = $retained_female;
        }

        $chartData = [
            'labels' => $labels, // ['Aquatics', 'Athletics', ...]
            'datasets' => [
                [
                    'label' => 'Retained Male',
                    'data' => $retained_male_data,
                    'backgroundColor' => 'rgba(54, 162, 235, 0.7)', // Blue
                ],
                [
                    'label' => 'Retained Female',
                    'data' => $retained_female_data,
                    'backgroundColor' => 'rgba(255, 99, 132, 0.7)', // Red
                ]
            ]
        ];

        // --- 5. Ipasa lahat ng data sa view ---
        return view('reports.create-retention', [
            'chartData' => $chartData, // Para sa Bar Chart
            'quarters' => $quarters,
            'gradeLevels' => $gradeLevels,
            'selectedQuarter' => $selectedQuarter,
            'selectedGrade' => $selectedGrade,
            'retention_rate' => $retention_rate, // Para sa Scorecard
            'attrition_rate' => $attrition_rate, // Para sa Scorecard
            'total_initial' => $total_initial,   // Para sa Scorecard
            'total_retained' => $total_retained, // Para sa Scorecard
            'total_attrition' => $total_attrition, // Para sa Scorecard
        ]);
    }

    /**
     * I-save ang bagong report galing sa OC No. 2 form.
     * (WALANG PAGBABAGO DITO)
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'quarter' => 'required|string',
            'grade_level' => 'required|string',
            'focus_sports' => 'required|string',
            'initial_enrollment_male' => 'required|integer|min:0',
            'initial_enrollment_female' => 'required|integer|min:0',
            'transfer_male' => 'required|integer|min:0',
            'transfer_female' => 'required|integer|min:0',
            'dropped_male' => 'required|integer|min:0',
            'dropped_female' => 'required|integer|min:0',
            'projected_enrollees_male' => 'required|integer|min:0',
            'projected_enrollees_female' => 'required|integer|min:0',
        ]);

        RetentionReport::create($validatedData);

        return redirect()->route('reports.create-retention', [
            'quarter' => $request->quarter,
            'grade_level' => $request->grade_level
        ])->with('success', 'Retention Report submitted successfully!');
    }
}