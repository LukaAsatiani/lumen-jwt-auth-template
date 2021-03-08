<?php 

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\UserHasRole;
use App\Models\Role;
use Illuminate\Support\Facades\Validator;
use App\Jobs\SendMailJob;
use Illuminate\Support\Facades\Queue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;

class UserController extends Controller{
    public function profile(){
        return $this->respond(Auth::user());
    }

    public function allUsers(){
        $users = User::all();
        if(sizeof($users))
            return $this->respond(User::all());
    }

    public function singleUser($id){
        try {
            $user = User::findOrFail($id);
            return $this->respond($user);
        } catch (\Exception $e) {
            return $this->respondWithError('error.user.find', 404);
        }
    }

    public function changeProfileData(Request $request){
        $validator = Validator::make($request->all(), [
            'username' => 'min:8|max:64|regex:/(^([a-zA-Z0-9]+)$)/u|unique:users',
            'email' => 'email|unique:users',
            'password' => 'confirmed|min:8|max:64',
        ]);

        if ($validator->fails()) {
            return $this->respondWithValidationError($validator->errors()->messages(), 422);
        }

        $credentials = $request->only(['password', 'username', 'email']);
        
        $user = User::find(Auth::user()->id);

        if($user){
            foreach($credentials as $key => $value){
                if($value === '')
                    continue;

                if($key === 'password')
                    $value = app('hash')->make($value);
                
                $user[$key] = $value;
            }
            $user->save();
            
            return $this->respondWithMessage('message.user.updated');
        } else {
            return $this->respondWithError('error.user.update', 404);
        }
    }

    public function sendMail(){
        Queue::push(new SendMailJob('REGISTRATION_CONFORMATION', [
            'email' => 'capslk43@gmail.com',
            'username' => 'Username',
            'uri' => '43r34t45dfg'
        ]));
    }
}
