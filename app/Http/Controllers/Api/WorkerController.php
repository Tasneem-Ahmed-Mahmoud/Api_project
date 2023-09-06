<?php

namespace App\Http\Controllers\Api;

use App\Models\Worker;
use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Validator;
use App\Http\Requests\Api\PhotoRequest;
use App\Http\Requests\Api\Worker\LoginRequest;
use App\Http\Requests\Api\Worker\RegisterRequest;

class WorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:worker', ['except' => ['login', 'register']]);
    }

    public function login(LoginRequest $request)
    {

    if (!$token = auth()->guard('worker')->attempt($request->only(['email', 'password']))) {

            return responseErrorMessage('Unauthorized', 401);
        }

        return responseSuccessData([
            'token'=>$token
        ]);
    }

    public function register(RegisterRequest $request)
    {
        
        $worker = Worker::create([
            'name'=>$request->name,
            'email'=>$request->email,
            'location'=>$request->location,
            'phone'=>$request->phone,
            'password'=> Hash::make($request->password),
            'photo'=>$request->file('photo')->store(Worker::PATH)
        ]);
        return responseSuccessData($worker,'worker successfully registered',2001);
        
    }


    public function logout()
    {
        auth()->guard('worker')->logout();
        return responseSuccessMessage('worker successfully signed out');
    }

    public function refresh()
    {
        return $this->createNewToken(auth()->guard('worker')->refresh());
    }

    protected function createNewToken($token)
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60,
            'worker' => auth()->guard('worker')->user()
        ]);
    }


    public function workerProfile() {
        return response()->json(auth()->guard('worker')->user());
    }


    public function uploadPhoto(Worker $worker,PhotoRequest $request)
    {
        $old_photo=$worker->photo;
        
        $photo= $request->file('photo')->store(Worker::PATH);
        // dd($photo);
        $worker->update([
            'photo'=>$photo
        ]);
        // if($worker){
        //     deleteImage(Worker::PATH.'/'.$old_photo);
        // }
        return responseSuccessMessage('image uploaded successfully');
    }
}

