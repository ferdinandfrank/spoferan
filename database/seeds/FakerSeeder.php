<?php

use Illuminate\Database\Seeder;

/**
 * FakerSeeder
 * -----------------------
 * Fills the database with fake data.
 * -----------------------
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class FakerSeeder extends Seeder {

    /**
     * Runs the database seeds.
     */
    public function run() {
        $faker = Faker\Factory::create();

        factory(App\Models\Athlete::class, 50)->create();
        factory(App\Models\Organizer::class, 30)->create();
        factory(App\Models\Event::class, 30)->create()->each(function($event) {
            $event->checkPoints()->save(factory(App\Models\CheckPoint::class)->make());
        });

        $user = factory(App\Models\User::class)->create([
            'user_type' => config('starmee.user_type.athlete'),
            'email' => 'ferdinand-frank@web.de',
            'password' => 'password',
            'verified' => true,
            'country' => 'Germany',
            'postcode' => '94032',
            'city' => 'Passau',
            'street' => 'Spitalhofstraße 77'
        ]);

        factory(App\Models\Athlete::class)->create([
            'user_id' => $user->id,
            'first_name' => 'Ferdinand',
            'last_name' => 'Frank',
            'gender' => 'm',
            'birth_date' => '1994-08-25'
        ]);


        $organizerUser = factory(App\Models\User::class)->create([
            'user_type' => config('starmee.user_type.organizer'),
            'email' => 'organizer@mail.de',
            'password' => 'password',
            'verified' => true
        ]);

        $organizer = factory(App\Models\Organizer::class)->create([
            'user_id' => $organizerUser->id,
            'name' => 'Landkreis Starnberg',
        ]);

        for ($i = 0; $i < 10; $i++) {
            $raterId = \App\FactoryHelper::getRandomOrCreate(\App\Models\Athlete::class)->id;
            $params = [
                'rating' => rand(1,5),
                'description' => $faker->text
            ];
            $organizer->raters()->attach($raterId, $params);
        }

        $events = array();
        $eventParts = array();

        // Landkreislauf Starnberg 2015
        $event1 = factory(App\Models\Event::class)->create([
            'organizer_id' => $organizer->user_id,
            'title' => 'Landkreislauf Starnberg 2015',
            'description_short' => 'Der Landkreislauf ist das größte Breitensportereignis des Landkreises Starnberg und hat eine langjährige Tradition. Der 31. Starnberger Landkreislauf findet am 8. Oktober in Feldafing statt.',
            'description' => 'Die Organisatoren und Ausrichter des 32. Starnberger Landkreislaufes, der am 8. Oktober in Feldafing im Rahmen der 900-jahrfeiern der Gemeinde stattfindet, haben die drei Teilstrecken besichtigt und deren Verlauf geplant, die jetzt mit der Polizei, Eigentümern und Behörden festgelegt werden. Ab August sind dann die Strecken wieder fürs Training markiert.Die Gesamtstrecke ist circa 42,2 Kilometer lang und gliedert sich in zehn Etappen. Die lange Runde ist 5,6 Kilometer lang und wird dreimal gelaufen. Die kürzeste Strecke hat eine Länge von 3,2 Kilometer und ist viermal zu absolvieren. Die Runden vier bis sechs sind über die mittlere Distanz auf 4,2 Kilometer festgelegt. Insgesamt entspricht dies fast genau der Originalstrecke des Marathonlaufes.Der Start- und Zielbereich ist nicht, wie im Jahr 2011 im Lennè-Park, sondern im Buchheim-Stadion in Feldafing. Damit sind auch größere Steigungen zu bewältigen. Die Strecke führt für alle Teilrunden vom Strandbad Feldafing zum Buchheimstadion. Dort wartet ein Höhenunterschied von etwa 40 Meter, zum Teil über Treppen, auf die Läufer. Alle Teilnehmer der Streckenbesichtigung am Vatertag fanden es aber auch für Kindermannschaften zu schaffen. Vor allem die mittlere Etappe ist anstrengend, weil eine weitere Steigung in Possenhofen dazu kommt.Derzeit verhandeln die Organisatoren noch mit der Stadt München über die Nutzung der Parkplätze beim Paradies in Possenhofen, da um das Stadion in Feldafing zu wenige Parkplätze vorhanden sind. Möglicherweise wird ein Shuttle-Bus zum Stadion eingesetzt.Ab August ist wie in den vergangenen Jahren geplant, die Strecken für das Training zu markieren. Interessierte Läuferinnen und Läufer können sich in Kürze die drei Teilstrecken unter der Internet-Adresse www.landkreislauf-starnberg.de ansehen.',
            'sport_type_id' => 3,
            'start_date' => '2015-10-14 08:00:00',
            'end_date' => '2015-10-14 20:00:00',
        ]);
        array_push($events, $event1);

        array_push($eventParts, factory(App\Models\Event::class)->create([
            'organizer_id' => $organizer->user_id,
            'parent_event_id' => $event1->id,
            'title' => 'Ellwangrunde',
            'description_short' => 'Die längste der drei Runden.',
            'description' => 'Die längste der drei Runden.',
            'sport_type_id' => 3,
            'start_date' => '2015-10-14 08:00:00',
            'end_date' => '2015-10-14 16:00:00',
        ]));

        array_push($eventParts, factory(App\Models\Event::class)->create([
            'organizer_id' => $organizer->user_id,
            'parent_event_id' => $event1->id,
            'title' => 'Wasachrunde',
            'description_short' => 'Die mittlere der drei Runden.',
            'description' => 'Die mittlere der drei Runden.',
            'sport_type_id' => 3,
            'start_date' => '2015-10-14 10:00:00',
            'end_date' => '2015-10-14 17:00:00',
        ]));

        // Landkreislauf Starnberg 2016
        $event2 = factory(App\Models\Event::class)->create([
            'organizer_id' => $organizer->user_id,
            'title' => 'Landkreislauf Starnberg 2016',
            'description_short' => 'Der Landkreislauf ist das größte Breitensportereignis des Landkreises Starnberg und hat eine langjährige Tradition. Der 32. Starnberger Landkreislauf findet am 8. Oktober in Feldafing statt.',
            'description' => 'Die Organisatoren und Ausrichter des 32. Starnberger Landkreislaufes, der am 8. Oktober in Feldafing im Rahmen der 900-jahrfeiern der Gemeinde stattfindet, haben die drei Teilstrecken besichtigt und deren Verlauf geplant, die jetzt mit der Polizei, Eigentümern und Behörden festgelegt werden. Ab August sind dann die Strecken wieder fürs Training markiert.Die Gesamtstrecke ist circa 42,2 Kilometer lang und gliedert sich in zehn Etappen. Die lange Runde ist 5,6 Kilometer lang und wird dreimal gelaufen. Die kürzeste Strecke hat eine Länge von 3,2 Kilometer und ist viermal zu absolvieren. Die Runden vier bis sechs sind über die mittlere Distanz auf 4,2 Kilometer festgelegt. Insgesamt entspricht dies fast genau der Originalstrecke des Marathonlaufes.Der Start- und Zielbereich ist nicht, wie im Jahr 2011 im Lennè-Park, sondern im Buchheim-Stadion in Feldafing. Damit sind auch größere Steigungen zu bewältigen. Die Strecke führt für alle Teilrunden vom Strandbad Feldafing zum Buchheimstadion. Dort wartet ein Höhenunterschied von etwa 40 Meter, zum Teil über Treppen, auf die Läufer. Alle Teilnehmer der Streckenbesichtigung am Vatertag fanden es aber auch für Kindermannschaften zu schaffen. Vor allem die mittlere Etappe ist anstrengend, weil eine weitere Steigung in Possenhofen dazu kommt.Derzeit verhandeln die Organisatoren noch mit der Stadt München über die Nutzung der Parkplätze beim Paradies in Possenhofen, da um das Stadion in Feldafing zu wenige Parkplätze vorhanden sind. Möglicherweise wird ein Shuttle-Bus zum Stadion eingesetzt.Ab August ist wie in den vergangenen Jahren geplant, die Strecken für das Training zu markieren. Interessierte Läuferinnen und Läufer können sich in Kürze die drei Teilstrecken unter der Internet-Adresse www.landkreislauf-starnberg.de ansehen.',
            'sport_type_id' => 3,
            'start_date' => '2016-10-16 08:00:00',
            'end_date' => '2016-10-16 20:00:00',
        ]);
        array_push($events, $event2);

        array_push($eventParts, factory(App\Models\Event::class)->create([
            'organizer_id' => $organizer->user_id,
            'parent_event_id' => $event2->id,
            'title' => 'Ellwangrunde',
            'description_short' => 'Die längste der drei Runden.',
            'description' => 'Die längste der drei Runden.',
            'sport_type_id' => 3,
            'start_date' => '2016-10-16 08:00:00',
            'end_date' => '2016-10-16 16:00:00',
        ]));

        array_push($eventParts, factory(App\Models\Event::class)->create([
            'organizer_id' => $organizer->user_id,
            'parent_event_id' => $event2->id,
            'title' => 'Wasachrunde',
            'description_short' => 'Die mittlere der drei Runden.',
            'description' => 'Die mittlere der drei Runden.',
            'sport_type_id' => 3,
            'start_date' => '2016-10-16 10:00:00',
            'end_date' => '2016-10-16 17:00:00',
        ]));

        foreach ($eventParts as $eventPart) {
            $start_date = $eventPart->start_date;
            $end_date = $eventPart->end_date;
            $register_date = Carbon\Carbon::instance($start_date)->subMonths(rand(12, 1));
            $unregister_date = Carbon\Carbon::instance($start_date)->subDays(rand(2, 4));

            $participationClasses = array();
            array_push($participationClasses, factory(App\Models\ParticipationClass::class)->create([
                'event_id' => $eventPart->id,
                'title' => 'Damen',
                'description' => 'Die Teilnahmeklasse der Frauen',
                'restr_gender' => 'w',
                'restr_birth_date_min' => '1996-10-07 00:00:00',
                'start_date' => $start_date,
                'end_date' => $end_date,
                'register_date' => $register_date,
                'unregister_date' => $unregister_date
            ]));

            array_push($participationClasses, factory(App\Models\ParticipationClass::class)->create([
                'event_id' => $eventPart->id,
                'title' => 'Männer',
                'description' => 'Die Teilnahmeklasse der Männer',
                'restr_gender' => 'm',
                'restr_birth_date_min' => '1996-10-07 00:00:00',
                'start_date' => $start_date,
                'end_date' => $end_date,
                'register_date' => $register_date,
                'unregister_date' => $unregister_date
            ]));

            array_push($participationClasses, factory(App\Models\ParticipationClass::class)->create([
                'event_id' => $eventPart->id,
                'title' => 'Junioren',
                'description' => 'Die Teilnahmeklasse der Junioren',
                'restr_birth_date_max' => '1996-10-08 00:00:00',
                'start_date' => $start_date,
                'end_date' => $end_date,
                'register_date' => $register_date,
                'unregister_date' => $unregister_date
            ]));

            factory(App\Models\VisitClass::class)->create([
                'event_id' => $eventPart->id,
                'title' => 'Standard',
                'description' => 'Die Standard Zuschauer Klasse',
                'register_date' => $register_date,
                'unregister_date' => $unregister_date
            ]);

            factory(App\Models\VisitClass::class)->create([
                'event_id' => $eventPart->id,
                'title' => 'Premium',
                'description' => 'Die Premium Zuschauer Klasse',
                'register_date' => $register_date,
                'unregister_date' => $unregister_date
            ]);

            factory(App\Models\VisitClass::class)->create([
                'event_id' => $eventPart->id,
                'title' => 'VIP',
                'description' => 'Die VIP Zuschauer Klasse',
                'register_date' => $register_date,
                'unregister_date' => $unregister_date
            ]);

            factory(App\Models\CheckPoint::class)->create([
                'event_id' => $eventPart->id,
                'latitude' => 48.03457,
                'longitude' => 11.18289,
                'position' => 1,
                'title' => 'Start',
                'country' => 'Germany',
                'city' => 'Seefeld',
                'postcode' => '82229',
                'street' => 'Schlagenhofener Weg 11'
            ]);

            factory(App\Models\CheckPoint::class)->create([
                'event_id' => $eventPart->id,
                'latitude' => 48.0429227,
                'longitude' => 11.2134583,
                'position' => 2,
                'title' => 'Checkpoint 1',
                'country' => 'Germany',
                'city' => 'Seefeld',
                'postcode' => '82229',
                'street' => 'Mühlbachstraße 25b'
            ]);

            factory(App\Models\CheckPoint::class)->create([
                'event_id' => $eventPart->id,
                'latitude' => 48.0414282,
                'longitude' => 11.1930406,
                'position' => 3,
                'title' => 'Checkpoint 2',
                'country' => 'Germany',
                'city' => 'Seefeld',
                'postcode' => '82229',
                'street' => 'Steinebacher Weg 3'
            ]);

            factory(App\Models\CheckPoint::class)->create([
                'event_id' => $eventPart->id,
                'latitude' => 48.03457,
                'longitude' => 11.18289,
                'position' => 4,
                'title' => 'Ziel',
                'country' => 'Germany',
                'city' => 'Seefeld',
                'postcode' => '82229',
                'street' => 'Schlagenhofener Weg 11'
            ]);
        }

        factory(App\Models\Participation::class, 30)->create();

        factory(App\Models\Visit::class, 30)->create();

        $eventPartIds = \App\Models\Event::select('id')->where('end_date', '<', new DateTime('today'))->get();
        $participationClasses = \App\Models\ParticipationClass::whereIn('event_id', $eventPartIds)->get();
        foreach ($participationClasses as $participationClass) {
            $rank = 0;
            foreach ($participationClass->participations as $participation) {
                $rank++;
                $participation->rank = $rank;
                $participation->participation_state_id = 5;
                $participation->description = $faker->text;
                $participation->save();

                $params = [
                    'rating' => rand(1,5),
                    'description' => $faker->text
                ];
                $event = $participationClass->event;
                if (!$event->hasRater($participation->athlete)) {
                    $event->raters()->attach($participation->athlete->user_id, $params);
                }
            }
        }
    }
}
