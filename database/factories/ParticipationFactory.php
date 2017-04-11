<?php

/**
 * Creates a fake participation.
 */
$factory->define(App\Models\Participation::class, function (Faker\Generator $faker) {

    // Get or calculate specific properties for the participation to create
    do {
        $participationClass = \App\FactoryHelper::getRandomOrCreate(\App\Models\ParticipationClass::class);
        $athlete = \App\FactoryHelper::getRandomOrCreate(\App\Models\Athlete::class);
    } while ($participationClass->isParticipant($athlete));

    // Set the privacy to true with a probability of 20%
    $privacy = rand(0,99) < 20;

    return [
        'participation_class_id' => $participationClass->id,
        'athlete_id' => $athlete->user_id,
        'starter_number' => $athlete->starter_number,
        'privacy' => $privacy,
        'rank' => null,
        'description' => null
    ];
});

/**
 * Creates a fake participation class.
 */
$factory->define(App\Models\ParticipationClass::class, function (Faker\Generator $faker) {

    // Get or calculate specific properties for the participation class to create
    $event = \App\FactoryHelper::getRandomOrCreate(\App\Models\Event::class);
    $titles = ['Frauen', 'Männer', 'Erwachsene', 'Jugend', 'Jungs', 'Mädchen', 'Kinder'];
    $title = $titles[array_rand($titles, 1)];
    $start_date = $event->start_date;
    $end_date = $event->end_date;
    $register_date = Carbon\Carbon::instance($start_date)->subMonths(rand(12, 1));
    $unregister_date = Carbon\Carbon::instance($start_date)->subDays(rand(2, 27));

    // Calculate the birth date / age restrictions
    $restr_birth_date_max = null;
    $restr_birth_date_min = $event->start_date->subYears(18);
    if ($title == 'Jungs' || $title == 'Mädchen' || $title == 'Jugend') {
        $restr_birth_date_max = $event->start_date->subYears(18);
        $restr_birth_date_min = $event->start_date->subYears(12);
    } elseif ($title == 'Kinder') {
        $restr_birth_date_max = $event->start_date->subYears(12);
        $restr_birth_date_min = $event->start_date->subYears(6);
    }

    // Calculate the gender
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
        'price' => rand(1000, 20000),
        'start_date' => $start_date,
        'end_date' => $end_date,
        'register_date' => $register_date,
        'unregister_date' => $unregister_date,
        'restr_limit' => rand(10, 500),
        'restr_birth_date_min' => $restr_birth_date_min,
        'restr_birth_date_max' => $restr_birth_date_max,
        'restr_gender' => $gender,
        'restr_country' => null,
        'restr_postcode' => null,
        'restr_club_id' => null
    ];
});