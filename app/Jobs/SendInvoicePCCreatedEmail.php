<?php
  
namespace App\Jobs;
   
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Mail\InvoicePaymentCertificateCreated;
use Mail;
   
class SendInvoicePCCreatedEmail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
  
    protected $details;
    protected $subconInvoice;
  
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($details, $subconInvoice)
    {
       
        $this->details = $details;
        $this->subconInvoice = $subconInvoice;
    }
   
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $email = new InvoicePaymentCertificateCreated($this->subconInvoice);
        Mail::to($this->details['email'])->send($email);
    }
}