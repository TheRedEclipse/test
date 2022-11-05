<?php

namespace App\Services;

use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthService {

    /**
     * Login User with token response
     * 
     * @param  object $request
     *
     * @return object
     */
    public function login(object $request) : object
    {
        $user = User::whereName($request->name)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'messages' => [
                    'combination doesn\'t exist'
                ]
            ], 403);
        }

        $token = auth('api')->attempt(
            $request->only([
                'name',
                'password'
            ])
        );

        if (!$token) {
            return response()->json([
                'success' => false,
                'messages' => [
                    __('auth.login_failed')
                ]
            ], 401);
        }

        return $this->respondWithToken($token, $request->remember_me);
    }

    /**
     * Get the token array structure.
     *
     * @param  string $token
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function respondWithToken($token, $remember = false)
    {
        $user = auth('api')->user();

        $current_user = User::findOrFail($user['id']);

        $roles = $current_user->roles ? $current_user->roles->sortBy('sort')->keyBy('name')->map(function ($value, $key) {
            return $value->only(['title', 'style', 'name', 'sort']);
        }) : [];

        $current_user->update([
            'last_join_ip' => request()->ip()
        ]);
 
        $time = $remember ? 24*30 : 60;
        
        return response()->json([
            'success' => true,
                'access_token' => $token,
                'token_type' => 'bearer',
                'user' => collect($user)
                            ->put('roles', $roles),
                'expires_in' => auth('api')->factory()->getTTL() * (int) $time
        ], 200);
    }
}