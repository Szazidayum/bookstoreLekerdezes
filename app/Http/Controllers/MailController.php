<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Mail;
use App\Mail\DemoMail;
use Illuminate\Http\Request;

class MailController extends Controller
{
    public function index(){
        $mailData = [
            'title' => 'Szia!',
            'body' => 'Milyen a webprog?:)'
        ];
        
        Mail::to('paaladam1@gmail.com')
 ->send(new DemoMail($mailData));
 
        dd("Email is sent successfully.");

    //     foreach (['taylor@example.com', 'dries@example.com'] as $recipient){
    //         Mail::to($recipient)->send(new DemoMail($mailData));
    //     }
    //     // vagy
    //     $emails = ['taylor@example.com', 'dries@example.com'];
    //     Mail::send('emails.welcome', [], function($message) use ($emails)
    //     {
    //         $message->to($emails)->subject('This is a test email.');
    //     });
    //     var_dump(Mail::failures());
    //     exit;
    }
 
}
