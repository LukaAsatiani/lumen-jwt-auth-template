<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Mail\RegistrationConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Http\Controllers\MailController;
use App\Models\User;
use App\Jobs\SendMailJob;
use Illuminate\Support\Facades\Queue;

class UserController extends Controller{
    public function __construct(){
        $this->middleware('auth', ['except' =>
            [
                'sendMail'
            ]
        ]);
    }

    public function profile(){
        return response()->json(['user' => Auth::user()], 200);
    }

    public function allUsers(){
        return response()->json(['users' =>  User::all()], 200);
    }

    public function singleUser($id){
        try {
            $user = User::findOrFail($id);
            return response()->json(['user' => $user], 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'user not found!'], 404);
        }
    }

    public function sendMail(){
        Queue::push(new SendMailJob($template = 'REGISTRATION_CONFORMATION', [
            'email' => 'capslk43@gmail.com',
            'name' => 'Name',
            'uri' => '43r34t45dfg'
        ]));
        return response()->json("Error", 404);
    }
}