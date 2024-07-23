<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class JMSCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $jms;

    public function __construct($jms)
    {
        $this->jms = $jms;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        return $this->from('kms@jatitinggi.biz')
                    ->subject($this->jms['test'].$this->jms['projectCode'].' ('.$this->jms['companyName'].') - JMS Submission' )
                    ->view('emails.jms.created');
    }
}
