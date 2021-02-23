<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\EmailConfirmation;
use App\Models\User;

class EmailConfirmationController extends Controller {
    static public function create($user_id, $confirmation_uri){
        EmailConfirmation::create([
            'user_id' => $user_id,
            'confirmation_uri' => $confirmation_uri
        ]);
    }

    public function confirm(Request $request){
        $user = EmailConfirmation::where('confirmation_uri', '=', $request->c_uri)->get();
        if(sizeof($user)){
            User::where('id', '=', $user[0]->user_id)->update(['confirmed' => true]);   
            return response()->json(['message' => 'Account confirmed'], 200); 
        }

        return response()->json(['message' => 'Invalid confirmation URI'], 404);
    }
}
