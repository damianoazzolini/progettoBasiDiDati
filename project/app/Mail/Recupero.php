<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use App\Http\Requests;


class Recupero extends Mailable {
    use Queueable, SerializesModels;
    
    public function __construct($code, $pass) {
        $this->code=$code;
        $this->pass=$pass;
    }

    public function build() {
    $address = 'harambesocial@gmail.com';
    $name = 'harambe';
    $subject = 'codice di verifica';

     return $this->view('email.recupero')
        ->with([
            'code' => $this->code,
            'pass' => $this->pass
    	])
        ->from($address, $name)
        ->replyTo($address, $name)
        ->subject($subject);
    }
}
