<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailConfirmation;
use App\Models\User;
use App\Jobs\SendMailJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Validator;

class EmailConfirmationController extends Controller {
    public function confirm(Request $request){
        $confirmation = EmailConfirmation::where('confirmation_uri', '=', $request->c_uri)->first();
        
        if($confirmation && $confirmation->user->confirmed == false){
            $confirmation->user()->update([
                'confirmed' => true
            ]);

            $confirmation->delete();

            return $this->respondWithMessage('message.confirmation'); 
        }

        return $this->respondWithError('error.confirmation.url', 404);
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

        if($user->confirmed == true){
            return $this->respondWithError('error.email.confirmed', 404);
        }

        $uri = unique_random('email_confirmations', 'confirmation_uri');;
        if($user->emailConfirmation){
            $user->emailConfirmation->update(['confirmation_uri' => $uri]);
        } else {    
            $confirmation = new EmailConfirmation();
            $confirmation->confirmation_uri = $uri;
            $user->emailConfirmation()->save($confirmation);
        }

        Queue::push(new SendMailJob('REGISTRATION_CONFORMATION', [
            'email' => $email,
            'username' => $user->username,
            'uri' => '/api/email/confirmation/'.$uri
        ]));
        
        return $this->respondWithMessage('message.confirmation.sent', 200, ['email' => $email]);
    }
}
