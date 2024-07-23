<?php
  
namespace App\Jobs;
   
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\JMSIPCReminder;
use Mail;
   
class SendIPCReminderEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  
    protected $details;
    protected $jms;
  
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details, $jms)
    {
        $this->details = $details;
        $this->jms = $jms;
    }
   
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new JMSIPCReminder($this->jms);
        Mail::to($this->details['email'])->send($email);
    }
}