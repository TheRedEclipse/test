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
     */
    public function destroy($id)
    {
        return response()->json([
            'success' => true,
            'user_id' => $this->userService->adminDestroy($id)
        ]);
    }
}
