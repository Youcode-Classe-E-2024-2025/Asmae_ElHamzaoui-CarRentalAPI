<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

/**
 * @OA\Schema(
 *     schema="Car",
 *     type="object",
 *     required={"brand", "model", "year", "price_per_day"},
 *     @OA\Property(property="id", type="integer", description="Car ID"),
 *     @OA\Property(property="brand", type="string", description="Car brand"),
 *     @OA\Property(property="model", type="string", description="Car model"),
 *     @OA\Property(property="year", type="integer", description="Year of manufacture"),
 *     @OA\Property(property="price_per_day", type="number", format="float", description="Price per day")
 * )
 */
class CarController extends Controller
{
    /**
     * @OA\Get(
     *     path="/cars",
     *     tags={"Cars"},
     *     summary="Obtenir la liste de toutes les voitures",
     *     description="Retourne une liste paginée des voitures disponibles avec des filtres pour la marque et le prix",
     *     @OA\Parameter(
     *         name="brand",
     *         in="query",
     *         description="Filtrer les voitures par marque",
     *         required=false,
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Parameter(
     *         name="price_max",
     *         in="query",
     *         description="Filtrer les voitures dont le prix par jour est inférieur ou égal à la valeur fournie",
     *         required=false,
     *         @OA\Schema(type="number", format="float")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Liste des voitures",
     *         @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Car"))
     *     )
     * )
     */
    public function index(Request $request)
    {
        $query = Car::query();
    
        if ($request->has('brand')) {
            $query->where('brand', $request->brand);
        }
        if ($request->has('price_max')) {
            $query->where('price_per_day', '<=', $request->price_max);
        }
    
        return $query->paginate(10); // 10 résultats par page
    }

    /**
     * @OA\Post(
     *     path="/cars",
     *     tags={"Cars"},
     *     summary="Créer une voiture",
     *     description="Créer une voiture avec les informations données",
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"brand", "model", "year", "price_per_day"},
     *             @OA\Property(property="brand", type="string", example="Toyota"),
     *             @OA\Property(property="model", type="string", example="Corolla"),
     *             @OA\Property(property="year", type="integer", example=2023),
     *             @OA\Property(property="price_per_day", type="number", format="float", example=50)
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Voiture créée avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=400,
     *         description="Données invalides"
     *     )
     * )
     */
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

    /**
     * @OA\Get(
     *     path="/cars/{id}",
     *     tags={"Cars"},
     *     summary="Obtenir une voiture spécifique",
     *     description="Retourne les détails d'une voiture spécifique basé sur l'ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la voiture",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voiture trouvée",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Voiture non trouvée"
     *     )
     * )
     */
    public function show($id)
    {
        return Car::findOrFail($id);
    }

    /**
     * @OA\Put(
     *     path="/cars/{id}",
     *     tags={"Cars"},
     *     summary="Mettre à jour une voiture",
     *     description="Met à jour les informations d'une voiture spécifique",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la voiture",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="brand", type="string", example="Toyota"),
     *             @OA\Property(property="model", type="string", example="Camry"),
     *             @OA\Property(property="year", type="integer", example=2024),
     *             @OA\Property(property="price_per_day", type="number", format="float", example=75)
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Voiture mise à jour avec succès",
     *         @OA\JsonContent(ref="#/components/schemas/Car")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Voiture non trouvée"
     *     )
     * )
     */
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);
        $car->update($request->all());
        return $car;
    }

    /**
     * @OA\Delete(
     *     path="/cars/{id}",
     *     tags={"Cars"},
     *     summary="Supprimer une voiture",
     *     description="Supprime une voiture spécifique basé sur son ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         description="ID de la voiture",
     *         required=true,
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=204,
     *         description="Voiture supprimée avec succès"
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Voiture non trouvée"
     *     )
     * )
     */
    public function destroy($id)
    {
        return Car::destroy($id);
    }
}
