<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MesssageWebhookController extends Controller
{
    public function __construct() {
        /////
    }

    public function call(Request $request) {
        $id = $request->get('id');
        $rec = $request->get('recipient');
        $event = $request->get('event');
        $timestamp = $request->get('timestamp');

        // hmac authentication before using anything

    }
}
