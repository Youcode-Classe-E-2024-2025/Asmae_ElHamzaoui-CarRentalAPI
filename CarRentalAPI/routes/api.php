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



