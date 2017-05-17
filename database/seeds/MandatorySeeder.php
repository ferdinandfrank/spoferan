<?php

use Illuminate\Database\Seeder;

/**
 * MandatorySeeder
 * -----------------------
 * Fills the database with mandatory data.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class MandatorySeeder extends Seeder {

    /**
     * Runs the database seeds.
     */
    public function run() {
        DB::table('sport_types')->insert([
            ['label' => 'other', 'slug' => 'other', 'icon' => '/images/icons/sport_types/other.png'],
            ['label' => 'triathlon', 'slug' => 'triathlon', 'icon' => '/images/icons/sport_types/triathlon.png'],
            ['label' => 'marathon', 'slug' => 'marathon', 'icon' => '/images/icons/sport_types/marathon.png'],
            ['label' => 'swimming', 'slug' => 'swimming', 'icon' => '/images/icons/sport_types/swimming.png'],
            ['label' => 'inline_skating', 'slug' => 'inline-skating', 'icon' => '/images/icons/sport_types/inline_skating.png'],
            ['label' => 'nordic_walking', 'slug' => 'nordic-walking', 'icon' => '/images/icons/sport_types/nordic_walking.png'],
            ['label' => 'cycling', 'slug' => 'cycling', 'icon' => '/images/icons/sport_types/cycling.png'],
            ['label' => 'basketball', 'slug' => 'basketball', 'icon' => '/images/icons/sport_types/basketball.png'],
            ['label' => 'soccer', 'slug' => 'soccer', 'icon' => '/images/icons/sport_types/soccer.png']
        ]);

        DB::table('participation_states')->insert([
            ['label' => 'registered', 'selectable' => true],
            ['label' => 'unregistered', 'selectable' => true],
            ['label' => 'active', 'selectable' => true],
            ['label' => 'disqualified', 'selectable' => true],
            ['label' => 'ranked', 'selectable' => true],
            ['label' => 'not_started', 'selectable' => true]
        ]);

        DB::table('labels')->insert([
            ['label' => 'bronze', 'selectable' => true, 'price' => 200, 'icon' => '/images/icons/labels/bronze.png'],
            ['label' => 'silver', 'selectable' => true, 'price' => 300, 'icon' => '/images/icons/labels/silver.png'],
            ['label' => 'gold', 'selectable' => true, 'price' => 500, 'icon' => '/images/icons/labels/gold.png'],
            ['label' => 'eco', 'selectable' => false, 'price' => 0, 'icon' => '/images/icons/labels/eco.png'],
            ['label' => 'fun', 'selectable' => true, 'price' => 0, 'icon' => '/images/icons/labels/fun.png'],
            ['label' => 'health', 'selectable' => true, 'price' => 0, 'icon' => '/images/icons/labels/health.png'],
            ['label' => 'licence', 'selectable' => false, 'price' => 0, 'icon' => '/images/icons/labels/licence.png'],
            ['label' => 'women', 'selectable' => true, 'price' => 0, 'icon' => '/images/icons/labels/licence.png'],
        ]);
    }
}
