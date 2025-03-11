<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CarController;
use App\Http\Controllers\RentalController;
use App\Http\Controllers\PaymentController;

//Routes publiques 
Route::post('register', [UserController::class, 'store']); // Inscription
Route::post('login', [UserController::class, 'login']);   // Connexion
Route::get('cars', [CarController::class, 'index']);      // Liste des voitures disponibles
// Routes protégées (nécessitent un token d'authentification)
Route::middleware('auth:sanctum')->group(function () {
    // Utilisateur
    Route::get('users/{id}', [UserController::class, 'show']);
    Route::put('users/{id}', [UserController::class, 'update']);
    Route::delete('users/{id}', [UserController::class, 'destroy']);
    Route::post('logout', [UserController::class, 'logout']); // Déconnexion

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
       

});


