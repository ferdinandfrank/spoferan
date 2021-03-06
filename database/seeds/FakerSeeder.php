<?php

use Illuminate\Database\Seeder;

/**
 * FakerSeeder
 * -----------------------
 * Fills the database with fake data.
 *
 * @author  Ferdinand Frank
 * @version 1.0
 */
class FakerSeeder extends Seeder {

    /**
     * The faker to create fake data.
     *
     * @var Faker\Generator
     */
    private $faker;

    /**
     * The password for each created fake user.
     *
     * @var string
     */
    public static $USER_PASSWORD = 'password';


    /**
     * Creates a new FakerSeeder instance and makes sure the necessary vars are initialized.
     */
    public function __construct() {
        $this->faker = Faker\Factory::create();
    }

    /**
     * Runs the database seeds.
     */
    public function run() {
        $this->createCoupons();
        $this->createRandomUsers();
        $this->createRandomEvents();

        $this->createUsableAthlete('athlete@example.com', 'John', 'Doe');
        $organizer = $this->createUsableOrganizer('organizer@example.com', 'Landkreis Starnberg');
        $teamSportOrganizer = $this->createUsableOrganizer('teamsport-organizer@example.com', 'MasterSports');

        $eventGroup = $this->createUsableEventGroup('Landkreis Starnberg');
        $event = $this->createFullRealEvent($organizer, \Carbon\Carbon::create(2015, 10, 14), $eventGroup);
        $event = $this->createFullRealEvent($organizer, \Carbon\Carbon::create(2016, 10, 14), $eventGroup, $event);
        $this->createFullRealEvent($organizer, \Carbon\Carbon::create(2017, 10, 14), $eventGroup, $event);

        $this->createFullRealTeamSportEvent($teamSportOrganizer, \Carbon\Carbon::create(2017, 9, 14), "Basketmasters", [
            'sport_type_id' => 8,
            'state'         => 'DE-BY',
            'country'       => 'DE',
            'postcode'      => '94036',
            'city'          => 'Passau',
            'street'        => 'Dr.-Emil-Brichta-Straße 11',
        ]);
        $this->createFullRealTeamSportEvent($teamSportOrganizer, \Carbon\Carbon::create(2017, 9, 21), "Soccermasters", [
            'sport_type_id' => 9,
            'state'         => 'DE-BY',
            'country'       => 'DE',
            'postcode'      => '94036',
            'city'          => 'Passau',
            'street'        => 'Dr.-Emil-Brichta-Straße 11',
        ]);

        $this->simulateAthleteActivity();
    }

    public function createFullRealTeamSportEvent(
        \App\Models\Organizer $organizer, \Carbon\Carbon $date, $title, $extraData = []
    ) {
        $title = $title . ' ' . $date->year;
        $date->setTime(8, 0);

        $event = factory(App\Models\Event::class)->create(array_merge([
            'organizer_id' => $organizer->user_id,
            'title'        => $title,
            'start_date'   => $date->toDateTimeString(),
            'end_date'     => $date->addHours(12)->toDateTimeString(),
        ], $extraData));

        $this->createRealParticipationClass($event, 'Frauen');

        $this->createRealParticipationClass($event, 'Männer');

        $this->createRealParticipationClass($event, 'Jugend');

        $this->createRealParticipationClass($event, 'Kinder');

        $this->createRealVisitClass($event, 'Standard');
        $this->createRealVisitClass($event, 'Premium');
        $this->createRealVisitClass($event, 'VIP');
    }

    public function createFullRealEvent(
        \App\Models\Organizer $organizer, \Carbon\Carbon $date, \App\Models\EventGroup $eventGroup = null,
        \App\Models\Event $preEvent = null,
        $title = 'Landkreislauf Starnberg'
    ) {
        $title = $title . ' ' . $date->year;
        $date->setTime(8, 0);

        $event = factory(App\Models\Event::class)->create([
            'organizer_id'      => $organizer->user_id,
            'event_group_id'    => $eventGroup ? $eventGroup->id : null,
            'pre_event_id'      => $preEvent ? $preEvent->id : null,
            'title'             => $title,
            'description_short' => 'Der Landkreislauf ist das größte Breitensportereignis des Landkreises Starnberg und hat eine langjährige Tradition. Der 31. Starnberger Landkreislauf findet am 8. Oktober in Feldafing statt.',
            'description'       => 'Die Organisatoren und Ausrichter des 32. Starnberger Landkreislaufes, der am 8. Oktober in Feldafing im Rahmen der 900-jahrfeiern der Gemeinde stattfindet, haben die drei Teilstrecken besichtigt und deren Verlauf geplant, die jetzt mit der Polizei, Eigentümern und Behörden festgelegt werden. Ab August sind dann die Strecken wieder fürs Training markiert.Die Gesamtstrecke ist circa 42,2 Kilometer lang und gliedert sich in zehn Etappen. Die lange Runde ist 5,6 Kilometer lang und wird dreimal gelaufen. Die kürzeste Strecke hat eine Länge von 3,2 Kilometer und ist viermal zu absolvieren. Die Runden vier bis sechs sind über die mittlere Distanz auf 4,2 Kilometer festgelegt. Insgesamt entspricht dies fast genau der Originalstrecke des Marathonlaufes.Der Start- und Zielbereich ist nicht, wie im Jahr 2011 im Lennè-Park, sondern im Buchheim-Stadion in Feldafing. Damit sind auch größere Steigungen zu bewältigen. Die Strecke führt für alle Teilrunden vom Strandbad Feldafing zum Buchheimstadion. Dort wartet ein Höhenunterschied von etwa 40 Meter, zum Teil über Treppen, auf die Läufer. Alle Teilnehmer der Streckenbesichtigung am Vatertag fanden es aber auch für Kindermannschaften zu schaffen. Vor allem die mittlere Etappe ist anstrengend, weil eine weitere Steigung in Possenhofen dazu kommt.Derzeit verhandeln die Organisatoren noch mit der Stadt München über die Nutzung der Parkplätze beim Paradies in Possenhofen, da um das Stadion in Feldafing zu wenige Parkplätze vorhanden sind. Möglicherweise wird ein Shuttle-Bus zum Stadion eingesetzt.Ab August ist wie in den vergangenen Jahren geplant, die Strecken für das Training zu markieren. Interessierte Läuferinnen und Läufer können sich in Kürze die drei Teilstrecken unter der Internet-Adresse www.landkreislauf-starnberg.de ansehen.',
            'sport_type_id'     => 3,
            'start_date'        => $date->toDateTimeString(),
            'end_date'          => $date->addHours(12)->toDateTimeString(),
            'state'             => 'DE-BY',
            'country'           => 'DE',
            'postcode'          => '82229',
            'city'              => 'Seefeld',
            'street'            => 'Schlagenhofener Weg 11',
        ]);

        $eventParts = [];
        array_push($eventParts, $this->createRealChildEvent($event, 'Ellwangrunde'));
        array_push($eventParts, $this->createRealChildEvent($event, 'Wasachrunde'));

        foreach ($eventParts as $eventPart) {

            $this->createRealParticipationClass($eventPart, 'Frauen');

            $this->createRealParticipationClass($eventPart, 'Männer');

            $this->createRealParticipationClass($eventPart, 'Jugend');

            $this->createRealParticipationClass($eventPart, 'Kinder');

            $this->createRealVisitClass($eventPart, 'Standard');
            $this->createRealVisitClass($eventPart, 'Premium');
            $this->createRealVisitClass($eventPart, 'VIP');

            factory(App\Models\CheckPoint::class)->create([
                'event_id'  => $eventPart->id,
                'latitude'  => 48.03457,
                'longitude' => 11.18289,
                'position'  => 1,
                'title'     => 'Start',
                'country'   => 'DE',
                'city'      => 'Seefeld',
                'postcode'  => '82229',
                'street'    => 'Schlagenhofener Weg 11'
            ]);

            factory(App\Models\CheckPoint::class)->create([
                'event_id'  => $eventPart->id,
                'latitude'  => 48.0429227,
                'longitude' => 11.2134583,
                'position'  => 2,
                'title'     => 'Checkpoint 1',
                'country'   => 'DE',
                'city'      => 'Seefeld',
                'postcode'  => '82229',
                'street'    => 'Mühlbachstraße 25b'
            ]);

            factory(App\Models\CheckPoint::class)->create([
                'event_id'  => $eventPart->id,
                'latitude'  => 48.0414282,
                'longitude' => 11.1930406,
                'position'  => 3,
                'title'     => 'Checkpoint 2',
                'country'   => 'DE',
                'city'      => 'Seefeld',
                'postcode'  => '82229',
                'street'    => 'Steinebacher Weg 3'
            ]);

            factory(App\Models\CheckPoint::class)->create([
                'event_id'  => $eventPart->id,
                'latitude'  => 48.03457,
                'longitude' => 11.18289,
                'position'  => 4,
                'title'     => 'Ziel',
                'country'   => 'DE',
                'city'      => 'Seefeld',
                'postcode'  => '82229',
                'street'    => 'Schlagenhofener Weg 11'
            ]);
        }

        return $event;
    }

    public function createRealChildEvent(\App\Models\Event $parentEvent, $title = null) {
        $title = $title ?? $this->faker->domainWord . 'runde';

        return factory(App\Models\Event::class)->create([
            'organizer_id'      => $parentEvent->organizer_id,
            'event_group_id'    => $parentEvent->event_group_id,
            'parent_event_id'   => $parentEvent->id,
            'title'             => $title,
            'description_short' => "$title ist ein Teil von $parentEvent->title.",
            'sport_type_id'     => $parentEvent->sport_type_id,
            'start_date'        => $parentEvent->start_date->toDateTimeString(),
            'end_date'          => $parentEvent->end_date->toDateTimeString(),
            'country'           => $parentEvent->country,
            'postcode'          => $parentEvent->postcode,
            'city'              => $parentEvent->city,
            'street'            => $parentEvent->street,
        ]);
    }

    public function createRealParticipationClass(\App\Models\Event $event, $title) {
        $start_date = $event->start_date;
        $end_date = $event->end_date;

        $register_date = Carbon\Carbon::instance($start_date)->subMonths(rand(1, 11));
        $unregister_date = Carbon\Carbon::instance($start_date)->subDays(rand(2, 27));

        $restr_birth_date_min = $event->start_date->subYears(18);
        $restr_birth_date_max = null;
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

        return factory(App\Models\ParticipationClass::class)->create([
            'event_id'             => $event->id,
            'title'                => $title,
            'description'          => "Die Teilnahmeklasse für $title. Hier dürfen ausschließlich $title teilnehmen, um einen fairen Wettkampf zu garantieren. Bitte beachte zudem die weiteren Teilnahmebeschränkungen.",
            'restr_gender'         => $gender,
            'restr_birth_date_min' => $restr_birth_date_min,
            'restr_birth_date_max' => $restr_birth_date_max,
            'start_date'           => $start_date,
            'end_date'             => $end_date,
            'register_date'        => $register_date,
            'unregister_date'      => $unregister_date,
        ]);
    }

    public function createRealVisitClass(\App\Models\Event $event, $title) {
        $start_date = $event->start_date;
        $register_date = Carbon\Carbon::instance($start_date)->subMonths(rand(12, 1));
        $unregister_date = Carbon\Carbon::instance($start_date)->subDays(rand(2, 4));

        return factory(App\Models\VisitClass::class)->create([
            'event_id'        => $event->id,
            'title'           => $title,
            'description'     => "Das $title Zuschauer Paket. In diesem Paket sind die folgenden Leistungen enthalten: "
                                 . $this->faker->text(),
            'register_date'   => $register_date,
            'unregister_date' => $unregister_date
        ]);
    }

    public function createCoupons() {
        factory(App\Models\Coupon::class, 5)->create();
        factory(App\Models\Coupon::class)->create([
            'code'            => 'TESTCOUPON',
            'creator_id'      => null,
            'event_id'        => null,
            'amount_off'      => null,
            'percent_off'     => 45,
            'redeem_start'    => null,
            'redeem_end'      => null,
            'type'            => 'participation',
            'max_redemptions' => 80,
            'times_redeemed'  => 0,
            'valid'           => true
        ]);
    }

    public function createRandomUsers() {
        factory(App\Models\Athlete::class, 100)->create();
        factory(App\Models\Organizer::class, 30)->create();
    }

    public function createRandomEvents() {
        factory(App\Models\Event::class, 30)->create()->each(function ($event) {
            $event->checkPoints()->save(factory(App\Models\CheckPoint::class)->make());

            $start_date = $event->start_date;
            $end_date = $event->end_date;

            factory(App\Models\ParticipationClass::class, rand(1, 3))->create([
                'event_id'        => $event->id,
                'start_date'      => $start_date,
                'end_date'        => $end_date,
                'register_date'   => Carbon\Carbon::instance($start_date)->subMonths(rand(12, 1)),
                'unregister_date' => Carbon\Carbon::instance($start_date)->subDays(rand(2, 27)),
            ]);

            $event->labels()->attach(\App\Models\Label::orderByRaw("RAND()")->limit(2)->get()->pluck('id'));
        });
    }

    public function createUsableAthlete($email, $firstName = null, $lastName = null) {
        $user = factory(App\Models\User::class)->create([
            'current_user_type' => config('spoferan.user_type.athlete'),
            'email'             => $email,
            'password'          => self::$USER_PASSWORD,
            'verified'          => true
        ]);

        $user->contact()->update([
            'state'    => 'DE-BY',
            'country'  => 'DE',
            'postcode' => '94032',
            'city'     => 'Passau',
            'street'   => 'Innstraße 42'
        ]);

        return factory(App\Models\Athlete::class)->create([
            'user_id'    => $user->id,
            'first_name' => $firstName ?? $this->faker->firstNameMale,
            'last_name'  => $lastName ?? $this->faker->lastName,
            'gender'     => 'm'
        ]);
    }


    public function createUsableOrganizer($email, $name = null) {
        $organizerUser = factory(App\Models\User::class)->create([
            'current_user_type' => config('spoferan.user_type.organizer'),
            'email'             => $email,
            'password'          => self::$USER_PASSWORD,
            'verified'          => true
        ]);

        $organizer = factory(App\Models\Organizer::class)->create([
            'user_id' => $organizerUser->id,
            'name'    => $name ?? $this->faker->company,
        ]);

        for ($i = 0; $i < 10; $i++) {
            $raterId = \App\FactoryHelper::getRandomOrCreate(\App\Models\Athlete::class)->id;
            $params = [
                'rating'      => rand(1, 5),
                'description' => $this->faker->text
            ];
            $organizer->raters()->attach($raterId, $params);
        }

        return $organizer;
    }

    public function createUsableEventGroup($title = null) {
        $eventGroup = factory(App\Models\EventGroup::class)->create([
            'title' => $title ?? $this->faker->domainWord,
        ]);

        return $eventGroup;
    }

    public function simulateAthleteActivity() {
        factory(App\Models\Participation::class, 150)->create();
        factory(App\Models\Visit::class, 30)->create();

        $eventPartIds = \App\Models\Event::select('id')->where('end_date', '<', new DateTime('today'))->get();
        $participationClasses = \App\Models\ParticipationClass::whereIn('event_id', $eventPartIds)->get();
        foreach ($participationClasses as $participationClass) {
            $rank = 0;
            foreach ($participationClass->participations as $participation) {
                $rank++;
                $participation->rank = $rank;
                $participation->participation_state_id = 5;
                $participation->save();

                $params = [
                    'rating'      => rand(1, 5),
                    'description' => $this->faker->text
                ];
                $event = $participationClass->event;
                if ($event->isChild()) {
                    $event = $event->parentEvent;
                }
                if (!$event->hasRater($participation)) {
                    $event->raters()->attach($participation->id, $params);
                }
            }
        }
    }
}
