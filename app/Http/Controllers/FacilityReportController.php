<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FacilityReport; // Gamitin ang bago nating model
use Carbon\Carbon; // Para sa pag-format ng petsa

class FacilityReportController extends Controller
{
    /**
     * Ipakita ang form at ang searchable table para sa OP No. 3
     */
    public function create(Request $request)
    {
        $search = $request->input('search');
        $query = FacilityReport::query();

        if ($search) {
            $query->where('type_of_facility', 'like', "%{$search}%")
                  ->orWhere('certifying_body', 'like', "%{$search}%");
        }

        $facilities = $query->orderBy('date_certified', 'desc')->paginate(10);

        return view('reports.create-facility', [
            'facilities' => $facilities,
            'search' => $search
        ]);
    }

    /**
     * I-save ang data mula sa OP No. 3 form
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'type_of_facility' => 'required|string|max:255',
            'date_project_completed' => 'nullable|date',
            'date_certified' => 'required|date',
            'certifying_body' => 'nullable|string|max:255',
            'movs' => 'nullable|string|max:255',
        ]);

        FacilityReport::create($validatedData);

        return redirect()->route('reports.create-facility')
                         ->with('success', 'Facility Report submitted successfully!');
    }
}