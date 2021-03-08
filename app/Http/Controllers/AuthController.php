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
use App\Models\EmailConfirmation;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller implements ShouldQueue{
    protected $jwt;

    public function __construct(JWTAuth $jwt){
        $this->jwt = $jwt;
    }

    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'required|min:8|max:64|regex:/(^([a-zA-Z0-9]+)$)/u|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8|max:64',
        ]);

        if ($validator->fails()) {
            return $this->respondWithValidationError($validator->errors()->messages(), 422);
        }

        try {
            $user = new User;
            $user->username = $request->input('username');
            $user->email = $request->input('email');
            $plainPassword = $request->input('password');
            $user->password = app('hash')->make($plainPassword);
            $user->save();

            $user->setRole('user');

            $uri = unique_random('email_confirmations', 'confirmation_uri');

            $confirmation = new EmailConfirmation();
            $confirmation->confirmation_uri = $uri;
            $user->emailConfirmation()->save($confirmation);
            
            Queue::push(new SendMailJob('REGISTRATION_CONFORMATION', [
                'email' => $user->email,
                'username' => $user->username,
                'uri' => '/api/email/confirmation/'.$uri
            ]));
            
            return $this->respond($user, 'message.user.created', 201);
        } catch (\Exception $e) {
            return $this->respondWithError('error.reg', 409);
        }
    }

    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|string|email',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return $this->respondWithValidationError($validator->errors()->messages(), 422);
        }

        $credentials = $request->only(['email', 'password']);
        
        if (!$token = Auth::attempt($credentials)) {
            return $this->respondWithError('error.login', 401);
        }
        
        if(!Auth::user()->confirmed)
            return $this->respondWithError('error.user.confirmed', 401);
        
        return $this->respondWithToken($token, 'message.user.login');
    }

    public function logout(Request $request){
        if(Auth::check()){
            Auth::logout();
            return $this->respondWithMessage('message.user.logout');
        } 
        
        return $this->respondWithError('error.unauthorized', 401);
    }
}