<?php

namespace App\Models;

use App\Notifications\ResetPasswordNotification;

/**
 * CanResetPassword
 * -----------------------
 * ${CARET}
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package App\Models
 */
trait CanResetPassword {

    /**
     * The table name which holds the password reset tokens.
     *
     * @var string
     */
    private $resetPasswordTable = 'password_resets';

    /**
     * Gets the email address where password reset links are sent.
     *
     * @return string
     */
    public function getEmailForPasswordReset() {
        return $this->email;
    }

    /**
     * Sends the password reset notification.
     *
     * @param  string $token
     *
     * @return void
     */
    public function sendPasswordResetNotification($token) {
        $this->notify(new ResetPasswordNotification($token));
    }

    /**
     * Gets the table name which holds the password reset tokens.
     *
     * @return string
     */
    public function getResetPasswordTable(): string {
        return $this->resetPasswordTable;
    }

}