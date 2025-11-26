<?php

use Illuminate\Support\Facades\Route;

// IMPORT LAHAT NG (8) NA CONTROLLERS
use App\Http\Controllers\MainDashboardController;
use App\Http\Controllers\ReportController;          // OC-1
use App\Http\Controllers\RetentionController;       // OC-2
use App\Http\Controllers\MedalController;           // OC-3
use App\Http\Controllers\ProgramReportController;   // OP-1
use App\Http\Controllers\AthletesTrainedController; // OP-2
use App\Http\Controllers\FacilityReportController;  // OP-3
use App\Http\Controllers\BarReportController;       // BAR Report

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- HOMEPAGE (MAIN DASHBOARD) ---
Route::get('/', [MainDashboardController::class, 'index'])->name('main.dashboard');


// --- OUTCOME INDICATORS (OC) ---

// OC No. 1: Learning Standards
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

// OC No. 2: Retention Rate
Route::get('/reports/create-retention', [RetentionController::class, 'create'])->name('reports.create-retention');
Route::post('/reports-retention', [RetentionController::class, 'store'])->name('reports.store-retention');

// OC No. 3: Medal Tally
Route::get('/reports/create-medals', [MedalController::class, 'create'])->name('reports.create-medals');
Route::post('/reports-medals', [MedalController::class, 'store'])->name('reports.store-medals');


// --- OUTPUT INDICATORS (OP) ---

// OP No. 1: Programs Implemented
Route::get('/reports/create-program', [ProgramReportController::class, 'create'])->name('reports.create-program');
Route::post('/reports-program', [ProgramReportController::class, 'store'])->name('reports.store-program');

// OP No. 2: Athletes Trained
Route::get('/reports/create-athletes-trained', [AthletesTrainedController::class, 'create'])->name('reports.create-athletes-trained');
Route::post('/reports-athletes-trained', [AthletesTrainedController::class, 'store'])->name('reports.store-athletes-trained');

// OP No. 3: Facilities Certified
Route::get('/reports/create-facility', [FacilityReportController::class, 'create'])->name('reports.create-facility');
Route::post('/reports-facility', [FacilityReportController::class, 'store'])->name('reports.store-facility');


// --- BAR REPORT (QUARTERLY PHYSICAL REPORT) ---

// View Report
Route::get('/reports/bar-report', [BarReportController::class, 'index'])->name('reports.bar-report');

// Edit Targets Form
Route::get('/reports/bar-report/edit-targets', [BarReportController::class, 'editTargets'])->name('reports.edit-targets');

// Save Updated Targets
Route::post('/reports/bar-report/update-targets', [BarReportController::class, 'updateTargets'])->name('reports.update-targets');