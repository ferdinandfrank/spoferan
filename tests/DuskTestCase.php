<?php

namespace Tests;

use Laravel\Dusk\TestCase as BaseTestCase;
use Facebook\WebDriver\Remote\RemoteWebDriver;
use Facebook\WebDriver\Remote\DesiredCapabilities;

/**
 * DuskTestCase
 * -----------------------
 * Abstract class to setup the driver for Dusk test cases.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package Tests
 */
abstract class DuskTestCase extends BaseTestCase {

    use CreatesApplication;

    /**
     * Prepares for Dusk test execution.
     *
     * @beforeClass
     */
    public static function prepare() {
        static::startChromeDriver();
    }

    /**
     * Creates the RemoteWebDriver instance.
     *
     * @return \Facebook\WebDriver\Remote\RemoteWebDriver
     */
    protected function driver() {
        return RemoteWebDriver::create(
            'http://localhost:9515', DesiredCapabilities::chrome()
        );
    }
}
