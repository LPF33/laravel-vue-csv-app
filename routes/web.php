<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('app');
});

Route::prefix('csv')->group(function () {
    Route::get('/read', [Controller::class, 'readCSV']);

    Route::get('/export', [Controller::class, 'exportCSV']);

    Route::post('/add', [Controller::class, 'appendCSV']);

    Route::post('/write', [Controller::class, 'writeCSV']);

    Route::post('/upload', [Controller::class, 'importCSV']);
});
