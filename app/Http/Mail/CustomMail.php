<?php

namespace App\Http\Mail;

use Illuminate\Mail\Mailable;

class CustomMail extends Mailable
{
    public $resetUrl;

    public function __construct($resetUrl)
    {
        $this->resetUrl = $resetUrl;
    }

    public function build()
    {
        return $this->subject('Resetowanie hasła do panelu admina - KM-Grom')
            ->view('forgotPassword');
    }
}