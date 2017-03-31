<?php

use Illuminate\Database\Seeder;

/**
 * MandatorySeeder
 * -----------------------
 * Fills the database with mandatory data.
 * -----------------------
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
            ['label' => 'other', 'slug' => 'other', 'icon' => '/images/icons/sport_type_other.png'],
            ['label' => 'triathlon', 'slug' => 'triathlon', 'icon' => '/images/icons/sport_type_triathlon.png'],
            ['label' => 'marathon', 'slug' => 'marathon', 'icon' => '/images/icons/sport_type_marathon.png'],
            ['label' => 'swimming', 'slug' => 'swimming', 'icon' => '/images/icons/sport_type_swimming.png'],
            ['label' => 'inline_skating', 'slug' => 'inline-skating', 'icon' => '/images/icons/sport_type_inline_skating.png'],
            ['label' => 'nordic_walking', 'slug' => 'nordic-walking', 'icon' => '/images/icons/sport_type_nordic_walking.png'],
            ['label' => 'cycling', 'slug' => 'cycling', 'icon' => '/images/icons/sport_type_cycling.png'],
            ['label' => 'basketball', 'slug' => 'basketball', 'icon' => '/images/icons/sport_type_basketball.png'],
            ['label' => 'soccer', 'slug' => 'soccer', 'icon' => '/images/icons/sport_type_soccer.png']
        ]);

        DB::table('participation_states')->insert([
            ['label' => 'registered', 'color' => 'success', 'selectable' => true],
            ['label' => 'unregistered', 'color' => 'warning', 'selectable' => true],
            ['label' => 'active', 'color' => 'primary', 'selectable' => true],
            ['label' => 'disqualified', 'color' => 'error', 'selectable' => true],
            ['label' => 'ranked', 'color' => 'success', 'selectable' => true],
            ['label' => 'not_started', 'color' => 'error', 'selectable' => true]
        ]);
    }
}
