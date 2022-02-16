<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class Message extends Mailable
{
    use Queueable, SerializesModels;

    public $data = [
        'subject' => null,
        'content' => null
    ];

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($data)
    {
        $this->data = $data;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $this->withSwiftMessage(function ($message) {
            $messageObj = new \App\Models\Message();
            $messageObj->to = $this->to[0]['address'];
            $messageObj->subject = $this->subject;
            $messageObj->content = $this->data['content'];
            $messageObj->status = 'pending';
            $messageObj->mailgun_id = $message->getId();
            $messageObj->save();
        });
        return $this
            ->subject($this->data['subject'])
            ->view('mail.mail', [
            'content' => $this->data['content']
        ]);
    }
}
