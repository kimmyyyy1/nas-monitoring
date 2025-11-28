<?php

use Illuminate\Support\Facades\Route;

// IMPORT LAHAT NG CONTROLLERS
use App\Http\Controllers\MainDashboardController;
use App\Http\Controllers\ReportController;          // OC-1
use App\Http\Controllers\RetentionController;       // OC-2
use App\Http\Controllers\MedalController;           // OC-3 (Split)
use App\Http\Controllers\ProgramReportController;   // OP-1
use App\Http\Controllers\AthletesTrainedController; // OP-2
use App\Http\Controllers\FacilityReportController;  // OP-3
use App\Http\Controllers\BarReportController;       // BAR

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- HOMEPAGE ---
Route::get('/', [MainDashboardController::class, 'index'])->name('main.dashboard');

// --- OC No. 1: Learning Standards ---
Route::get('/reports/create', [ReportController::class, 'create'])->name('reports.create');
Route::post('/reports', [ReportController::class, 'store'])->name('reports.store');

// --- OC No. 2: Retention Rate ---
Route::get('/reports/create-retention', [RetentionController::class, 'create'])->name('reports.create-retention');
Route::post('/reports-retention', [RetentionController::class, 'store'])->name('reports.store-retention');

// --- OC No. 3: Medal Tally (SPLIT VERSION) ---
Route::get('/reports/medals/dashboard', [MedalController::class, 'index'])->name('medals.dashboard'); // Ito ang bago
Route::get('/reports/medals/national', [MedalController::class, 'createNational'])->name('medals.national.create');
Route::post('/reports/medals/national', [MedalController::class, 'storeNational'])->name('medals.national.store');
Route::get('/reports/medals/international', [MedalController::class, 'createInternational'])->name('medals.international.create');
Route::post('/reports/medals/international', [MedalController::class, 'storeInternational'])->name('medals.international.store');

// --- OP No. 1: Programs ---
Route::get('/reports/create-program', [ProgramReportController::class, 'create'])->name('reports.create-program');
Route::post('/reports-program', [ProgramReportController::class, 'store'])->name('reports.store-program');

// --- OP No. 2: Athletes Trained ---
Route::get('/reports/create-athletes-trained', [AthletesTrainedController::class, 'create'])->name('reports.create-athletes-trained');
Route::post('/reports-athletes-trained', [AthletesTrainedController::class, 'store'])->name('reports.store-athletes-trained');

// --- OP No. 3: Facilities ---
Route::get('/reports/create-facility', [FacilityReportController::class, 'create'])->name('reports.create-facility');
Route::post('/reports-facility', [FacilityReportController::class, 'store'])->name('reports.store-facility');

// --- BAR REPORT ---
Route::get('/reports/bar-report', [BarReportController::class, 'index'])->name('reports.bar-report');
Route::get('/reports/bar-report/edit-targets', [BarReportController::class, 'editTargets'])->name('reports.edit-targets');
Route::post('/reports/bar-report/update-targets', [BarReportController::class, 'updateTargets'])->name('reports.update-targets');