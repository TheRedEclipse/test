<?php

namespace App\Services;

use App\Exceptions\NotAvailable;
use App\Models\Car;
use Illuminate\Support\Facades\Auth;
use PhpParser\Node\Expr\Throw_;

class CarService
{

    protected $car;

    public function __construct(Car $car)
    {
        $this->car = $car;
    }

    /**
     * Display a listing of the cars.
     *
     * @return object
     */
    public function index() : object
    {
        return $this->car->all();
    }

    /**
     * Display the specified Car.
     *
     * @param  int  $id
     * @return object
     */
    public function show(int $id) : object
    {
        return $this->car->whereId($id)->firstOrFail();
    }

    /**
     * Store a newly created car by Admin.
     *
     * @param  object $request
     * @return int $carId
     */
    public function adminStore(object $request) : int
    {
        $carId = $this->car->create([
            'name' => $request->name,
            'title' => $request->title
        ])->id;

        return $carId;
    }

    /**
     * Update the specified car by User.
     *
     * @param  object $request
     * @param  int  $id
     * @return mixed
     */
    public function update($request, $id)
    {
        $userId = Auth::user()->id;

        if ($request->remove) {
            $carUserId = $this->car->whereId($id)->firstOrFail()->user_id;

            if ($carUserId === $userId) {
                $this->car->whereId($id)->update([
                    'user_id' => null
                ]);

                return $id;
            } else {
                throw new NotAvailable("something went wrong");
            }
        } else {
            $userHasCar = $this->car->whereUserId($userId)->first();

            if ($userHasCar->id != $id) {
                throw new NotAvailable("you have the other car in use");
            }

            $available = $this->car->whereId($id)->firstOrFail()->isNotTaken();

            if ($available) {
                $this->car->whereId($id)->update([
                    'user_id' => $userId
                ]);

                return $id;
            } else {
                throw new NotAvailable("car is already been taken");
            }
        }
    }

    /**
     * Update the specified car by Admin.
     *
     * @param  object $request
     * @param  int  $id
     * @return int $id
     */
    public function adminUpdate(object $request, int $id) : int
    {
        $this->car->whereId($id)->update([
            'name' => $request->name,
            'title' => $request->title
        ]);

        return $id;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return int $id
     */
    public function adminDestroy($id) : int
    {
        $this->car->whereId($id)->delete();

        return $id;
    }
}
