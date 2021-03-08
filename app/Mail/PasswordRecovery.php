<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PasswordRecovery extends Mailable {
    use Queueable, SerializesModels;

    public function __construct($data){
        $this->data = $data;
        $this->subject = 'Please Confirm Your E-mail Address!';
    }

    public function build(){
        return $this->
        from(env('MAIL_USERNAME', 'chessoutapp@gmail.com'), env('APP_NAME', 'ChessoutApp'))->
        subject($this->subject)->
        markdown('emails.registration.confirmation')->
        with($this->data);
    }
}
