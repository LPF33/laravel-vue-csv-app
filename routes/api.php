<?php

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('/read', [Controller::class, 'readCSV']);

Route::get('/export', [Controller::class, 'exportCSV']);

Route::post('/add', [Controller::class, 'appendCSV']);

Route::post('/write', [Controller::class, 'writeCSV']);

Route::post('/upload', [Controller::class, 'importCSV']);
