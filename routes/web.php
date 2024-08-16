<?php

use App\Http\Controllers\Certificates\AmountCertificateController;
use App\Http\Controllers\Certificates\CertificateController;
use App\Http\Controllers\Certificates\CertificateDataController;
use App\Http\Controllers\Code\AccountKeyController;
use App\Http\Controllers\Code\KeyController;
use App\Http\Controllers\Code\SubAccountKeyController;
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
use App\Http\Controllers\ResultMissionController;
use App\Http\Controllers\Loans\SumReferController;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', function () {
    return view('layouts.table.result');
});


//===============================>> Manage Resource
Route::resource('codes', ReportController::class);
Route::resource('keys', KeyController::class);
Route::resource('accounts', AccountKeyController::class);
Route::resource('sub-account', SubAccountKeyController::class);

//===============================>> Certificate
Route::resource('certificate', CertificateController::class);
Route::resource('certificate-data', CertificateDataController::class);


Route::get('/certificate-amount', [AmountCertificateController::class, 'index'])->name('certificate-amount');




//===============================>> Manage Mission
Route::resource('missions', ResultMissionController::class);

//===============================>> Manage Result Operation
Route::get('/', [ResultController::class, 'index'])->name('result');
Route::get('/results', [ResultController::class, 'index'])->name('result.index');
Route::get('/result-total', [ResultTotalController::class, 'index'])->name('result-total-table');
Route::get('/result-total-general', [ResultGeneralController::class, 'index'])->name('result-total-general-table');
Route::get('/result-operation', [ResultOperationController::class, 'index'])->name('result-total-operation-table');
Route::get('/result-summaries', [ResultSummariesController::class, 'index'])->name('result-total-summaries-table');

//===============================>> Manage Results Achieved
Route::get('/result-success', [TotalController::class, 'index'])->name('result-success');
Route::get('/result-administrative-plan-center', [AdminPlanCenterController::class, 'index'])->name('result-administrative-plan');
Route::get('/result-cost-perform', [CostPerformController::class, 'index'])->name('result-cost-perform');

//===============================>> Loans Total
Route::get('/result-new-loan', [NewLoanController::class, 'index'])->name('result-new-loan');
Route::get('/result-remain', [RemainController::class, 'index'])->name('result-remain');
Route::get('/result-sum-refer', [SumReferController::class, 'index'])->name('result-sum-refer');

// In routes/web.php
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

Route::get('/mission-cam', [MissionCambodiaController::class, 'index'])->name('table-mission-cambodia');


//===============================>> Manage Exports


//===============================>> Manage Mission Exports

Route::get('/mission-cambodia/export', [MissionCambodiaController::class, 'export'])->name('table-mission-cambodia');

Route::get('/export', [ResultController::class, 'export'])->name('result.export');


//===============================>> Manage Pdf Print
Route::get('/results/pdf', [ResultController::class, 'exportPdf'])->name('result.exportPdf');
