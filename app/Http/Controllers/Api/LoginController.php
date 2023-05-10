<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Api\BaseController;
use Illuminate\Support\Facades\Validator;
use App\Http\Requests\LoginValidate;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;

class LoginController extends BaseController
{
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(LoginValidate $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->first_name . ' ' . $user->last_name;
            
            return $this->sendResponse([$success], trans('auth.userLogin'));
        } else {
            return $this->sendError(trans('auth.userIncorrectCredential'), 400);
        } 
    }
}
