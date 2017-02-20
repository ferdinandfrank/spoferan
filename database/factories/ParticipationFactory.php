<?php

$factory->define(App\Models\Participation::class, function (Faker\Generator $faker) {

    do {
        $participationClass = \App\FactoryHelper::getRandomOrCreate(\App\Models\ParticipationClass::class);
        $athlete = \App\FactoryHelper::getRandomOrCreate(\App\Models\Athlete::class);
    } while ($participationClass->isParticipant($athlete));

    return [
        'participation_class_id' => $participationClass->id,
        'athlete_id' => $athlete->user_id,
        'starter_number' => rand(1, 9999),
        'privacy' => false,
        'rank' => null,
        'time' => null,
        'description' => null
    ];
});

$factory->define(App\Models\ParticipationClass::class, function (Faker\Generator $faker) {
    $event = \App\FactoryHelper::getRandomOrCreate(\App\Models\Event::class);

    $start_date = $event->start_date;
    $end_date = $event->end_date;

    $register_date = Carbon\Carbon::instance($start_date)->subMonths(rand(12, 1));
    $unregister_date = Carbon\Carbon::instance($start_date)->subDays(rand(2, 27));

    return [
        'event_id' => $event->id,
        'title' => $faker->domainWord,
        'description' => $faker->text,
        'entry_fee' => $faker->randomFloat(2, 5, 999),
        'start_date' => $start_date,
        'end_date' => $end_date,
        'register_date' => $register_date,
        'unregister_date' => $unregister_date,
        'restr_limit' => 100,
        'restr_birth_date_min' => null,
        'restr_birth_date_max' => null,
        'restr_gender' => null,
        'restr_country' => null,
        'restr_city' => null,
        'restr_postcode' => null,
    ];
});