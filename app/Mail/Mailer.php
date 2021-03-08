<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Mailer extends Mailable {
    use Queueable, SerializesModels;

    public function __construct($template_data, $data){
        $this->template_data = $template_data;
        $this->data = $data;
    }

    public function build(){
        // dd($this->template_data);
        return $this->
            from(env('MAIL_USERNAME', 'chessoutapp@gmail.com'), env('APP_NAME', 'ChessoutApp'))->
            subject($this->template_data['subject'])->
            markdown($this->template_data['markdown'])->
            with($this->data);
    }
}
