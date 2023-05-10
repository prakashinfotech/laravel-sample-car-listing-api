<?php

namespace App\Http\Controllers\Api;

use App\Models\Car;
use Illuminate\Http\Request;
use App\Http\Requests\CarValidate;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\CarResource;

class CarController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carsWithUserDetail = Car::with('user')->paginate(10);
        if ($carsWithUserDetail) {
            return $this->sendResponse([CarResource::collection($carsWithUserDetail)], trans('message.carWithUserDetails'), 200);
        } else {
            return $this->sendError(trans('message.carWithUserDetailsError'), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CarValidate $request)
    {
        $car = Car::create([
            'user_id' => Auth::user()->id,
            'brand' => $request->brand,
            'model' => $request->model,
        ]);
        if ($car) {
            return $this->sendResponse(['brand' => $request->brand, 'model' => $request->model], trans('message.carCreate'), 200);
        } else {
            return $this->sendError(trans('message.carCreateError'), 400);
        }
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CarValidate $request, Car $car)
    {
        $carUpdate = $car->update([
            'user_id' => Auth::user()->id,
            'brand' => $request->brand,
            'model' => $request->model,
        ]);

        if ($carUpdate) {
            return $this->sendResponse(['brand' => $request->brand, 'model' => $request->model], trans('message.carUpdate'), 201);
        } else {
            return $this->sendError(trans('message.carUpdateFailed'), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Car $car)
    {
        if ($car->delete()) {
            return $this->sendResponse([$car], trans('message.carDelete'), 200);
        } else {
            return $this->sendError(trans('message.carDeleteFailed'), 400);
        }
    }
}
