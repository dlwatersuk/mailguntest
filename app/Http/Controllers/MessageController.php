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
        return view('mailform.send');
    }

    public function process(Request $request) {
        Mail::to($request->get('to'))
            ->send(new \App\Mail\Message([
                'subject' => strip_tags($request->get('subject')),
                'content' => strip_tags($request->get('message'), $this->allowedTags)
            ]));
        return redirect(route('mailform'));
    }

    public function all() {
        return view('mailform.all');
    }
}
