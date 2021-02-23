<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Tymon\JWTAuth\Facades\JWTAuth;
use App\Jobs\SendMailJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use App\Http\Controllers\EmailConfirmationController;
use App\Http\Controllers\UserController;

class AuthController extends Controller implements ShouldQueue{
    protected $jwt;

    public function __construct(JWTAuth $jwt){
        $this->jwt = $jwt;
    }

    public function register(Request $request){
        $this->validate($request, [
            'name' => 'required|string|min:8|max:64|unique:users',
            'email' => 'required|email|min:8|max:64|unique:users',
            'password' => 'required|confirmed|min:8|max:64',
        ]);

        try {
            $user = new User;
            $user->name = $request->input('name');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            
            $user->save();

            $uri = Str::random(21);
            
            EmailConfirmationController::create($user->id, $uri);

            Queue::push(new SendMailJob('REGISTRATION_CONFORMATION', [
                'email' => $user->email,
                'name' => $user->name,
                'uri' => '/api/email/confirmation/'.$uri
            ]));
            
            return response()->json(['user' => $user, 'message' => 'CREATED'], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'User Registration Failed!'], 409);
        }
    }

    public function login(Request $request){
        $this->validate($request, [
            'email' => 'required|string',
            'password' => 'required|string',
        ]);

        $credentials = $request->only(['email', 'password']);
        
        if (!$token = Auth::attempt($credentials)) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        if(!Auth::user()->confirmed)
            return response()->json(['message' => 'Confirm your email, please.'], 401);
        
        return $this->respondWithToken($token);
    }

    public function logout(Request $request){
        if(Auth::check()){
            Auth::logout();
            return response()->json(['message'=> 'User successfully signed out'], 200);
        } 
        
        return response()->json(['message' => 'Unauthorized'], 401);
    }
}