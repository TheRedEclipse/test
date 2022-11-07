<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminUserStoreRequest;
use App\Http\Requests\AdminUserUpdateRequest;
use App\Services\UserService;
use Illuminate\Http\Request;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Store a newly created User by Admin.
     *
     * @param  \Illuminate\Http\AdminUserStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     *     path="/api/admin/users",
     *     summary="Add a new User by Admin.",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="role_name",
     *                     type="string"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Add a new User by Admin.")
     * )
     */
    public function store(AdminUserStoreRequest $request)
    {
        return response()->json([
            'success' => true,
            'user_id' => $this->userService->adminStore($request)
        ]);
    }

    /**
     * Update the specified User by Admin.
     *
     * @param  \Illuminate\Http\AdminUserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse 
     * @OA\Put(
     *     path="/api/admin/users/{id}",
     *     summary="Edit User details by Admin.",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="id",
     *                     type="integer"
     *                 ),
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="email",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="role_name",
     *                     type="string"
     *                 ),
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Edit User details by Admin.")
     * )
     */
    public function update(AdminUserUpdateRequest $request, $id)
    {
        return response()->json([
            'success' => true,
            'user_id' => $this->userService->adminUpdate($request, $id)
        ]);
    }

    /**
     * Remove the specified User by Admin.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
      * @OA\Delete(
     *     path="/api/admin/users/{id}",
     *     summary="Remove User by Admin.",
     *     @OA\Response(response="200", description="Remove User by Admin.")
     * )
     */
    public function destroy($id)
    {
        return response()->json([
            'success' => true,
            'user_id' => $this->userService->adminDestroy($id)
        ]);
    }
}
