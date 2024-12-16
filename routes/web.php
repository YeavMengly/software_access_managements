<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Certificates\AmountCertificateController;
use App\Http\Controllers\Certificates\CertificateController;
use App\Http\Controllers\Certificates\CertificateDataController;
use App\Http\Controllers\Code\AccountKeyController;
use App\Http\Controllers\Code\KeyController;
use App\Http\Controllers\Code\SubAccountKeyController;
use App\Http\Controllers\Components\CertificateCardController;
use App\Http\Controllers\Components\TotalCardController;
use App\Http\Controllers\Components\TotalProgramsController;
use App\Http\Controllers\MissionAbroadController;
use App\Http\Controllers\MissionCambodiaController;
use App\Http\Controllers\Loans\NewLoanController;
use App\Http\Controllers\Loans\RemainController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Result\ResultController;
use App\Http\Controllers\Result\ResultGeneralController;
use App\Http\Controllers\Result\ResultOperationController;
use App\Http\Controllers\Result\ResultSuccess\AdminPlanCenterController;
use App\Http\Controllers\Result\ResultSuccess\CostPerformController;
use App\Http\Controllers\Result\ResultSuccess\TotalController;
use App\Http\Controllers\Result\ResultSummariesController;
use App\Http\Controllers\Result\ResultTotalController;
use App\Http\Controllers\Loans\SumReferController;
use App\Http\Controllers\Report\LoansController;
use App\Http\Controllers\Report\YearController;
use App\Http\Controllers\ReportMissionController;
use App\Http\Controllers\Result\ResultApplyController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

//===============================>> Dashboard
// Route::get('/', function () {
//     return view('dashboard.dashboardui');
// });

//===============================>> Route to display report-mission view
Route::get('/report-mission', function () {
    return view('layouts.table.table-mission.report-mission');
})->name('report-mission');

//===============================>> Manage Route Components Grid
Route::get('/programs', [TotalProgramsController::class, 'index'])->name('programs');
Route::get('/card_certificate', [CertificateCardController::class, 'index'])->name('card_certificate');
Route::get('/total_card', [TotalCardController::class, 'index'])->name('total_card');

//===============================>> Manage Resource
Route::resource('codes', ReportController::class);
Route::resource('keys', KeyController::class);
Route::resource('accounts', AccountKeyController::class);
Route::resource('sub-account', SubAccountKeyController::class);
Route::resource('loans', LoansController::class);
Route::resource('years', YearController::class);

//===============================>> Year
Route::post('/years/{year}/toggle-status', [YearController::class, 'toggleStatus'])->name('date_year_index');
Route::post('/years/{id}/toggle-status', [YearController::class, 'toggleStatus'])->name('years.toggleStatus');

//===============================>> Certificate
Route::resource('certificate', CertificateController::class);
Route::resource('certificate-data', CertificateDataController::class);
Route::get('/certificate-amount', [AmountCertificateController::class, 'index'])->name('certificate-amount');

//===============================>> Manage Mission
Route::get('/reports/{id}/early-balance', [CertificateDataController::class, 'getEarlyBalance']);

//===============================>> Manage Result Operation
Route::get('/total_card/results', [ResultController::class, 'index'])->name('result.index');
Route::get('/result-total', [ResultTotalController::class, 'index'])->name('result-total-table');
Route::get('/result-total-general', [ResultGeneralController::class, 'index'])->name('result-total-general-table');
Route::get('/result-operation', [ResultOperationController::class, 'index'])->name('result-total-operation-table');
Route::get('/result-summaries', [ResultSummariesController::class, 'index'])->name('result-total-summaries-table');
Route::get('/result-apply', [ResultApplyController::class, 'index'])->name('result-applied-table');

//===============================>> Manage Results Achieved
Route::get('/result-success', [TotalController::class, 'index'])->name('result-success');
Route::get('/result-administrative-plan-center', [AdminPlanCenterController::class, 'index'])->name('result-administrative-plan');
Route::get('/result-cost-perform', [CostPerformController::class, 'index'])->name('result-cost-perform');

//===============================>> Loans Total
Route::get('/result-new-loan', [NewLoanController::class, 'index'])->name('result-new-loan');
Route::get('/result-remain', [RemainController::class, 'index'])->name('result-remain');
Route::get('/result-sum-refer', [SumReferController::class, 'index'])->name('result-sum-refer');

//===============================>> In routes/web.php
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

// ==========>> Mission Cambodia <<=============
Route::resource('/mission-cam', MissionCambodiaController::class);
Route::get('/mission-cam/{id}/edit', [MissionCambodiaController::class, 'edit'])->name('missions.edit');
Route::put('/mission-cam/{id}', [MissionCambodiaController::class, 'update'])->name('missions.update');
Route::delete('/mission-cam/{mission}', [MissionCambodiaController::class, 'delete'])->name('missions.delete');

//==================>> Manage Mission Exports and Imports
Route::get('/mission-cambodia/export', [MissionCambodiaController::class, 'export'])->name('table-mission-cambodia');
Route::resource('/reports-missions', ReportMissionController::class);
Route::post('/report-mission', [ReportMissionController::class, 'storeMission'])->name('report-mission.store');
Route::post('/report-table/import', [ReportMissionController::class, 'import'])->name('report-table.import');
Route::get('/imported-mission-table', [ReportMissionController::class, 'importedMissionTable'])->name('imported-mission-table');

//===============================>> Manage Imports
Route::post('/reports/import', [ReportController::class, 'show'])->name('reports.import');
Route::post('/import-excel', [ReportController::class, 'import'])->name('reports.import');
Route::get('/loans/import', [LoansController::class, 'showImportForm'])->name('loans.importForm');
Route::post('/loans/import', [LoansController::class, 'import'])->name('loans.import');

//===============================>> Manage Mission Exports
Route::get('/results/export', [ResultController::class, 'export'])->name('result.export');
Route::get('/summaries/export', [ResultSummariesController::class, 'export'])->name('summaries.export');

//===============================>> Manage Pdf Print
Route::get('/results/pdf', [ResultController::class, 'exportPdf'])->name('result.exportPdf');
Route::get('/summaries/export-pdf', [ResultSummariesController::class, 'exportPdf'])->name('summaries.exportPdf');

Route::get('/mission-abroad', [MissionAbroadController::class, 'index'])->name('table-mission-abroad');
Route::get('/mission-abroad/export', [MissionAbroadController::class, 'export'])->name('table-mission-abroad');


Route::get('/', function () {
    return view('layouts.admin.login');
});


//===============================>> Manage Login Authentication
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::post('/exit', function () {
    Auth::logout(); // Log out the user
    return response()->json(['message' => 'Logged out successfully.']);
});

//===============================>> Manage Back
Route::get('/back', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    if ($user->role === 'user') {
        return redirect()->route('user.dashboard');
    }
    return redirect('/'); // Fallback for unauthenticated users
})->middleware('auth')->name('back');


//===============================>> Manage Role Middlware for admin
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', function () {
        return view('dashboard.dashboardui');
    })->name('admin.dashboard');
});
Route::post('/years/{id}/toggle-status', [YearController::class, 'toggleStatus'])->middleware('auth');


//===============================>> Manage Role Middlware for user
Route::middleware(['auth', 'role:user'])->group(function () {
    Route::get('/user/dashboard', function () {
        return view('dashboard.dashboardui');
    })->name('user.dashboard');
});
