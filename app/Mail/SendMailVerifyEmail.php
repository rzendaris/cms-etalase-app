<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendMailVerifyEmail extends Mailable
{
    use Queueable, SerializesModels;
    public $data;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->to($this->data['email'])
                        ->subject('Verify Email')
                        ->from('etalase.admin@bagustech.id','Etalase App Administrator')
                        ->view('auth.passwords.verify-email')
                        ->with(['name' =>$this->data['name'],'reset_url'=>$this->data['reset_url']]);
    }
}
