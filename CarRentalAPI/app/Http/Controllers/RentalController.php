<?php

namespace App\Http\Controllers;

use App\Models\Rental;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Rental",
 *     type="object",
 *     required={"car_id", "user_id", "start_date", "end_date", "total_amount"},
 *     @OA\Property(property="id", type="integer", description="Rental ID"),
 *     @OA\Property(property="car_id", type="integer", description="Car ID"),
 *     @OA\Property(property="user_id", type="integer", description="User ID"),
 *     @OA\Property(property="start_date", type="string", format="date", description="Start date of rental"),
 *     @OA\Property(property="end_date", type="string", format="date", description="End date of rental"),
 *     @OA\Property(property="total_amount", type="number", format="float", description="Total rental amount")
 * )
 */

class RentalController extends Controller
{

    /**
     * @OA\Get(
     *     path="/rentals",
     *     tags={"Rentals"},
     *     summary="Obtenir la liste de toutes les locations",
     *     description="Retourne une liste paginée des locations avec des options de filtrage par utilisateur et voiture",
     *     @OA\Parameter(
     *         name="user_id",
     *         in="query",
     *         description="ID de l'utilisateur pour filtrer les locations",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Parameter(
     *         name="car_id",
     *         in="query",
     *         description="ID de la voiture pour filtrer les locations",
     *         required=false,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des locations",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Rental"))
     *     )
     * )
     */
    // Lire toutes les locations
    public function index(Request $request)
{
    $query = Rental::query();

    // Filtrer par utilisateur (s'il est passé dans la requête)
    if ($request->has('user_id')) {
        $query->where('user_id', $request->user_id);
    }
    // Filtrer par voiture (s'il est passé dans la requête)
    if ($request->has('car_id')) {
        $query->where('car_id', $request->car_id);
    }

    // Appliquer la pagination
    return $query->paginate(10);
}




    /**
     * @OA\Post(
     *     path="/rentals",
     *     tags={"Rentals"},
     *     summary="Créer une nouvelle location",
     *     description="Créer une location avec les informations fournies",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"user_id", "car_id", "start_date", "end_date", "total_price"},
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="car_id", type="integer", example=3),
     *             @OA\Property(property="start_date", type="string", format="date-time", example="2025-03-01T10:00:00"),
     *             @OA\Property(property="end_date", type="string", format="date-time", example="2025-03-05T10:00:00"),
     *             @OA\Property(property="total_price", type="number", format="float", example=100.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Location créée avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Rental")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     )
     * )
     */
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


    /**
     * @OA\Get(
     *     path="/rentals/{id}",
     *     tags={"Rentals"},
     *     summary="Obtenir une location spécifique",
     *     description="Retourne une location spécifique basée sur son ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la location",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location trouvée",
     *         @OA\JsonContent(ref="#/components/schemas/Rental")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location non trouvée"
     *     )
     * )
     */

    // Lire une location spécifique
    public function show($id)
    {
        return Rental::findOrFail($id);
    }


    /**
     * @OA\Put(
     *     path="/rentals/{id}",
     *     tags={"Rentals"},
     *     summary="Mettre à jour une location",
     *     description="Met à jour les informations de la location basée sur l'ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la location",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="user_id", type="integer", example=1),
     *             @OA\Property(property="car_id", type="integer", example=2),
     *             @OA\Property(property="start_date", type="string", format="date-time", example="2025-03-01T10:00:00"),
     *             @OA\Property(property="end_date", type="string", format="date-time", example="2025-03-05T10:00:00"),
     *             @OA\Property(property="total_price", type="number", format="float", example=120.50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Location mise à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Rental")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location non trouvée"
     *     )
     * )
     */

    // Mettre à jour une location
    public function update(Request $request, $id)
    {
        $rental = Rental::findOrFail($id);
        $rental->update($request->all());
        return $rental;
    }


    /**
     * @OA\Delete(
     *     path="/rentals/{id}",
     *     tags={"Rentals"},
     *     summary="Supprimer une location",
     *     description="Supprime une location basée sur son ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la location",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Location supprimée avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Location non trouvée"
     *     )
     * )
     */
    
    // Supprimer une location
    public function destroy($id)
    {
        return Rental::destroy($id);
    }
}
