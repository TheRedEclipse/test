<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\UserUpdateRequest;
use App\Services\UserService;

class UserController extends Controller
{
    protected $userService;

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    /**
     * Display a listing of the Users.
     *
     * @return \Illuminate\Http\Response
     *     @OA\Get(
     *     path="/api/users",
     *     @OA\Response(response="200", description="Display a listing of Users.")
     * )
     */
    public function index()
    {
        return response()->json([
            'success' => 'true',
            'users' => $this->userService->index()
        ]);
    }

    /**
     * Display the specified User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     * @OA\Get(
     *     path="/api/users/{id}",
     *     summary="Show a User.",
     *     @OA\Response(response="200", description="Display a User.")
     * )
     */
    public function show(int $id) : object
    {
        return response()->json([
            'success' => true,
            'user' => $this->userService->show($id)
        ]);
    }

    /**
     * Registration of the new user
     *
     * @param  \Illuminate\Http\UserStoreRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     *     path="/api/users",
     *     summary="Add new User.",
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
     *     @OA\Response(response="200", description="Added new User.")
     * )
     */
    public function store(UserStoreRequest $request)
    {
        $this->userService->store($request);

        return response()->json([
            'success' => true,
            'message' => 'you are successfully registered'
        ]);
    }

    /**
     * Update the specified User.
     *
     * @param  \Illuminate\Http\UserUpdateRequest  $request
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     * @OA\Put(
     *     path="/api/users/{id}",
     *     summary="Edit User details.",
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
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Edit User details.")
     * )
     */
    public function update(UserUpdateRequest $request, $id)
    {
        return response()->json([
            'success' => true,
            'user_id' => $this->userService->update($request, $id)
        ]);
    }
}
