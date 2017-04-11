<?php

/**
 * Creates a fake coupon.
 */
$factory->define(App\Models\Coupon::class, function (Faker\Generator $faker) {

    // Generate a random number as the amount / percentage off divisible by 5
    $off = rand(1, 10) * 5;
    $amountOff = rand(1, 99) < 50;

    $types = \App\Models\Coupon::$types;

    return [
        'code'            => \App\Models\Coupon::generate(),
        'creator_id'      => null,
        'amount_off'      => $amountOff ? rand(100, 1000) * 5 : null,
        'percent_off'     => !$amountOff ? rand(1, 10) * 5 : null,
        'redeem_start'    => null,
        'redeem_end'      => null,
        'type'            => $types[array_rand($types)],
        'max_redemptions' => rand(1, 100),
        'times_redeemed'  => 0,
        'valid'           => true
    ];
});