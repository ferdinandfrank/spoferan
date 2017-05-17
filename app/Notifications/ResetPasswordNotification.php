<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

/**
 * ResetPasswordNotification
 * -----------------------
 * Notification class to notify an user about his requested password reset, i.e. send him a 'reset password' mail.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Notifications
 */
class ResetPasswordNotification extends Notification {

    use Queueable;

    /**
     * The password reset token.
     *
     * @var string
     */
    public $token;

    /**
     * Creates a notification instance.
     *
     * @param  string $token
     */
    public function __construct($token) {
        $this->token = $token;
    }

    /**
     * Gets the notification's channels.
     *
     * @param  mixed $notifiable
     *
     * @return array|string
     */
    public function via($notifiable) {
        return ['mail'];
    }

    /**
     * Builds the mail representation of the notification.
     *
     * @param  mixed $notifiable
     *
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable) {
        return (new MailMessage)
            ->subject(trans('email.password_reset.title'))
            ->greeting(trans('email.greeting', ['name' => $notifiable->getDisplayName()]))
            ->line(trans('email.password_reset.content', ['title' => \Settings::title()]))
            ->action(trans('action.reset_password'), route('password.reset', $this->token));
    }
}
