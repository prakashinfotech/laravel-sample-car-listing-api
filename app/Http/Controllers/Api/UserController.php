<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Http\Requests\UserValidate;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource;

class UserController extends BaseController
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd(session()->get('locale'));
        $userWithCarsDetail = User::with('cars')->paginate(10);
        if ($userWithCarsDetail) {
            return $this->sendResponse([UserResource::collection($userWithCarsDetail)], trans('message.userWithCarDetails'), 200);
        } else {
            return $this->sendError(trans('message.userWithCarDetailsFailed'), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UserValidate $request, User $user)
    {
        $userUpdate = $user->update([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
        ]);

        if ($userUpdate) {
            return $this->sendResponse([new UserResource($request)], trans('message.userUpdate'), 201);
        } else {
            return $this->sendError(trans('message.userUpdateFailed'), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user->delete()) {
            return $this->sendResponse([$user], trans('message.userDelete'), 200);
        } else {
            return $this->sendError(trans('message.userDeleteFailed'), 400);
        }
    }
}
