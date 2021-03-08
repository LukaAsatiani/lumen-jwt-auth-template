<?php

namespace App\Http\Controllers;

use App\Mail\Mailer;
use Illuminate\Support\Facades\Mail;
use App\Traits\MailTemplates;

class MailController extends Controller{    
    use MailTemplates;
    
    public function getTemplate($template){
        if(array_key_exists($template, $this->templates))
            return $this->templates[$template];
        else
            return 'Email Template Not Found.';
    }

    public function sendEmail($template, $data){
        try {
            Mail::to($data['email'])->send(new Mailer($this->getTemplate($template), $data));
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 502);
        }
    }

    public function showEmailTemplate($template, $data){
        return new Mailer($this->getTemplate($template), $data);
    }
}
