<?php

namespace Tests\Browser\Auth;

use App\Models\Athlete;
use App\Models\Organizer;
use App\Models\User;
use Carbon\Carbon;
use Tests\Browser\Pages\Registration;
use Tests\DuskTestCase;
use Laravel\Dusk\Browser;

/**
 * RegistrationTest
 * -----------------------
 * Tests the main registration process of the application.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package Tests\Browser\Auth
 */
class RegistrationTest extends DuskTestCase {

    /**
     * The athlete that will be successfully registered within the test.
     *
     * @var Athlete|null
     */
    public static $registeredAthlete;

    /**
     * The organizer that will be successfully registered within the test.
     *
     * @var Organizer
     */
    public static $registeredOrganizer;

    /**
     * Set ups the test specific data.
     */
    public function setUp() {
        parent::setUp();

        // Create the athlete to register
        self::$registeredAthlete = new Athlete([
            'first_name' => 'John',
            'last_name'  => 'Doe',
            'gender'     => 'm',
            'birth_date' => Carbon::now()->subYears(20)
        ]);
        self::$registeredAthlete->user = new User([
            'email' => 'athlete.registration@test.de'
        ]);

        // Create the organizer to register
        self::$registeredOrganizer = new Organizer([
            'name' => 'JohnDoeEvents'
        ]);
        self::$registeredOrganizer->user = new User([
            'email' => 'organizer.registration@test.de'
        ]);
    }

    /**
     * Tests the successful registration process of an athlete.
     *
     * @group auth
     */
    public function test_athlete_registration_success() {

        $this->browse(function (Browser $browser) {

            // Type the necessary data into the inputs and submit the registration form
            $browser->visit(new Registration)
                    ->executeRegister(self::$registeredAthlete, \FakerSeeder::$USER_PASSWORD);

            // Wait a maximum of ten seconds and assert a success alert is shown
            $browser->waitForText(trans('alert.user.post.content'), 10);

            // Assert the data was inserted in the database
            $this->assertDatabaseHas(self::$registeredAthlete->user->getTable(), [
                'email' => self::$registeredAthlete->user->email
            ]);
            $this->assertDatabaseHas(self::$registeredAthlete->getTable(), [
                'first_name' => self::$registeredAthlete->first_name,
                'last_name'  => self::$registeredAthlete->last_name,
                'birth_date' => self::$registeredAthlete->birth_date->toDateString()
            ]);
        });
    }

    /**
     * Tests the failure of an athlete registration process because of an duplicate email address.
     *
     * @group auth
     */
    public function test_athlete_registration_failure_duplicate_email() {
        $this->browse(function (Browser $browser) {

            $failureAthlete = self::$registeredAthlete;
            $failureAthlete->first_name = 'Jane';

            // Type the necessary data into the inputs and submit the registration form
            $browser->visit(new Registration)
                    ->executeRegister($failureAthlete, \FakerSeeder::$USER_PASSWORD);

            // Wait a maximum of ten seconds and assert an error alert is shown
            $browser->waitForText(trans('validation.custom.email.unique'), 10);

            // Assert the data has not been inserted in the database
            $this->assertDatabaseMissing($failureAthlete->getTable(), [
                'first_name' => $failureAthlete->first_name,
                'last_name'  => $failureAthlete->last_name,
                'birth_date' => $failureAthlete->birth_date->toDateString()
            ]);
        });
    }

    /**
     * Tests the successful registration process of an organizer.
     *
     * @group auth
     */
    public function test_organizer_registration_success() {
        $this->browse(function (Browser $browser) {

            // Type the necessary data into the inputs and submit the registration form
            $browser->visit(new Registration)
                    ->executeRegister(self::$registeredOrganizer, \FakerSeeder::$USER_PASSWORD);

            // Wait a maximum of ten seconds and assert a success alert is shown
            $browser->waitForText(trans('alert.user.post.content'), 10);

            // Assert the data was inserted in the database
            $this->assertDatabaseHas(self::$registeredOrganizer->user->getTable(), [
                'email' => self::$registeredOrganizer->user->email
            ]);
            $this->assertDatabaseHas(self::$registeredOrganizer->getTable(), [
                'name' => self::$registeredOrganizer->name
            ]);
        });
    }

}
