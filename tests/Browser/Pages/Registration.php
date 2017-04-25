<?php

namespace Tests\Browser\Pages;

use App\Models\Athlete;
use App\Models\Organizer;
use App\Models\User;
use Laravel\Dusk\Browser;

/**
 * Registration
 * -----------------------
 * Represents the application's registration page for testing.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package Tests\Browser\Pages
 */
class Registration extends Page {

    /**
     * Gets the URL for the page.
     *
     * @return string
     */
    public function url() {
        return  getRelativeRoute(route('register'));
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
            '@name'                  => 'input[name=name]',
            '@first_name'            => 'input[name=first_name]',
            '@last_name'             => 'input[name=last_name]',
            '@birth_date'            => 'input[name=birth_date]',
            '@gender'                => 'select[name=gender]',
            '@email'                 => 'input[name=email]',
            '@password'              => 'input[name=password]',
            '@password_confirmation' => 'input[name=password_confirmation]',
            '@user_type'             => '#change-user_type > .switch',
            '@submit'                => 'button[type=submit]',
        ];
    }

    /**
     * Enters the data of the specified user object into the registration form and submits the form.
     *
     * @param Browser                     $browser
     * @param Organizer|Athlete|User|null $user
     * @param string|null                 $password
     */
    public function executeRegister(Browser $browser, $user = null, $password = null) {

        // Check if registration as athlete is enabled by default
        $browser->assertVisible('@first_name');
        $browser->assertMissing('@name');

        // Insert user type specific input values
        if ($user instanceof Organizer) {

            // Activate registration as organizer
            $browser->click('@user_type');
            $browser->assertMissing('@first_name');
            $browser->assertVisible('@name');

            $browser->type('@name', $user->name ?? $this->faker->company);
            $browser->type('@email',
                $user->user && $user->user->email ? $user->user->email : $this->faker->companyEmail);
        } elseif ($user instanceof Athlete) {
            $browser->type('@first_name', $user->first_name ?? $this->faker->firstName);
            $browser->type('@last_name', $user->last_name ?? $this->faker->lastName);
            $browser->select('@gender', $user->gender ?? 'm');
            $browser->type('@birth_date', $user->birth_date ? $user->birth_date->format('d.m.Y') : '20.08.1993');
            $browser->type('@email', $user->user && $user->user->email ? $user->user->email : $this->faker->email);
        } else {
            $browser->type('@first_name', $this->faker->firstName);
            $browser->type('@last_name', $this->faker->lastName);
            $browser->select('@gender', 'm');
            $browser->type('@birth_date', '20.08.1993');
            $browser->type('@email', $user && $user->email ? $user->email : $this->faker->email);
        }

        $password = $password ?? $this->faker->password;

        $browser->type('@password', $password)
                ->type('@password_confirmation', $password)
                ->click('@submit');
    }
}
