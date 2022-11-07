<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminCarStoreRequest;
use App\Http\Requests\AdminCarUpdateRequest;
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
     * Store a newly created Car by Admin.
     *
     * @param  \Illuminate\Http\AdminCarStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     *     path="/api/admin/cars/",
     *     summary="Add new Car by Admin.",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Add new Car by Admin.")
     * )
     */
    public function store(AdminCarStoreRequest $request)
    {
        return response()->json([
            'success' => true,
            'car_id' => $this->carService->adminStore($request)
        ]);
    }

    /**
     * Update the specified Car by Admin.
     *
     * @param  \Illuminate\Http\AdminCarUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @OA\Put(
     *     path="/api/admin/cars/{id}",
     *     summary="Edit Car by Admin.",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer",

     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="title",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Edit Car by Admin.")
     * )
     */
    public function update(AdminCarUpdateRequest $request, $id)
    {
        return response()->json([
            'success' => true,
            'car_id' => $this->carService->adminUpdate($request, $id)
        ]);
    }

    /**
     * Remove the specified Car by Admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @OA\Delete(
     *     path="/api/admin/cars/{id}",
     *     summary="Remove Car by Admin.",
     *     @OA\Response(response="200", description="Remove Car by Admin.")
     * )
     */
    public function destroy($id)
    {
        return response()->json([
            'success' => true,
            'car_id' => $this->carService->adminDestroy($id)
        ]);
    }
}
