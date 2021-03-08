<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PasswordRecovery;
use App\Models\User;
use App\Jobs\SendMailJob;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;

class PasswordRecoveryController extends Controller{
    public function confirm(Request $request){
        $recovery = PasswordRecovery::where('recovery_uri', '=', $request->r_uri)->first();
        
        // if($recovery){
        //     $confirmation->user()->update([
        //         'confirmed' => true
        //     ]);

        //     $confirmation->delete();

        //     return $this->respondWithMessage('message.confirmation'); 
        // }

        // return $this->respondWithError('error.confirmation.url', 404);
    }

    public function send(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return $this->respondWithValidationError($validator->errors()->messages(), 422);
        }

        $email = $request->email;
        $user = User::where('email', $email)->first();
        
        if(!$user){
            return $this->respondWithError('error.email.find', 404);
        }

        $uri = unique_random('password_recoveries', 'recovery_uri');;
        if($user->passwordRecovery){
            $user->passwordRecovery->update(['recovery_uri' => $uri]);
        } else {    
            $confirmation = new PasswordRecovery();
            $confirmation->confirmation_uri = $uri;
            $user->emailConfirmation()->save($confirmation);
        }
       
        Queue::push(new SendMailJob('PASSWORD_RECOVERY', [
            'email' => $email,
            'username' => $user->username,
            'uri' => '/api/password/recovery/'.$uri
        ]));
        
        return $this->respondWithMessage('message.recovery.sent', 200, ['email' => $email]);
    }
}
