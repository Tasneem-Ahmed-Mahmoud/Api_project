<?php

namespace App\Http\Controllers\Api;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use App\Http\Requests\Api\Admin\LoginRequest;
use App\Http\Requests\Api\Admin\RegisterRequest;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:admin', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request)
    {

    if (!$token = auth()->attempt($request->only(['email', 'password']))) {

            return responseErrorMessage('Unauthorized', 401);
        }

        return responseSuccessData($token);
    }

    public function register(RegisterRequest $request)
    {
        $admin = Admin::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'password'=> Hash::make($request->password)
        ]);
        return responseSuccessData($admin,'admin successfully registered',2001);
        
    }


    public function logout()
    {
        auth()->guard('admin')->logout();
        return responseSuccessData('admin successfully signed out');
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->guard('admin')->refresh());
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'admin' => auth()->guard('admin')->user()
        ]);
    }


    public function adminProfile() {
        return response()->json(auth()->guard('admin')->user());
    }
}

