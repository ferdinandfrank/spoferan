<?php

/**
 * Creates a fake event.
 */
$factory->define(App\Models\Event::class, function (Faker\Generator $faker) {

    // Get or calculate specific properties for the event to create
    $organizerId = \App\FactoryHelper::getRandomOrCreate(\App\Models\Organizer::class)->user_id;
    $sportTypeId = \App\Models\SportType::orderByRaw("RAND()")->first()->id;
    $start_date = $faker->dateTimeBetween('-2 years', '+2 years');
    $start_date->setTime(rand(6, 18), 0);
    $end_date = Carbon\Carbon::instance($start_date)->addHours(rand(5, 24));
    $title = $faker->domainWord . ' ' . $end_date->year;
    $countryCode = 'DE';
    $states = \App\Models\State::all()[$countryCode];

    // Set an event group for the created event with a probability of 20%
    $hasGroupProbability = rand(0,99);
    $eventGroupId = null;
    if ($hasGroupProbability < 20) {
        $eventGroupId = \App\FactoryHelper::getRandomOrCreate(\App\Models\EventGroup::class, [
            'organizer_id' => $organizerId,
            'sport_type_id' => $sportTypeId
        ])->id;
    }

    return [
        'organizer_id' => $organizerId,
        'event_group_id' => $eventGroupId,
        'parent_event_id' => null,
        'title' => $title,
        'description_short' => $faker->text(config('validation.event.description_short.max')),
        'description' => $faker->text,
        'email' => $faker->companyEmail,
        'phone' => $faker->phoneNumber,
        'sport_type_id' => $sportTypeId,
        'published' => true,
        'start_date' => $start_date,
        'end_date' => $end_date,
        'country' => $countryCode,
        'state' => $states[array_rand($states)],
        'postcode' => $faker->postcode,
        'city' => $faker->city,
        'street' => $faker->streetAddress,
        'cover' => $faker->imageUrl(600, 300, 'sports')
    ];
});

/**
 * Creates a fake event group.
 */
$factory->define(App\Models\EventGroup::class, function (Faker\Generator $faker) {

    // Get or calculate specific properties for the event group to create
    $organizerId = \App\FactoryHelper::getRandomOrCreate(\App\Models\Organizer::class)->user_id;
    $sportTypeId = \App\Models\SportType::orderByRaw("RAND()")->first()->id;

    return [
        'organizer_id' => $organizerId,
        'title' => $faker->domainWord,
        'description' => $faker->text,
        'sport_type_id' => $sportTypeId,
        'cover' => $faker->imageUrl(600, 300, 'sports')
    ];
});

/**
 * Creates a fake check point.
 */
$factory->define(App\Models\CheckPoint::class, function (Faker\Generator $faker) {

    // Get or calculate specific properties for the checkpoint to create
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