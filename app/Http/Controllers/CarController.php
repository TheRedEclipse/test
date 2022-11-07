<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarUpdateRequest;
use App\Models\Car;
use App\Services\CarService;
use Illuminate\Http\Request;

class CarController extends Controller
{
    protected $carService;

    public function __construct(CarService $carService)
    {
        $this->carService = $carService;
    }

    /**
     * Display a listing of the Cars.
     *
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     *     path="/api/cars",
     *     @OA\Response(response="200", description="Display a listing of Cars.")
     * )
     */
    public function index()
    {
        return response()->json([
            'success' => true,
            'cars' => $this->carService->index()
        ]);
    }

    /**
     * Display the specified Car.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @OA\Get(
     *     path="/api/cars/{id}",
     *     summary="Show a Car.",
     *     @OA\Response(response="200", description="Display a Car.")
     * )
     */
    public function show($id)
    {
        return response()->json([
            'success' => true,
            'car' => $this->carService->show($id)
        ]);
    }

    /**
     * Update the specified Car.
     *
     * @param  \Illuminate\Http\CarUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @OA\Put(
     *     path="/api/cars/{id}",
     *     summary="Edit Car by User.",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="remove",
     *                     type="boolean"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Display a listing of Cars.")
     * )
     */
    public function update(CarUpdateRequest $request, $id)
    {
        return response()->json([
            'success' => true,
            'car_id' => $this->carService->update($request, $id)
        ]);
    }
}
