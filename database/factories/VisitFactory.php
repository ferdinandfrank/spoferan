<?php

$factory->define(App\Models\Visit::class, function (Faker\Generator $faker) {

    do {
        $visitClass = \App\FactoryHelper::getRandomOrCreate(\App\Models\VisitClass::class);
        $athlete = \App\FactoryHelper::getRandomOrCreate(\App\Models\Athlete::class);
    } while ($visitClass->isVisitor($athlete));

    return [
        'visit_class_id' => $visitClass->id,
        'athlete_id' => $athlete->user_id,
        'privacy' => false
    ];
});

$factory->define(App\Models\VisitClass::class, function (Faker\Generator $faker) {
    $event = \App\FactoryHelper::getRandomOrCreate(\App\Models\Event::class);

    $start_date = $event->start_date;

    $register_date = Carbon\Carbon::instance($start_date)->subMonths(rand(12, 1));
    $unregister_date = Carbon\Carbon::instance($start_date)->subDays(rand(2, 27));

    $titles = ['Basic', 'Standard', 'VIP', 'Exclusive'];
    $title = $titles[array_rand($titles, 1)];

    return [
        'event_id' => $event->id,
        'title' => $title,
        'description' => "Das $title Zuschauer Paket. In diesem Paket sind die folgenden Leistungen enthalten: " . $faker->text(),
        'price' => rand(1000, 20000),
        'restr_limit' => 100,
        'register_date' => $register_date,
        'unregister_date' => $unregister_date,
    ];
});
