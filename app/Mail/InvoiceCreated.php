<?php

namespace App\Mail;


use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class InvoiceCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $subconInvoice;

    public function __construct($subconInvoice)
    {
        $this->subconInvoice = $subconInvoice;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('kms@jatitinggi.biz')
                    ->subject($this->subconInvoice['test'].$this->subconInvoice['ProjectCode'].' ('.$this->subconInvoice['Vendor'].') - Invoice Created')
                    ->view('emails.SubconInvoice.created');
    }
}
