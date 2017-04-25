<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

/**
 * ForgotPassword
 * -----------------------
 * Represents the application's forgot password page for testing.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package Tests\Browser\Pages
 */
class ForgotPassword extends Page {

    /**
     * Gets the URL for the page.
     *
     * @return string
     */
    public function url() {
        return getRelativeRoute(route('password.request'));
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
            '@email'    => 'input[name=email]',
            '@submit'   => 'button[type=submit]',
        ];
    }

    /**
     * Enters the specified email address into the forgot password form and submits the form.
     *
     * @param Browser $browser
     * @param string  $email
     */
    public function executeRequestPasswordReset(Browser $browser, $email) {
        $browser->type('@email', $email)
                ->click('@submit');
    }
}
