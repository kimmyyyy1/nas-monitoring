<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LearningStandardReport;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    /**
     * Ipakita ang form at ang graph para sa OC No. 1
     */
    public function create(Request $request)
    {
        // Kunin ang lahat ng filters mula sa URL
        $selectedQuarter = $request->input('quarter');
        $selectedGrade = $request->input('grade_level'); // <-- ITO ANG DINAGDAG KO

        // Kunin ang data para sa filter dropdowns
        $quarters = LearningStandardReport::select('quarter')->distinct()->get();
        $gradeLevels = LearningStandardReport::select('grade_level')->distinct()->get(); // <-- AT ITO

        $query = LearningStandardReport::query();

        // I-apply ang filters sa query
        if ($selectedQuarter) {
            $query->where('quarter', $selectedQuarter);
        }
        if ($selectedGrade) { // <-- ITO ANG BAGONG FILTER LOGIC
            $query->where('grade_level', $selectedGrade);
        }

        // Kunin ang SUM (COALESCE ay para 'wag mag-error kung NULL/blangko)
        $data = $query->select(
            DB::raw('COALESCE(SUM(outstanding_male), 0) as total_om'),
            DB::raw('COALESCE(SUM(outstanding_female), 0) as total_of'),
            DB::raw('COALESCE(SUM(very_satisfactory_male), 0) as total_vsm'),
            DB::raw('COALESCE(SUM(very_satisfactory_female), 0) as total_vsf'),
            DB::raw('COALESCE(SUM(satisfactory_male), 0) as total_sm'),
            DB::raw('COALESCE(SUM(satisfactory_female), 0) as total_sf'),
            DB::raw('COALESCE(SUM(fairly_satisfactory_male), 0) as total_fsm'),
            DB::raw('COALESCE(SUM(fairly_satisfactory_female), 0) as total_fsf'),
            DB::raw('COALESCE(SUM(did_not_meet_male), 0) as total_dnm'),
            DB::raw('COALESCE(SUM(did_not_meet_female), 0) as total_dnf')
        )->first();

        // Kalkulahin ang totals
        $total_outstanding = $data->total_om + $data->total_of;
        $total_vs = $data->total_vsm + $data->total_vsf;
        $total_s = $data->total_sm + $data->total_sf;
        $total_fs = $data->total_fsm + $data->total_fsf;
        $total_dnm = $data->total_dnm + $data->total_dnf;

        $chartData = [
            'labels' => ['Outstanding', 'Very Satisfactory', 'Satisfactory', 'Fairly Satisfactory', 'Did not Meet'],
            'data' => [$total_outstanding, $total_vs, $total_s, $total_fs, $total_dnm]
        ];
        
        // Ipasa ang LAHAT ng data sa view
        return view('reports.create', [
            'chartData' => $chartData,
            'quarters' => $quarters,
            'gradeLevels' => $gradeLevels, // <-- IPASA ANG GRADE LEVELS
            'selectedQuarter' => $selectedQuarter,
            'selectedGrade' => $selectedGrade, // <-- IPASA ANG SELECTED GRADE
        ]);
    }

    /**
     * I-save ang bagong report galing sa OC No. 1 form.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'quarter' => 'required|string',
            'grade_level' => 'required|string',
            // ... (iba pang fields) ...
            'outstanding_male' => 'required|integer|min:0',
            'outstanding_female' => 'required|integer|min:0',
            'very_satisfactory_male' => 'required|integer|min:0',
            'very_satisfactory_female' => 'required|integer|min:0',
            'satisfactory_male' => 'required|integer|min:0',
            'satisfactory_female' => 'required|integer|min:0',
            'fairly_satisfactory_male' => 'required|integer|min:0',
            'fairly_satisfactory_female' => 'required|integer|min:0',
            'did_not_meet_male' => 'required|integer|min:0',
            'did_not_meet_female' => 'required|integer|min:0',
        ]);

        LearningStandardReport::create($validatedData);

        // Ito ang "Smart Redirect"
        return redirect()->route('reports.create', [
            'quarter' => $request->quarter,
            'grade_level' => $request->grade_level // <-- Ipasa ang grade_level
        ])->with('success', 'Report submitted successfully!');
    }
}