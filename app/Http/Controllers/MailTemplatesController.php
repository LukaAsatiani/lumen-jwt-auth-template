<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Traits\MailTemplates;

class MailTemplatesController extends Controller{
    use MailTemplates;

    public function list(){
        return view('emails.all', ['templates' => array_keys($this->templates)]);
    }

    public function show(Request $request){
        $mailer = new MailController();
        return $mailer->showEmailTemplate($request->template, ['email'=>'limitpoint73@gmail.com', 'name'=>'drinkoron', 'url'=>'https://google.com']);      
    }
}

//return MailController::showEmailTemplate('REGISTRATION_CONFORMATION', ['email'=>'limitpoint73@gmail.com', 'name'=>'drinkoron', 'url'=>'https://google.com']);