<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * @OA\Post(
     * path="/register",
     * operationId="registerUser",
     * tags={"Authentification"},
     * summary="Enregistre un nouvel utilisateur",
     * description="Crée un nouvel utilisateur et retourne un token d'accès.",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"name","email","password","password_confirmation"},
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="password123"),
     * @OA\Property(property="password_confirmation", type="string", format="password", example="password123")
     * )
     * ),
     * @OA\Response(
     * response=201,
     * description="Inscription réussie",
     * @OA\JsonContent(
     * @OA\Property(property="access_token", type="string", example="your_access_token"),
     * @OA\Property(property="token_type", type="string", example="Bearer"),
     * @OA\Property(property="user", type="object",
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", example="john.doe@example.com")
     * )
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Erreurs de validation",
     * @OA\JsonContent(
     * @OA\Property(property="errors", type="object", example={"email": {"The email has already been taken."}})
     * )
     * )
     * )
     */
    public function register(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users',
                'password' => 'required|string|min:8|confirmed',
            ]);

            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ], 201);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 422);
        }
    }

    /**
     * @OA\Post(
     * path="/login",
     * operationId="loginUser",
     * tags={"Authentification"},
     * summary="Connecte un utilisateur existant",
     * description="Authentifie un utilisateur et retourne un token d'accès.",
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(
     * required={"email","password"},
     * @OA\Property(property="email", type="string", format="email", example="john.doe@example.com"),
     * @OA\Property(property="password", type="string", format="password", example="password123")
     * )
     * ),
     * @OA\Response(
     * response=200,
     * description="Connexion réussie",
     * @OA\JsonContent(
     * @OA\Property(property="access_token", type="string", example="your_access_token"),
     * @OA\Property(property="token_type", type="string", example="Bearer"),
     * @OA\Property(property="user", type="object",
     * @OA\Property(property="id", type="integer", example=1),
     * @OA\Property(property="name", type="string", example="John Doe"),
     * @OA\Property(property="email", type="string", example="john.doe@example.com")
     * )
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Identifiants invalides",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Identifiants invalides")
     * )
     * ),
     * @OA\Response(
     * response=422,
     * description="Erreurs de validation",
     * @OA\JsonContent(
     * @OA\Property(property="errors", type="object", example={"email": {"The email field is required."}})
     * )
     * )
     * )
     */
    public function login(Request $request)
    {
        try {
            $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string',
            ]);

            if (!Auth::attempt($request->only('email', 'password'))) {
                return response()->json(['message' => 'Identifiants invalides'], 401);
            }

            $user = User::where('email', $request->email)->firstOrFail();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        } catch (ValidationException $exception) {
            return response()->json(['errors' => $exception->errors()], 422);
        }
    }

    /**
     * @OA\Post(
     * path="/logout",
     * operationId="logoutUser",
     * tags={"Authentification"},
     * summary="Déconnecte l'utilisateur actuel",
     * description="Révoque le token d'accès de l'utilisateur authentifié.",
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Déconnexion réussie",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Déconnexion réussie")
     * )
     * ),
     * @OA\Response(
     * response=401,
     * description="Non authentifié",
     * @OA\JsonContent(
     * @OA\Property(property="message", type="string", example="Unauthenticated.")
     * )
     * )
     * )
     */
    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Déconnexion réussie']);
    }
}
