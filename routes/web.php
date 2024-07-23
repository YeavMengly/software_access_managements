<?php

use App\Http\Controllers\Code\AccountKeyController;
use App\Http\Controllers\Code\CodeController;
use App\Http\Controllers\Code\SubAccountKeyController;
use App\Http\Controllers\Report\ReportController;
use App\Http\Controllers\Result\ResultController;
use App\Http\Controllers\Result\ResultGeneralController;
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

Route::resource('keys',CodeController::class);

Route::resource('accounts',AccountKeyController::class);

Route::resource('sub-account',SubAccountKeyController::class);


Route::get('/', [ResultController::class, 'index'])->name('result');

Route::get('/result-total', [ResultTotalController::class, 'index'])->name('result-total-table');

Route::get('/result-total-general', [ResultGeneralController::class, 'index'])->name('result-total-general-table');