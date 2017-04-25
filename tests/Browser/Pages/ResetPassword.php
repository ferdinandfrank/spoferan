<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

/**
 * ResetPassword
 * -----------------------
 * Represents the application's reset password page for testing.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package Tests\Browser\Pages
 */
class ResetPassword extends Page {

    private $token;


    public function __construct($token) {
        $this->token = $token;
    }

    /**
     * Gets the URL for the page.
     *
     * @return string
     */
    public function url() {
        return getRelativeRoute(route('password.reset', ['token' => $this->token]));
    }

    /**
     * Asserts that the browser is on the page.
     *
     * @param Browser $browser
     */
    public function assert(Browser $browser) {
        $browser->assertPathIs($this->url());
    }

    /**
     * Gets the element shortcuts for the page.
     *
     * @return array
     */
    public function elements() {
        return [
            '@email'                 => 'input[name=email]',
            '@password'              => 'input[name=password]',
            '@password_confirmation' => 'input[name=password_confirmation]',
            '@submit'                => 'button[type=submit]',
        ];
    }

    /**
     * Enters the specified email address and password into the reset password form and submits the form.
     *
     * @param Browser $browser
     * @param string  $email
     * @param         $password
     */
    public function executeResetPassword(Browser $browser, $email, $password) {
        $browser->type('@email', $email)
                ->type('@password', $password)
                ->type('@password_confirmation', $password)
                ->click('@submit');
    }
}
