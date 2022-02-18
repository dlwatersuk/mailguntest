<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;

class MesssageWebhookController extends Controller
{
    public function __construct() {
        ///// no auth needed - but could add something like an auth key
    }

    public function call(Request $request) {
        $event = $request->get('event-data');
        $signature = $request->get('signature');
        $timestamp = $signature['timestamp'];
        $token = $signature['token'];

        $messageHeaders = $event['message']['headers'];

        // hmac authentication before using anything to make sure it was mailgun that posted
        $hmac = hash_hmac(
            $timestamp,
            $token,
            env('MAILGUN_KEY') /// get this from mailgun site to verify webhook
        );
        // could also check origin domain or IP for a fallback - prob not needed

        if ($hmac !== $signature['signature']) {
            // could add abuse logic here
            die('POST does not look to be from Mailgun');
        }

        $messageId = $messageHeaders['message-id'];
        $message = Message::find('mailgun_id', $messageId);
        if (is_null($message)) {
            die('message ID not found in system');
        }

        // does not  track every event, but we only care about these as a very basic usecase
        switch ($event['data']) {
            case 'delivered':
                $message->status = 'delivered';
                break;
            case 'failed':
                $message->status = 'failed';
                break;
            case 'opened':
                $message->increment('opened');
                break;
            case 'clicked':
                $message->increment('clicked');
                break;
        }
        $message->save();
    }
}
