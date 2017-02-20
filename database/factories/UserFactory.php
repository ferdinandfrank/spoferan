<?php

$factory->define(App\Models\User::class, function (Faker\Generator $faker) {
    return [
        'user_type' => random_int(0, 1),
        'email' => $faker->email,
        'password' => bcrypt(str_random(10)),
        'confirmed' => true,
        'country' => $faker->countryCode,
        'postcode' => $faker->postcode,
        'city' => $faker->city,
        'street' => $faker->streetAddress,
        'phone' => $faker->phoneNumber
    ];
});

$factory->define(App\Models\Athlete::class, function (Faker\Generator $faker) {

    $gender = ['m', 'w'];
    $genderName = ['male', 'female'];
    $rand_gender_id = array_rand($gender);
    $sport_type_id = \App\Models\SportType::orderByRaw("RAND()")->first()->id;

    return [
        'user_id' => function () {
            return factory(App\Models\User::class)->create(['user_type' => config('starmee.user_type.athlete')])->id;
        },
        'first_name' => $faker->firstName($genderName[$rand_gender_id]),
        'last_name' => $faker->lastName,
        'gender' => $gender[$rand_gender_id],
        'sport_type_id' => $sport_type_id,
        'birth_date' => $faker->date("Y-m-d", '-18 years'),
    ];
});

$factory->define(App\Models\Organizer::class, function (Faker\Generator $faker) {
    return [
        'user_id' => function () {
            return factory(App\Models\User::class)->create(['user_type' => config('starmee.user_type.organizer')])->id;
        },
        'name' => $faker->company,
        'description' => $faker->text()
    ];
});