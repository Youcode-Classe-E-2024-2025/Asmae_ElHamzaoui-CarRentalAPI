<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    // Lire tous les paiements
    public function index()
    {
        return Payment::all();
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

