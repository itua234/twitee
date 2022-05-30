<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class verifyAccountMail extends Mailable
{
    use Queueable, SerializesModels;

    public $user;

    public $code;
    
    public function __construct($user, $code)
    {
        $this->user = $user;
        $this->code = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(getenv('MAIL_FROM_ADDRESS'), "Workpro")
        ->subject("Verify your Workpro account.")
        ->view('email.verify');
    }
}
