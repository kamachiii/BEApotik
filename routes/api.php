<?php

use App\Http\Controllers\ApotekController;
use Illuminate\Http\Request;
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

Route::get('/apotek',[ApotekController::class, 'index']);
Route::post('/apotek/create',[ApotekController::class, 'store']);
Route::get('/apotek/create/show/{id}',[ApotekController::class, 'show']);
Route::post('/apotek/update/{id}',[ApotekController::class, 'update']);
Route::post('delete/apotek/{id}',[ApotekController::class, 'destroy']);
