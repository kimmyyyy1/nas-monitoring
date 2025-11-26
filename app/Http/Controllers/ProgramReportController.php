<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramReport; // Gamitin ang bago nating model

class ProgramReportController extends Controller
{
    /**
     * Ipakita ang form at ang searchable table para sa OP No. 1
     */
    public function create(Request $request)
    {
        // 1. Kunin ang search query mula sa URL
        $search = $request->input('search');

        // 2. Simulan ang query
        $query = ProgramReport::query();

        // 3. Kung may search, i-filter ang query
        if ($search) {
            // Siguraduhin na ang lahat ng sine-search ay string-based
            $query->where('program_title', 'like', "%{$search}%")
                  ->orWhere('proponent', 'like', "%{$search}%")
                  ->orWhere('target_beneficiaries', 'like', "%{$search}%")
                  ->orWhere('accomplishment', 'like', "%{$search}%");
        }

        // 4. Kunin ang resulta, 10 bawat page, pinakabago muna
        $programs = $query->orderBy('date_of_implementation', 'desc')->paginate(10);

        // 5. Ipasa ang data (ang $programs at $search term) sa view
        return view('reports.create-program', [
            'programs' => $programs,
            'search' => $search
        ]);
    }

    /**
     * I-save ang data mula sa OP No. 1 form
     */
    public function store(Request $request)
    {
        // 1. Validation
        $validatedData = $request->validate([
            'proponent' => 'nullable|string|max:255',
            'program_title' => 'required|string|max:255',
            'target_beneficiaries' => 'nullable|string|max:255',
            'output_indicator' => 'nullable|string|max:255',
            'accomplishment' => 'nullable|string',
            'date_of_implementation' => 'required|date',
            'date_of_completion' => 'nullable|date|after_or_equal:date_of_implementation',
            'movs' => 'nullable|string|max:255',
        ]);

        // 2. Pag-save sa database
        ProgramReport::create($validatedData);

        // 3. Redirect pabalik
        return redirect()->route('reports.create-program')
                         ->with('success', 'Program Report submitted successfully!');
    }
}