
<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MedicalHistoryController;

// Test API
Route::get('/test', function () {
    return response()->json([
        'success' => true,
        'message' => 'JotnoHealthcare API is working!'
    ]);
});

// Authenticated User
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

// Authentication Routes
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth:sanctum');

// Medical History Routes
Route::middleware('auth:sanctum')->group(function () {

    Route::get('/medical-histories', [
        MedicalHistoryController::class,
        'index'
    ]);

    Route::post('/medical-histories', [
        MedicalHistoryController::class,
        'store'
    ]);

    Route::put('/medical-histories/{id}', [
        MedicalHistoryController::class,
        'update'
    ]);

    Route::delete('/medical-histories/{id}', [
        MedicalHistoryController::class,
        'destroy'
    ]);

});
