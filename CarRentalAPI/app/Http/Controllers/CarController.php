<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    // Lire toutes les voitures
    public function index()
    {
        return Car::all();
    }

    // Créer une voiture
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string',
            'model' => 'required|string',
            'year' => 'required|integer',
            'price_per_day' => 'required|numeric'
        ]);

        return Car::create($request->all());
    }

    // Lire une voiture spécifique
    public function show($id)
    {
        return Car::findOrFail($id);
    }

    // Mettre à jour une voiture
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        $car->update($request->all());
        return $car;
    }

    // Supprimer une voiture
    public function destroy($id)
    {
        return Car::destroy($id);
    }
}
