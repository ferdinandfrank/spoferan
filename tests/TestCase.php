<?php

namespace Tests;

use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

/**
 * TestCase
 * -----------------------
 * Abstract class for all test cases to define necessary traits which all test classes shall use.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 * @package Tests
 */
abstract class TestCase extends BaseTestCase {
    use CreatesApplication;
}
