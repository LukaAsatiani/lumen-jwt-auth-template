<?php

namespace App\Jobs;

use App\Http\Controllers\MailController;

class SendMailJob extends Job{
    private $template, $data;

    public function __construct($template, $data){
        $this->template = $template;
        $this->data = $data;  
    }

    public function handle(){
        $mailer = new MailController();
        $mailer->sendEmail($this->template, $this->data);
    }

    public function failed(){

    }
}
