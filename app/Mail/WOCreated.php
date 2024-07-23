<?php

namespace App\Mail;

use App\Http\Models\workorder;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class WOCreated extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public $workorder;

    public function __construct(workorder $workorder)
    {
        $this->workorder = $workorder;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('kms@jatitinggi.biz')
                    ->subject("WO Created")
                    ->view('emails.wo.created');
    }
}
