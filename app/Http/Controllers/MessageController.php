<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Mail\Mailer;
use Illuminate\Support\Facades\Mail;

class MessageController extends Controller
{
    protected $allowedTags = [
        'p','strong','div'
    ];

    public function __construct() {
        // should be handled in route but just in case
        $this->middleware('auth');
    }

    public function form() {
        return view('mailform');
    }

    public function process(Request $request) {
        $message = new Message();
        $message->to = $request->get('to');
        $message->subject = strip_tags($request->get('subject'));
        $message->content = strip_tags($request->get('message'), $this->allowedTags);
        $message->status = 'pending';
        $message->save();

        Mail::to($request->get('to'))
            ->send(new \App\Mail\Message([
                'subject' => strip_tags($request->get('subject')),
                'content' => strip_tags($request->get('message'), $this->allowedTags)
            ]));

        $message->status = 'success';
        /// todo add webhook checking instead
        if (Mail::failures()) {
            $message->status = 'failed';
        }

        $message->save();
    }
}
