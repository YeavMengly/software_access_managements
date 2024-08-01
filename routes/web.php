<?php

use App\Http\Controllers\Code\AccountKeyController;
use App\Http\Controllers\Code\KeyController;
use App\Http\Controllers\Code\SubAccountKeyController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Result\ResultController;
use App\Http\Controllers\Result\ResultGeneralController;
use App\Http\Controllers\Result\ResultOperationController;
use App\Http\Controllers\Result\ResultSuccess\ResultAdministrativePlanController;
use App\Http\Controllers\Result\ResultSuccess\ResultGeneralPayController;
use App\Http\Controllers\Result\ResultSuccess\ResultSuccessController;
use App\Http\Controllers\Result\ResultSummariesController;
use App\Http\Controllers\Result\ResultTotalController;
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

Route::get('/', function (){
    return view('layouts.table.result');
});


//  route report
Route::resource('codes',ReportController::class);

Route::resource('keys',KeyController::class);

Route::resource('accounts',AccountKeyController::class);

Route::resource('sub-account',SubAccountKeyController::class);

Route::resource('result-mission', ResultSuccessController::class);



Route::get('/', [ResultController::class, 'index'])->name('result');
Route::get('/results', [ResultController::class, 'index'])->name('result.index');


Route::get('/result-total', [ResultTotalController::class, 'index'])->name('result-total-table');

Route::get('/result-total-general', [ResultGeneralController::class, 'index'])->name('result-total-general-table');



Route::get('/result-success', [ResultSuccessController::class, 'index'])->name('result-success');
Route::get('/result-general-pay', [ResultGeneralPayController::class, 'index'])->name('result-general-pay');
Route::get('/result-administrative-plan', [ResultAdministrativePlanController::class, 'index'])->name('result-administrative-plan');
Route::get('/result-total-operation-table', [ResultOperationController::class,'index'])->name('result-total-operation-table');
Route::get('/result-total-summaries-table', [ResultSummariesController::class,'index'])->name('result-total-summaries-table');

// In routes/web.php
Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');

