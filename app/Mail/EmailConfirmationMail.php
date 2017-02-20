<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

/**
 * EmailConfirmationMail
 * -----------------------
 * Builds a new email to inform an user about his registration and sends him a link to confirm his email address.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Mail
 */
class EmailConfirmationMail extends Mailable {

    use Queueable, SerializesModels;

    private $user;

    /**
     * Creates a new message instance.
     *
     * @param User $user
     */
    public function __construct(User $user) {
        $this->user = $user;
    }

    /**
     * Builds the message.
     *
     * @return $this
     */
    public function build() {
        $link = route('login') . '?id=' . $this->user->id . '&token=' . $this->user->confirmation_token;

        return $this
            ->subject(trans('email.registration.title', ['title' => \Settings::title()]))
            ->view('emails.registration')
            ->with([
                'user' => $this->user,
                'link' => $link
            ]);
    }
}
