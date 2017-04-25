<?php

namespace Tests\Browser\Pages;

use Laravel\Dusk\Browser;

/**
 * Login
 * -----------------------
 * Represents the application's login page for testing.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package Tests\Browser\Pages
 */
class Login extends Page {

    /**
     * Gets the URL for the page.
     *
     * @return string
     */
    public function url() {
        return getRelativeRoute(route('login'));
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
            '@password' => 'input[name=password]',
            '@submit'   => 'button[type=submit]',
        ];
    }

    /**
     * Enters the specified email address and password into the login form and submits the form.
     *
     * @param Browser $browser
     * @param string  $email
     * @param string  $password
     */
    public function executeLogin(Browser $browser, $email, $password) {
        $browser->type('@email', $email)
                ->type('@password', $password)
                ->click('@submit');
    }
}
