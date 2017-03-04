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

    $titles = ['Frauen', 'Männer', 'Erwachsene', 'Jugend', 'Jungs', 'Mädchen', 'Kinder'];
    $title = $titles[array_rand($titles, 1)];

    $start_date = $event->start_date;
    $end_date = $event->end_date;

    $register_date = Carbon\Carbon::instance($start_date)->subMonths(rand(12, 1));
    $unregister_date = Carbon\Carbon::instance($start_date)->subDays(rand(2, 27));

    $restr_birth_date_max = null;
    $restr_birth_date_min = $event->start_date->subYears(18);
    if ($title == 'Jungs' || $title == 'Mädchen' || $title == 'Jugend') {
        $restr_birth_date_max = $event->start_date->subYears(18);
        $restr_birth_date_min = $event->start_date->subYears(12);
    } elseif ($title == 'Kinder') {
        $restr_birth_date_max = $event->start_date->subYears(12);
        $restr_birth_date_min = $event->start_date->subYears(6);
    }

    $gender = null;
    if ($title == 'Jungs' || $title == 'Männer') {
        $gender = 'm';
    } elseif ($title == 'Mädchen' || $title == 'Frauen') {
        $gender = 'w';
    }

    return [
        'event_id' => $event->id,
        'title' => $title,
        'description' => "Die Teilnahmeklasse für $title. Hier dürfen ausschließlich $title teilnehmen, um einen fairen Wettkampf zu garantieren. Bitte beachte zudem die weiteren Teilnahmebeschränkungen.",
        'entry_fee' => $faker->randomFloat(2, 5, 999),
        'start_date' => $start_date,
        'end_date' => $end_date,
        'register_date' => $register_date,
        'unregister_date' => $unregister_date,
        'restr_limit' => rand(10, 500),
        'restr_birth_date_min' => $restr_birth_date_min,
        'restr_birth_date_max' => $restr_birth_date_max,
        'restr_gender' => $gender,
        'restr_country' => null,
        'restr_city' => null,
        'restr_postcode' => null,
    ];
});