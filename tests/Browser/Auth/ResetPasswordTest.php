<?php

namespace Tests\Browser\Auth;

use DB;
use Exception;
use Tests\Browser\Pages\ForgotPassword;
use Tests\Browser\Pages\Login;
use Tests\Browser\Pages\ResetPassword;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

/**
 * ResetPasswordTest
 * -----------------------
 * Tests the password reset process of the application.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package Tests\Browser\Auth
 */
class ResetPasswordTest extends DuskTestCase {

    private $newPassword = 'newPassword';

    /**
     * Tests the successful password reset process of an athlete.
     *
     * @group auth
     */
    public function test_reset_password_success() {
        $this->browse(function (Browser $browser) {

            $athlete = RegistrationTest::$registeredAthlete;

            // Type the necessary data into the inputs and submit the login form
            $browser->visit(new ForgotPassword)
                    ->executeRequestPasswordReset($athlete->user->email);

            // Wait a maximum of ten seconds and assert a success alert is shown
            $browser->waitForText(trans('alert.password_forgot.post.content'), 10);

            // Check if a reset token was created
            $this->assertDatabaseHas($athlete->user->getResetPasswordTable(), [
                'email' => $athlete->user->email
            ]);

            // Because the token is hashed, we need to insert a custom one to get the plain token.
            // TODO: Implement with mocking as soon as it gets supported for Dusk
            $passwordBroker = \Password::broker();
            $token = $passwordBroker->createToken($athlete->user);

            $browser->visit(new ResetPassword($token))
                    ->executeResetPassword($athlete->user->email, $this->newPassword);

            // Wait a maximum of ten seconds and assert a success alert is shown
            $browser->waitForText(trans('alert.password_reset.post.content'), 10);

            // Wait until alert disappears and a redirect occurs
            $browser->pause(5000);

            // Logout because it is assumed that the user gets logged in after a password reset
            $browser->executeLogout();

            // Check if the old password is invalid
            $browser->visit(new Login)
                    ->executeLogin($athlete->user->email, \FakerSeeder::$USER_PASSWORD);

            // Wait a maximum of ten seconds and assert an error alert is shown
            $browser->waitForText(trans('validation.auth.failed'), 10);

            // Check if the new password works
            $browser->visit(new Login)
                    ->executeLogin($athlete->user->email, $this->newPassword);
            $browser->pause(2000);
            $browser->assertPathIs(getRelativeRoute(route('index')));

            $browser->executeLogout();
        });
    }


}
