<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserValidate;
use Illuminate\Support\Facades\Auth;

class RegisterController extends BaseController
{
    public function register(UserValidate $request) {
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        if ($user) {
            return $this->sendResponse(['name' => $request->first_name . ' '. $request->last_name, 'email' => $request->email], trans('auth.userRegister'), 200);
        } else {
            return $this->sendError(trans('auth.userRegisterFailed'), 400);
        }
    }
}
