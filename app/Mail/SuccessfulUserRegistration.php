<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SuccessfulUserRegistration extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $user;
    public $decryptedPassword;
    public function __construct($user,$decryptedPassword)
    {
        $this->user = $user;
        $this->decryptedPassword = $decryptedPassword;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.users.register',['user'=>$this->user,
                                                        'decryptedPassword'=>$this->decryptedPassword]);
    }
}
