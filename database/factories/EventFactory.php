<?php

$factory->define(App\Models\Event::class, function (Faker\Generator $faker) {

    $organizer = \App\FactoryHelper::getRandomOrCreate(\App\Models\Organizer::class);

    $sport_type_id = \App\Models\SportType::orderByRaw("RAND()")->first()->id;

    $start_date = $faker->dateTimeBetween('-2 years', '+2 years');
    $start_date->setTime(rand(6, 18), 0);
    $end_date = Carbon\Carbon::instance($start_date)->addHours(rand(5, 24));

    $title = $faker->domainWord . ' ' . $end_date->year;

    $states = ["DE-BY", "DE-BW", "DE-BE"];

    return [
        'organizer_id' => $organizer->user_id,
        'parent_event_id' => null,
        'title' => $title,
        'description_short' => $faker->text(config('validation.event.description_short.max')),
        'description' => $faker->text,
        'email' => $faker->companyEmail,
        'phone' => $faker->phoneNumber,
        'sport_type_id' => $sport_type_id,
        'published' => true,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'country' => $faker->countryCode,
        'state' => $states[array_rand($states)],
        'postcode' => $faker->postcode,
        'city' => $faker->city,
        'street' => $faker->streetAddress,
        'cover' => $faker->imageUrl(600, 300, 'sports')
    ];
});

$factory->define(App\Models\CheckPoint::class, function (Faker\Generator $faker) {
    $event = \App\FactoryHelper::getRandomOrCreate(\App\Models\Event::class);

    $position = count($event->checkPoints) + 1;
    return [
        'event_id' => $event->id,
        'position' => $position,
        'title' => $faker->domainWord,
        'latitude' => $faker->latitude,
        'longitude' => $faker->longitude,
        'country' => $faker->countryCode,
        'city' => $faker->city,
        'postcode' => $faker->postcode,
        'street' => $faker->streetAddress,
        'description' => $faker->text
    ];
});