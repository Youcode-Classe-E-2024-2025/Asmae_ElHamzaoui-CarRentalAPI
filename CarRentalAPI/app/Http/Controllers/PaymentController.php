<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Lire tous les paiements
    public function index(Request $request)
{
    $query = Payment::query();

    // Filtrer par utilisateur ou location, si nécessaire
    if ($request->has('user_id')) {
        $query->where('user_id', $request->user_id);
    }
    if ($request->has('rental_id')) {
        $query->where('rental_id', $request->rental_id);
    }

    // Appliquer la pagination
    return $query->paginate(10);
}


    // Créer un paiement
    public function store(Request $request)
    {
        $request->validate([
            'rental_id' => 'required|exists:rentals,id',
            'amount' => 'required|numeric',
            'payment_method' => 'required|string',
            'payment_date' => 'required|date'
        ]);

        return Payment::create($request->all());
    }

    // Lire un paiement spécifique
    public function show($id)
    {
        return Payment::findOrFail($id);
    }

    // Mettre à jour un paiement
    public function update(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);
        $payment->update($request->all());
        return $payment;
    }

    // Supprimer un paiement
    public function destroy($id)
    {
        return Payment::destroy($id);
    }
}

