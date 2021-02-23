<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Mail\RegistrationConfirmation;
use Illuminate\Support\Facades\Mail;

abstract class MailController extends Controller{
    static public function getTemplate($template, $user){
        $templates = [
            'REGISTRATION_CONFORMATION' => new RegistrationConfirmation($user)
        ];

        if(array_key_exists($template, $templates))
            return $templates[$template];
        else
            return 'Email Template Not Found.';
    }

    static public function sendEmail($template, $data){
        try {
            Mail::to($data['email'])->send(MailController::getTemplate($template, $data));
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 502);
        }
    }

    static public function showEmailTemplate($template, $data){
        return MailController::getTemplate($template, $data);
    }
}
