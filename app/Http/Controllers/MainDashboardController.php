<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

// Import lahat ng Models (Siguraduhin na nandito ang FacilityReport)
use App\Models\LearningStandardReport;
use App\Models\RetentionReport;
use App\Models\MedalReport;
use App\Models\AthletesTrainedReport;
use App\Models\ProgramReport;
use App\Models\FacilityReport; // <-- IMPORTANTE ITO

class MainDashboardController extends Controller
{
    public function index()
    {
        // --- 1. Kunin ang Data para sa Scorecards ---

        // Total Programs (OP-1)
        $total_programs = ProgramReport::count();

        // Total Facilities (OP-3) - ITO ANG NAWAWALA KANINA
        $total_facilities = FacilityReport::count();

        // Total Athletes Trained (OP-2)
        $athletes_data = AthletesTrainedReport::select(
            DB::raw('COALESCE(SUM(male_count), 0) as total_male'),
            DB::raw('COALESCE(SUM(female_count), 0) as total_female')
        )->first();
        $total_athletes = $athletes_data->total_male + $athletes_data->total_female;

        // Total Medals (OC-3)
        $medals_data = MedalReport::select(
            DB::raw('COALESCE(SUM(national_gold), 0) as nat_gold'),
            DB::raw('COALESCE(SUM(national_silver), 0) as nat_silver'),
            DB::raw('COALESCE(SUM(national_bronze), 0) as nat_bronze'),
            DB::raw('COALESCE(SUM(international_gold), 0) as int_gold'),
            DB::raw('COALESCE(SUM(international_silver), 0) as int_silver'),
            DB::raw('COALESCE(SUM(international_bronze), 0) as int_bronze')
        )->first();
        $total_medals = $medals_data->nat_gold + $medals_data->nat_silver + $medals_data->nat_bronze +
                        $medals_data->int_gold + $medals_data->int_silver + $medals_data->int_bronze;

        // Overall Retention Rate (OC-2)
        $data_overall = RetentionReport::select(
            DB::raw('COALESCE(SUM(initial_enrollment_male), 0) as total_im'),
            DB::raw('COALESCE(SUM(initial_enrollment_female), 0) as total_if'),
            DB::raw('COALESCE(SUM(transfer_male), 0) as total_tm'),
            DB::raw('COALESCE(SUM(transfer_female), 0) as total_tf'),
            DB::raw('COALESCE(SUM(dropped_male), 0) as total_dm'),
            DB::raw('COALESCE(SUM(dropped_female), 0) as total_df')
        )->first();

        $total_initial = $data_overall->total_im + $data_overall->total_if;
        $total_attrition = ($data_overall->total_tm + $data_overall->total_tf) + ($data_overall->total_dm + $data_overall->total_df);
        $total_retained = $total_initial - $total_attrition;
        $retention_rate = ($total_initial > 0) ? ($total_retained / $total_initial) * 100 : 0;


        // --- 2. Kunin ang Data para sa Main Chart (OC-1) ---
        $oc1_data = LearningStandardReport::select(
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

        $oc1_chart_data = [
            'labels' => ['Outstanding', 'Very Satisfactory', 'Satisfactory', 'Fairly Satisfactory', 'Did not Meet'],
            'data' => [
                $oc1_data->total_om + $oc1_data->total_of,
                $oc1_data->total_vsm + $oc1_data->total_vsf,
                $oc1_data->total_sm + $oc1_data->total_sf,
                $oc1_data->total_fsm + $oc1_data->total_fsf,
                $oc1_data->total_dnm + $oc1_data->total_dnf,
            ]
        ];

        // --- 3. Ipasa lahat sa view ---
        return view('main-dashboard', [
            'total_programs' => $total_programs,
            'total_facilities' => $total_facilities, // <-- SIGURADUHING NANDITO ITO
            'total_athletes' => $total_athletes,
            'total_medals' => $total_medals,
            'retention_rate' => $retention_rate,
            'oc1_chart_data' => $oc1_chart_data,
        ]);
    }
}