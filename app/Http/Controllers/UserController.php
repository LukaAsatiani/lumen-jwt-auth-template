<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Mail\RegistrationConfirmation;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Http\Controllers\MailController;

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
        MailController::sendEmail('REGISTRATION_CONFORMATION', ['email'=>'limitpoint73@gmail.com', 'name'=>'drinkoron']);
    }
}