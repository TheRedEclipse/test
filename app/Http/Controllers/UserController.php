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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
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
     */
    public function update(UserUpdateRequest $request, $id)
    {
        return response()->json([
            'success' => true,
            'user_id' => $this->userService->update($request, $id)
        ]);
    }
}
