<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\MedalReport;
use Illuminate\Support\Facades\DB;

class MedalController extends Controller
{
    /**
     * OC-3: MAIN DASHBOARD (View Only)
     */
    public function index(Request $request)
    {
        // 1. Get Filters
        $selectedQuarter = $request->input('quarter');
        $selectedGrade = $request->input('grade_level');
        $selectedSport = $request->input('focus_sports');

        // 2. Get Dropdown Data
        $quarters = MedalReport::select('quarter')->distinct()->orderBy('quarter')->get();
        $gradeLevels = MedalReport::select('grade_level')->distinct()->orderBy('grade_level')->get();
        $sports = MedalReport::select('focus_sports')->distinct()->orderBy('focus_sports')->get();

        // 3. Query Data
        $query = MedalReport::query();
        if ($selectedQuarter) $query->where('quarter', $selectedQuarter);
        if ($selectedGrade) $query->where('grade_level', $selectedGrade);
        if ($selectedSport) $query->where('focus_sports', $selectedSport);

        $data = $query->select(
            DB::raw('COALESCE(SUM(national_gold), 0) as nat_gold'),
            DB::raw('COALESCE(SUM(national_silver), 0) as nat_silver'),
            DB::raw('COALESCE(SUM(national_bronze), 0) as nat_bronze'),
            DB::raw('COALESCE(SUM(international_gold), 0) as int_gold'),
            DB::raw('COALESCE(SUM(international_silver), 0) as int_silver'),
            DB::raw('COALESCE(SUM(international_bronze), 0) as int_bronze')
        )->first();

        // 4. Prepare Data for View
        $nationalData = ['labels' => ['Gold', 'Silver', 'Bronze'], 'data' => [$data->nat_gold, $data->nat_silver, $data->nat_bronze]];
        $internationalData = ['labels' => ['Gold', 'Silver', 'Bronze'], 'data' => [$data->int_gold, $data->int_silver, $data->int_bronze]];
        
        $total_national = $data->nat_gold + $data->nat_silver + $data->nat_bronze;
        $total_international = $data->int_gold + $data->int_silver + $data->int_bronze;

        return view('reports.medals.dashboard', compact(
            'nationalData', 'internationalData', 'total_national', 'total_international',
            'quarters', 'gradeLevels', 'sports',
            'selectedQuarter', 'selectedGrade', 'selectedSport'
        ));
    }

    /**
     * OC-3.1: NATIONAL (Form Entry)
     */
    public function createNational(Request $request)
    {
        // --- KAILANGAN DIN NITO NG DATA PARA SA RIGHT SIDE DASHBOARD ---
        
        $selectedQuarter = $request->input('quarter');
        $selectedGrade = $request->input('grade_level');
        $selectedSport = $request->input('focus_sports');

        $quarters = MedalReport::select('quarter')->distinct()->orderBy('quarter')->get();
        $gradeLevels = MedalReport::select('grade_level')->distinct()->orderBy('grade_level')->get();
        $sports = MedalReport::select('focus_sports')->distinct()->orderBy('focus_sports')->get();

        // Query for National Stats only
        $query = MedalReport::query();
        if ($selectedQuarter) $query->where('quarter', $selectedQuarter);
        if ($selectedGrade) $query->where('grade_level', $selectedGrade);
        if ($selectedSport) $query->where('focus_sports', $selectedSport);

        $data = $query->select(
            DB::raw('COALESCE(SUM(national_gold), 0) as nat_gold'),
            DB::raw('COALESCE(SUM(national_silver), 0) as nat_silver'),
            DB::raw('COALESCE(SUM(national_bronze), 0) as nat_bronze')
        )->first();

        $nationalData = [
            'labels' => ['Gold', 'Silver', 'Bronze'],
            'data' => [$data->nat_gold, $data->nat_silver, $data->nat_bronze]
        ];
        $total_national = $data->nat_gold + $data->nat_silver + $data->nat_bronze;

        return view('reports.medals.create-national', compact(
            'quarters', 'gradeLevels', 'sports',
            'selectedQuarter', 'selectedGrade', 'selectedSport',
            'nationalData', 'total_national'
        ));
    }

    public function storeNational(Request $request)
    {
        $validatedData = $request->validate([
            'quarter' => 'required|string',
            'grade_level' => 'required|string',
            'focus_sports' => 'required|string',
            'national_gold' => 'required|integer|min:0',
            'national_silver' => 'required|integer|min:0',
            'national_bronze' => 'required|integer|min:0',
        ]);

        MedalReport::create(array_merge($validatedData, [
            'international_gold' => 0, 'international_silver' => 0, 'international_bronze' => 0
        ]));

        return redirect()->route('medals.national.create', [
            'quarter' => $request->quarter,
            'grade_level' => $request->grade_level,
            'focus_sports' => $request->focus_sports
        ])->with('success', 'National Medal Report submitted!');
    }

    /**
     * OC-3.2: INTERNATIONAL (Form Entry)
     */
    public function createInternational(Request $request)
    {
        // --- KAILANGAN DIN NITO NG DATA PARA SA RIGHT SIDE DASHBOARD ---

        $selectedQuarter = $request->input('quarter');
        $selectedGrade = $request->input('grade_level');
        $selectedSport = $request->input('focus_sports');

        $quarters = MedalReport::select('quarter')->distinct()->orderBy('quarter')->get();
        $gradeLevels = MedalReport::select('grade_level')->distinct()->orderBy('grade_level')->get();
        $sports = MedalReport::select('focus_sports')->distinct()->orderBy('focus_sports')->get();

        // Query for International Stats only
        $query = MedalReport::query();
        if ($selectedQuarter) $query->where('quarter', $selectedQuarter);
        if ($selectedGrade) $query->where('grade_level', $selectedGrade);
        if ($selectedSport) $query->where('focus_sports', $selectedSport);

        $data = $query->select(
            DB::raw('COALESCE(SUM(international_gold), 0) as int_gold'),
            DB::raw('COALESCE(SUM(international_silver), 0) as int_silver'),
            DB::raw('COALESCE(SUM(international_bronze), 0) as int_bronze')
        )->first();

        $internationalData = [
            'labels' => ['Gold', 'Silver', 'Bronze'],
            'data' => [$data->int_gold, $data->int_silver, $data->int_bronze]
        ];
        $total_international = $data->int_gold + $data->int_silver + $data->int_bronze;

        return view('reports.medals.create-international', compact(
            'quarters', 'gradeLevels', 'sports',
            'selectedQuarter', 'selectedGrade', 'selectedSport',
            'internationalData', 'total_international'
        ));
    }

    public function storeInternational(Request $request)
    {
        $validatedData = $request->validate([
            'quarter' => 'required|string',
            'grade_level' => 'required|string',
            'focus_sports' => 'required|string',
            'international_gold' => 'required|integer|min:0',
            'international_silver' => 'required|integer|min:0',
            'international_bronze' => 'required|integer|min:0',
        ]);

        MedalReport::create(array_merge($validatedData, [
            'national_gold' => 0, 'national_silver' => 0, 'national_bronze' => 0
        ]));

        return redirect()->route('medals.international.create', [
            'quarter' => $request->quarter,
            'grade_level' => $request->grade_level,
            'focus_sports' => $request->focus_sports
        ])->with('success', 'International Medal Report submitted!');
    }
}