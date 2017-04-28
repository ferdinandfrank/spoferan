<?php

/**
 * Creates a fake user.
 */
$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'current_user_type' => config('spoferan.user_type.athlete'),
        'email'             => $faker->email,
        'password'          => bcrypt(str_random(10)),
        'confirmed'         => true,
        'avatar'            => null
    ];
});

/**
 * Creates a fake athlete.
 */
$factory->define(App\Models\Athlete::class, function (Faker\Generator $faker) {

    $gender = ['m', 'w'];
    $genderName = ['male', 'female'];
    $rand_gender_id = array_rand($gender);
    $sport_type_id = \App\Models\SportType::orderByRaw("RAND()")->first()->id;

    return [
        'user_id'       => function () {
            return factory(App\Models\User::class)->create(['current_user_type' => config('spoferan.user_type.athlete')])->id;
        },
        'first_name'    => $faker->firstName($genderName[$rand_gender_id]),
        'last_name'     => $faker->lastName,
        'gender'        => $gender[$rand_gender_id],
        'sport_type_id' => $sport_type_id,
        'birth_date'    => $faker->date("Y-m-d", '-18 years'),
    ];
});

/**
 * Creates a fake organizer.
 */
$factory->define(App\Models\Organizer::class, function (Faker\Generator $faker) {
    return [
        'user_id'     => function () {
            return factory(App\Models\User::class)->create(['current_user_type' => config('spoferan.user_type.organizer')])->id;
        },
        'name'        => $faker->company,
        'description' => $faker->text()
    ];
});