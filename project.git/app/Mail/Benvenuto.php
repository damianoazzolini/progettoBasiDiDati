<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Benvenuto extends Mailable {
    use Queueable, SerializesModels;
    
    public function __construct($code) {
        $this->code=$code;
        return $this->code; 
    }

    public function build() {
    $address = 'harambesocial@gmail.com';
    $name = 'harambe';
    $subject = 'codice di verifica';

    return $this->view('email.welcome')
        ->with('code', $this->code)
        ->from($address, $name)
        ->replyTo($address, $name)
        ->subject($subject);
    }
}
