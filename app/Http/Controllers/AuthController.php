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
     */
    public function login(AuthLoginRequest $authLoginRequest)
    {
        return $this->authService->login($authLoginRequest);
    }

    /**
     * Log the user out (Invalidate the token)
     *
     * @return \Illuminate\Http\JsonResponse
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
