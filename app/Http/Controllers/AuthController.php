<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthLoginRequest;
use App\Http\Requests\AuthRegistrationRequest;
use App\Services\AuthService;

class AuthController extends Controller
{
    protected $authService;

    public function __construct(AuthService $authService)
    {
        $this->authService = $authService;
        $this->middleware('auth:api', ['except' => ['login']]);
    }

    /**
     * Login the User
     *
     * @param  \Illuminate\Http\AuthLoginRequest  $request
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     *     path="/api/user/login",
     *     summary="Login User.",
     *     @OA\RequestBody(
     *         @OA\MediaType(
     *             mediaType="application/json",
     *             @OA\Schema(
     *                 @OA\Property(
     *                     property="name",
     *                     type="string"
     *                 ),
     *                 @OA\Property(
     *                     property="password",
     *                     type="string"
     *                 )
     *             )
     *         )
     *     ),
     *     @OA\Response(response="200", description="Login User with token response.")
     * )
     */
    public function login(AuthLoginRequest $authLoginRequest)
    {
        return $this->authService->login($authLoginRequest);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
     * @OA\Post(
     *     path="/api/user/logout",
     *     summary="Logout User.",
     *     @OA\Response(response="200", description="Logout User.")
     * )
     */
    public function logout()
    {
        auth('api')->logout();

        return response()->json([
            'success' => true,
            'messages' => ['logged out'],
        ]);
    }

}
