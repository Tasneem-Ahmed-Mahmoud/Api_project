<?php

namespace App\Http\Controllers\Api;

use App\Models\Client;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\PhotoRequest;
use App\Http\Requests\Api\Client\LoginRequest;
use App\Http\Requests\Api\Client\RegisterRequest;

class ClientController extends Controller
{
    
   
    
        public function __construct()
        {
            $this->middleware('auth:client', ['except' => ['login', 'register']]);
        }
    
        public function login(LoginRequest $request)
        {
    
        if (!$token = auth()->guard('client')->attempt($request->only(['email', 'password']))) {
    
                return responseErrorMessage('Unauthorized', 401);
            }
    
            return responseSuccessData([
                'token'=>$token
            ]);
        }
    
        public function register(RegisterRequest $request)
        {
            
            $client = Client::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=> Hash::make($request->password),
                'photo'=>$request->file('photo')->store(Client::PATH)
            ]);
            return responseSuccessData($client,'client successfully registered',2001);
            
        }
    
    
        public function logout()
        {
            auth()->guard('client')->logout();
            return responseSuccessMessage('client successfully signed out');
        }
    
        public function refresh()
        {
            return $this->createNewToken(auth()->guard('client')->refresh());
        }
    
        protected function createNewToken($token)
        {
            return response()->json([
                'access_token' => $token,
                'token_type' => 'bearer',
                'expires_in' => auth()->factory()->getTTL() * 60,
                'client' => auth()->guard('client')->user()
            ]);
        }
    
    
        public function clientProfile() {
            return response()->json(auth()->guard('client')->user());
        }
    
    
        public function uploadPhoto(Client $client,PhotoRequest $request)
        {
            $old_photo=$client->photo;
            
            $photo= $request->file('photo')->store(Client::PATH);
            // dd($photo);
            $client->update([
                'photo'=>$photo
            ]);
            // if($client){
            //     deleteImage(client::PATH.'/'.$old_photo);
            // }
            return responseSuccessMessage('image uploaded successfully');
        }
    }
    
    