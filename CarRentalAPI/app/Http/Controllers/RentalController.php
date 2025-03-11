<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;

class RentalController extends Controller
{
    // Lire toutes les locations
    public function index()
    {
        return Rental::all();
    }

    // Créer une location
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'car_id' => 'required|exists:cars,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'total_price' => 'required|numeric'
        ]);

        return Rental::create($request->all());
    }

    // Lire une location spécifique
    public function show($id)
    {
        return Rental::findOrFail($id);
    }

    // Mettre à jour une location
    public function update(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);
        $rental->update($request->all());
        return $rental;
    }

    // Supprimer une location
    public function destroy($id)
    {
        return Rental::destroy($id);
    }
}
