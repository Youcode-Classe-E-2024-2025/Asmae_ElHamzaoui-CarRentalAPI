<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *     title="Car Rental API",
 *     version="1.0.0",
 *     description="REST API for Car Rental System",
 *     @OA\Contact(
 *         email="admin@carrental.com",
 *         name="API Support"
 *     ),
 *     @OA\License(
 *         name="MIT",
 *         url="https://opensource.org/licenses/MIT"
 *     )
 * )
 * @OA\Components(
 *     @OA\Schema(
 *         schema="Payment",
 *         type="object",
 *         required={"rental_id", "amount", "payment_method", "payment_date"},
 *         @OA\Property(property="id", type="integer", description="Payment ID"),
 *         @OA\Property(property="amount", type="number", format="float", description="Payment amount"),
 *         @OA\Property(property="payment_date", type="string", format="date-time", description="Payment date"),
 *         @OA\Property(property="rental_id", type="integer", description="Rental ID"),
 *         @OA\Property(property="status", type="string", description="Payment status")
 *     )
 * )
 * @OA\Server(
 *     url="/api",
 *     description="Car Rental API Server"
 * )
 * @OA\SecurityScheme(
 *     securityScheme="bearerAuth",
 *     type="http",
 *     scheme="bearer",
 *     bearerFormat="JWT"
 * )
 * @OA\Tag(
 *     name="Authentication",
 *     description="API Endpoints for user authentication"
 * )
 * @OA\Tag(
 *     name="Cars",
 *     description="API Endpoints for car management"
 * )
 * @OA\Tag(
 *     name="Rentals",
 *     description="API Endpoints for rental management"
 * )
 * @OA\Tag(
 *     name="Payments",
 *     description="API Endpoints for payment processing"
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
