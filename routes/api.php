<?php

use App\Http\Controllers\ApotekController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\SampahController;
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

//* Rest API routes for Apotek
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

//* Rest API routes for Rental
Route::prefix('rental')->group(function () {
    Route::get('/',[RentalController::class, 'index']);
    Route::post('/create',[RentalController::class, 'store']);
    Route::get('/show/{id}',[RentalController::class, 'show']);
    Route::post('/update/{id}',[RentalController::class, 'update']);
    Route::post('/delete/{id}',[RentalController::class, 'destroy']);

    Route::prefix('trash')->group(function () {
        Route::get('/all', [RentalController::class, 'getTrash']);
        Route::post('/restore/{id}', [RentalController::class, 'restore']);
        Route::post('/permanent/{id}', [RentalController::class, 'deleteTrash']);

    });
});

//* Rest API routes for Sampah
Route::prefix('sampah')->group(function () {
    Route::get('/',[SampahController::class, 'index']);
    Route::post('/create',[SampahController::class, 'store']);
    Route::get('/show/{id}',[SampahController::class, 'show']);
    Route::post('/update/{id}',[SampahController::class, 'update']);
    Route::post('/delete/{id}',[SampahController::class, 'destroy']);

    Route::prefix('trash')->group(function () {
        Route::get('/all', [SampahController::class, 'getTrash']);
        Route::post('/restore/{id}', [SampahController::class, 'restore']);
        Route::post('/permanent/{id}', [SampahController::class, 'deleteTrash']);

    });
});

