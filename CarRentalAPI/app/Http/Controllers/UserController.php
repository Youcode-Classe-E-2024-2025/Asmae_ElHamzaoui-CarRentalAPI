<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    // Lire tous les utilisateurs
    public function index()
    {
        return User::all();
    }

    // Créer un utilisateur
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:6'
        ]);

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
    }

    // Lire un utilisateur spécifique
    public function show($id)
    {
        return User::findOrFail($id);
    }

    // Mettre à jour un utilisateur
    public function update(Request $request, $id)
    {
        $user = User::findOrFail($id);
        $user->update($request->all());
        return $user;
    }

    // Supprimer un utilisateur
    public function destroy($id)
    {
        return User::destroy($id);
    }
}
