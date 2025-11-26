<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\PerformanceTarget;
use App\Models\ProgramReport;
use App\Models\AthletesTrainedReport;
use App\Models\FacilityReport;

class BarReportController extends Controller
{
    public function index()
    {
        // 1. Auto-Seed: Kung walang laman, gumawa ng rows pero ZERO (0) ang targets
        if (PerformanceTarget::count() == 0) {
            PerformanceTarget::create(['indicator_name' => 'Programs Implemented (OP-1)', 'q1_target' => 0, 'q2_target' => 0, 'q3_target' => 0, 'q4_target' => 0]);
            PerformanceTarget::create(['indicator_name' => 'Student Athletes Trained (OP-2)', 'q1_target' => 0, 'q2_target' => 0, 'q3_target' => 0, 'q4_target' => 0]);
            PerformanceTarget::create(['indicator_name' => 'Facilities Certified (OP-3)', 'q1_target' => 0, 'q2_target' => 0, 'q3_target' => 0, 'q4_target' => 0]);
        }

        $targets = PerformanceTarget::all()->keyBy('indicator_name');

        // 2. Calculate Actual Accomplishments
        $op1_accom = [
            'q1' => ProgramReport::whereMonth('date_of_implementation', '>=', 1)->whereMonth('date_of_implementation', '<=', 3)->count(),
            'q2' => ProgramReport::whereMonth('date_of_implementation', '>=', 4)->whereMonth('date_of_implementation', '<=', 6)->count(),
            'q3' => ProgramReport::whereMonth('date_of_implementation', '>=', 7)->whereMonth('date_of_implementation', '<=', 9)->count(),
            'q4' => ProgramReport::whereMonth('date_of_implementation', '>=', 10)->whereMonth('date_of_implementation', '<=', 12)->count(),
        ];

        $op2_accom = [
            'q1' => AthletesTrainedReport::where('quarter', 'like', '%1%')->sum(DB::raw('male_count + female_count')),
            'q2' => AthletesTrainedReport::where('quarter', 'like', '%2%')->sum(DB::raw('male_count + female_count')),
            'q3' => AthletesTrainedReport::where('quarter', 'like', '%3%')->sum(DB::raw('male_count + female_count')),
            'q4' => AthletesTrainedReport::where('quarter', 'like', '%4%')->sum(DB::raw('male_count + female_count')),
        ];

        $op3_accom = [
            'q1' => FacilityReport::whereMonth('date_certified', '>=', 1)->whereMonth('date_certified', '<=', 3)->count(),
            'q2' => FacilityReport::whereMonth('date_certified', '>=', 4)->whereMonth('date_certified', '<=', 6)->count(),
            'q3' => FacilityReport::whereMonth('date_certified', '>=', 7)->whereMonth('date_certified', '<=', 9)->count(),
            'q4' => FacilityReport::whereMonth('date_certified', '>=', 10)->whereMonth('date_certified', '<=', 12)->count(),
        ];

        $reportData = [
            [
                'name' => 'Programs Implemented (OP-1)',
                'target' => $targets['Programs Implemented (OP-1)'],
                'accom' => $op1_accom
            ],
            [
                'name' => 'Student Athletes Trained (OP-2)',
                'target' => $targets['Student Athletes Trained (OP-2)'],
                'accom' => $op2_accom
            ],
            [
                'name' => 'Facilities Certified (OP-3)',
                'target' => $targets['Facilities Certified (OP-3)'],
                'accom' => $op3_accom
            ]
        ];

        return view('reports.bar-report', compact('reportData'));
    }

    // --- MGA FUNCTION PARA SA EDITING (ITO ANG NAWALA KANINA) ---

    public function editTargets()
    {
        $targets = PerformanceTarget::all();
        return view('reports.edit-targets', compact('targets'));
    }

    public function updateTargets(Request $request)
    {
        $data = $request->input('targets');

        foreach ($data as $id => $values) {
            $target = PerformanceTarget::find($id);
            if ($target) {
                $target->update([
                    'q1_target' => $values['q1'],
                    'q2_target' => $values['q2'],
                    'q3_target' => $values['q3'],
                    'q4_target' => $values['q4'],
                ]);
            }
        }

        return redirect()->route('reports.bar-report')->with('success', 'Physical Targets updated successfully!');
    }
}