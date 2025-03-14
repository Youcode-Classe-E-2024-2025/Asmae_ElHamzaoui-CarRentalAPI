<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\AuthController;

//Routes publiques 
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('cars', [CarController::class, 'index']);// Liste des voitures disponibles


// Routes protégées (nécessitent un token d'authentification)
Route::middleware('auth:sanctum')->group(function () {
// Utilisateur
Route::middleware('auth:sanctum')->group(function () {
Route::post('/logout', [AuthController::class, 'logout']);
Route::get('/me', [AuthController::class, 'me']);
});
// Voitures
Route::post('cars', [CarController::class, 'store']);
Route::get('cars/{id}', [CarController::class, 'show']);
Route::put('cars/{id}', [CarController::class, 'update']);
Route::delete('cars/{id}', [CarController::class, 'destroy']);

// Locations
Route::post('rentals', [RentalController::class, 'store']);
Route::get('rentals', [RentalController::class, 'index']);
Route::get('rentals/{id}', [RentalController::class, 'show']);
Route::put('rentals/{id}', [RentalController::class, 'update']);
Route::delete('rentals/{id}', [RentalController::class, 'destroy']);

// Paiements
Route::post('payments', [PaymentController::class, 'store']);
Route::get('payments', [PaymentController::class, 'index']);
Route::get('payments/{id}', [PaymentController::class, 'show']);
Route::put('payments/{id}', [PaymentController::class, 'update']);
Route::delete('payments/{id}', [PaymentController::class, 'destroy']); 
   
Route::post('/payments/create-intent', [PaymentController::class, 'createPaymentIntent']);
Route::post('/payments/confirm', [PaymentController::class, 'confirmPayment']);
});


