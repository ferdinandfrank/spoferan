<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

/**
 * TestMail
 * -----------------------
 * Builds a new test email to test the email layout.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Mail
 */
class TestMail extends Mailable {

    use Queueable, SerializesModels;

    /**
     * Builds the message.
     *
     * @return $this
     */
    public function build() {
        return $this
            ->subject(trans('email.test.subject', ['title' => \Settings::title()]))
            ->markdown('emails.test', [
                'link' => route('index')
            ]);
    }
}
