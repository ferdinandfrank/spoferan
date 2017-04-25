<?php

namespace Tests\Browser\Auth;

use Tests\Browser\Pages\Login;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

/**
 * LoginTest
 * -----------------------
 * Tests the login process of the application.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package Tests\Browser\Auth
 */
class LoginTest extends DuskTestCase {

    /**
     * Tests the successful login and logout process of an athlete.
     *
     * @group auth
     */
    public function test_athlete_auth_success() {

        $this->browse(function (Browser $browser) {

            $athlete = RegistrationTest::$registeredAthlete;

            // Type the necessary data into the inputs and submit the login form
            $browser->visit(new Login)
                    ->executeLogin($athlete->user->email, \FakerSeeder::$USER_PASSWORD);

            // Check if the user is redirected to his dashboard
            $browser->pause(2000);
            $browser->assertPathIs(getRelativeRoute(route('index')));

            // Logout the user
            $browser->executeLogout();

            // Check if the user is on the login page
            $browser->pause(2000);
            $browser->assertPathIs(getRelativeRoute(route('login')));
        });
    }

    /**
     * Tests the failure of an athlete's login process because of a wrong password.
     *
     * @group auth
     */
    public function test_athlete_login_failure_wrong_password() {
        $this->browse(function (Browser $browser) {

            // Type the necessary data into the inputs and submit the login form
            $browser->visit(new Login)
                    ->executeLogin('doesnotexist@test.de', 'wrongpassword');

            // Wait a maximum of ten seconds and assert an error alert is shown
            $browser->waitForText(trans('validation.auth.failed'), 10);
        });
    }

}
