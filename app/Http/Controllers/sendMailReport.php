<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Mail;

class sendMailReport extends Controller
{
    public function sendMail()
    {
    	$path = 'C:\wamp\www\jati_kms\local\storage\attachments_pdf\dummy_pdf.pdf';
    	Mail::send('emails.send_mail_report', ['one'], function ($message) {

    		$message->from('no_reply@jatitinggi.biz', 'Jati Tinggi Holding Sdn Bhd');
    		$message->to('sooyong.poh@jatitinggi.biz', 'PSY')->subject('This is a message');
    		$message->attach('C:\wamp\www\jati_kms\local\storage\attachments_pdf\dummy_pdf.pdf');
    	});

    	return "Mail sent!";
    }
}
