<?php

namespace App\Mail;

use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class ResetPasswordMail extends Mailable
{
    use SerializesModels;

    public $token; // Make sure this is public so it can be accessed in the view

    /**
     * Create a new message instance.
     *
     * @param string $token
     * @return void
     */
    public function __construct($token)
    {
        $this->token = $token;
    }

    /**
     * Build the message.
     *
     * @return \Illuminate\Contracts\Mail\Renderable
     */
    public function build()
    {
        return $this->view('emails.reset_password') // Create a view to display email content
                    ->subject('Password Reset Request')
                    ->with([
                        'token' => $this->token,
                    ]);
    }
}