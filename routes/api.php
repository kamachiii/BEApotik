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
Route::prefix('apotek')->group(function () {
    Route::get('/',[ApotekController::class, 'index']);
    Route::post('/create',[ApotekController::class, 'store']);
    Route::get('/show/{id}',[ApotekController::class, 'show']);
    Route::post('/update/{id}',[ApotekController::class, 'update']);
    Route::post('/delete/{id}',[ApotekController::class, 'destroy']);

    Route::prefix('trash')->group(function () {
        Route::get('/all', [ApotekController::class, 'getTrash']);
        Route::post('/restore/{id}', [ApotekController::class, 'restore']);
        Route::post('/permanent/{id}', [ApotekController::class, 'deleteTrash']);

    });
});


