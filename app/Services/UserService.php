<?php

namespace App\Services;

use App\Exceptions\NotAvailable;
use App\Models\User;
use App\Models\UserRole;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class UserService
{

    protected $user;

    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Display a listing of the Users.
     *
     * @return object
     */
    public function index(): object
    {
        return User::all();
    }

    /**
     * Store new User
     * 
     * @param  object $request
     *
     * @return object
     */
    public function store(object $request): object
    {
        $roleId = UserRole::whereName($request->role_name)->firstOrFail()->id;

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId
        ]);

        return $request;
    }

    /**
     * Store a newly created User by Admin.
     *
     * @param  object $request
     * @return int $userId
     */
    public function adminStore(object $request): int
    {
        $roleId = UserRole::whereName($request->role_name)->firstOrFail()->id;

        $userId = $this->user->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId
        ])->id;

        return $userId;
    }

    /**
     * Display the specified User.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return User::whereId($id)->firstOrFail();
    }

    /**
     * Update the specified User by same User.
     *
     * @param  object $request
     * @param  int  $id
     * @return mixed
     */
    public function update(object $request, int $id): mixed
    {
        if (Auth::id() === $id) {
            $this->user->whereId($id)->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            return $id;
        } else {
            throw new NotAvailable('something went wrong');
        }
    }

    /**
     * Update the specified User by Admin.
     *
     * @param  object $request
     * @param  int  $id
     * @return int $id
     */
    public function adminUpdate(object $request, int $id): int
    {
        $roleId = UserRole::whereName($request->role_name)->firstOrFail()->id;

        $this->user->whereId($id)->update([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role_id' => $roleId
        ]);

        return $id;
    }

    /**
     * Remove the specified User by Admin.
     *
     * @param  int  $id
     * @return int $id
     */
    public function adminDestroy($id): int
    {
        $this->user->whereId($id)->delete();

        return $id;
    }
}
