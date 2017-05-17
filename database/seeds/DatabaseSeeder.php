<?php

use Illuminate\Database\Seeder;

/**
 * DatabaseSeeder
 * -----------------------
 * Main seeder class to fill the database with data.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class DatabaseSeeder extends Seeder {

    /**
     * Runs the database seeds.
     */
    public function run() {
        $this->call(MandatorySeeder::class);
        $this->call(FakerSeeder::class);
    }
}
