<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted'             => 'The :attribute must be accepted.',
    'active_url'           => 'The :attribute is not a valid URL.',
    'after'                => 'The :attribute must be a date after :date.',
    'after_or_equal'       => 'The :attribute must be a date after or equal to :date.',
    'alpha'                => 'The :attribute may only contain letters.',
    'alpha_dash'           => 'The :attribute may only contain letters, numbers, and dashes.',
    'alpha_num'            => 'The :attribute may only contain letters and numbers.',
    'array'                => 'The :attribute must be an array.',
    'before'               => 'The :attribute must be a date before :date.',
    'before_or_equal'      => 'The :attribute must be a date before or equal to :date.',
    'between'              => [
        'numeric' => 'The :attribute must be between :min and :max.',
        'file'    => 'The :attribute must be between :min and :max kilobytes.',
        'string'  => 'The :attribute must be between :min and :max characters.',
        'array'   => 'The :attribute must have between :min and :max items.',
    ],
    'boolean'              => 'The :attribute field must be true or false.',
    'confirmed'            => 'Die Eingabe stimmt mit der :attribute Eingabe nicht überein.',
    'date'                 => 'The :attribute is not a valid date.',
    'date_format'          => 'The :attribute does not match the format :format.',
    'different'            => 'The :attribute and :other must be different.',
    'digits'               => 'The :attribute must be :digits digits.',
    'digits_between'       => 'The :attribute must be between :min and :max digits.',
    'dimensions'           => 'The :attribute has invalid image dimensions.',
    'distinct'             => 'The :attribute field has a duplicate value.',
    'email'                => 'Bitte gebe eine gültige E-Mail-Adresse ein.',
    'exists'               => 'The selected :attribute is invalid.',
    'file'                 => 'The :attribute must be a file.',
    'filled'               => 'The :attribute field is required.',
    'image'                => 'The :attribute must be an image.',
    'in'                   => 'The selected :attribute is invalid.',
    'in_array'             => 'The :attribute field does not exist in :other.',
    'integer'              => 'The :attribute must be an integer.',
    'ip'                   => 'The :attribute must be a valid IP address.',
    'json'                 => 'The :attribute must be a valid JSON string.',
    'max'                  => [
        'numeric' => 'The :attribute may not be greater than :max.',
        'file'    => 'The :attribute may not be greater than :max kilobytes.',
        'string'  => 'Bitte gebe max. :max Zeichen ein.',
        'array'   => 'The :attribute may not have more than :max items.',
    ],
    'mimes'                => 'The :attribute must be a file of type: :values.',
    'mimetypes'            => 'The :attribute must be a file of type: :values.',
    'min'                  => [
        'numeric' => 'The :attribute must be at least :min.',
        'file'    => 'The :attribute must be at least :min kilobytes.',
        'string'  => 'Bitte gebe mind. :min Zeichen ein.',
        'array'   => 'The :attribute must have at least :min items.',
    ],
    'not_in'               => 'The selected :attribute is invalid.',
    'numeric'              => 'The :attribute must be a number.',
    'present'              => 'The :attribute field must be present.',
    'regex'                => 'The :attribute format is invalid.',
    'required'             => 'Bitte fülle dieses Feld aus.',
    'required_if'          => 'The :attribute field is required when :other is :value.',
    'required_unless'      => 'The :attribute field is required unless :other is in :values.',
    'required_with'        => 'The :attribute field is required when :values is present.',
    'required_with_all'    => 'The :attribute field is required when :values is present.',
    'required_without'     => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same'                 => 'The :attribute and :other must match.',
    'size'                 => [
        'numeric' => 'The :attribute must be :size.',
        'file'    => 'The :attribute must be :size kilobytes.',
        'string'  => 'Bitte gebe mind. :size Zeichen ein.',
        'array'   => 'The :attribute must contain :size items.',
    ],
    'string'               => 'The :attribute must be a string.',
    'timezone'             => 'The :attribute must be a valid zone.',
    'unique'               => ':attribute wird bereits verwendet.',
    'uploaded'             => 'The :attribute failed to upload.',
    'url'                  => 'The :attribute format is invalid.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'email' => [
            'unique' => 'Die E-Mail-Adresse wird bereits verwendet.',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap attribute place-holders
    | with something more reader friendly such as E-Mail Address instead
    | of "email". This simply helps us make messages a little cleaner.
    |
    */

    'attributes' => [],

    'auth' => [
        'failed' => 'Deine E-Mail-Adresse oder dein Passwort ist inkorrekt.',
    ],

    'event' => [
        'title'             => [
            'required' => 'Gebe deinem Event einen Namen.'
        ],
        'description_short' => [
            'required' => 'Gebe eine Kurzbeschreibung für dein Event ein.'
        ],
        'description'       => [
            'required' => 'Gebe eine Beschreibung für dein Event ein.'
        ],
        'sport_type_id'     => [
            'required' => 'Wähle die Sportart deines Events aus.'
        ],
        'email'             => [
            'required_without' => 'Bitte gebe entweder eine Email-Adresse oder eine Telefonnummer an.'
        ],
        'phone'             => [
            'required_without' => 'Bitte gebe entweder eine Email-Adresse oder eine Telefonnummer an.'
        ],
        'start_date'        => [
            'required' => 'Gebe an, wann das Event beginnen soll.',
            'after'    => 'Das Event darf frühestens morgen beginnen.'
        ],
        'end_date'          => [
            'required' => 'Gebe an, wann das Event enden soll.'
        ],

        'restr_registered'            => 'Melde dich an, um an diesem Event teilzunehmen.',
        'restr_athlete'               => 'Du musst als Athlet angemeldet sein, um an diesem Event teilzunehmen.',
        'restr_register_date'         => 'Du kannst dich für dieses Event noch nicht anmelden. Weitere Information zum Anmeldestart des Events erhälst du bei den Teilnahmeklassen des Events.',
        'restr_unregister_date'       => 'Der Anmeldezeitraum dieses Events ist bereits abgelaufen.',
        'restr_participation_classes' => 'Du kannst an diesem Event nicht teilnehmen, da keine Teilnahmeklasse existiert, in der du dich anmelden kannst.',
        'restr_active'                => 'Das Event ist momentan aktiv.',
        'restr_finished'              => 'Das Event ist bereits vorbei.',

        'participate' => [
            'restr_registration_paused' => 'Die Registrierungsphase wurde unterbrochen. Eine Anmeldung ist erst wieder möglich, wenn der Veranstalter die Registrierungsphase wieder fortgesetzt hat.',
            'restr_limit'               => 'Die Teilnahmeklasse ist bereits voll. Eine Anmeldung ist nicht mehr möglich.',
            'restr_birth_date_min'      => 'Für diese Teilnahmeklasse bist du zu jung.',
            'restr_birth_date_max'      => 'Für diese Teilnahmeklasse bist du zu alt.',
            'restr_gender_female'       => 'Nur Frauen dürfen in dieser Teilnahmeklasse teilnehmen.',
            'restr_gender_male'         => 'Nur Männer dürfen in dieser Teilnahmeklasse teilnehmen.',
            'restr_label_id'            => 'Für diese Teilnahmeklasse brauchst du das Label :label.',
            'restr_club_id'             => 'Für diese Teilnahmeklasse musst du Mitglied in dem Club :club sein.',
            'restr_country'             => 'Für diese Teilnahmeklasse musst du aus :country kommen.',
            'restr_postcode'                => 'Für diese Teilnahmeklasse musst du aus der Stadt mit der Postleitzahl :postcode kommen.',
            'multiple_starts_this'      => 'Um an dem Event in dieser Kategorie teilzunehmen, darfst du in keiner anderen Teilnahmeklasse starten.',
            'multiple_starts_other'     => 'Du bist bereits in einer Teilnahmeklasse angemeldet, die einen weiteren Start in dieser Teilnahmeklasse nicht erlaubt.',
            'club_participants_limit'   => 'Ees ist bereits die maximale Anzahl aus deinem Club für diese Kategorie angemeldet.',
            'restr_creator'             => 'Du bist der Veranstalter von diesem Event und kannst deshalb nicht selber daran teilnehmen.',
            'already_registered'        => 'Du bist für das Event in dieser Teilnahmeklasse bereits registriert.',
            'restr_registered'          => 'Melde dich an, um in dieser Teilnahmeklasse teilzunehmen.',
            'restr_athlete'             => 'Du musst als Athlet angemeldet sein, um in dieser Teilnahmeklasse teilzunehmen.',
            'restr_register_date'       => 'Du kannst dich erst ab dem :date um :time Uhr in dieser Teilnahmeklasse anmelden.',
            'restr_unregister_date'     => 'Du konntest dich nur bis zum :date um :time Uhr in dieser Teilnahmeklasse anmelden.'
        ],
        'visit'       => [
            'restr_registration_paused' => 'Die Verkaufsphase wurde unterbrochen. Ein Erwerb ist erst wieder möglich, wenn der Veranstalter die Verkaufsphase wieder fortgesetzt hat.',
            'restr_limit'               => 'Es wurden bereits alle Tickets für dieses Besucherpaket verkauft.',
            'restr_creator'             => 'Du bist der Veranstalter von diesem Event und kannst deshalb dieses Besucherpaket nicht selber erwerben.',
            'already_registered'        => 'Du hast dieses Besucherpaket bereits erworben.',
            'restr_registered'          => 'Melde dich an, um dieses Besucherpaket zu erwerben.',
            'restr_athlete'             => 'Du musst als Athlet angemeldet sein, um dieses Besucherpaket zu erwerben.',
            'restr_register_date'       => 'Du kannst dieses Besucherpaket erst ab dem :date um :time Uhr erwerben.',
            'restr_unregister_date'     => 'Du konntest dieses Besucherpaket nur bis zum :date um :time Uhr erwerben.'
        ]
    ],

    'credit_card' => [
        'invalid_number'       => 'Die eingegebene Kartennummer ist ungültig.',
        'invalid_expiry_month' => 'Der eingegebene Ablaufmonat ist ungültig.',
        'invalid_expiry_year'  => 'Der eingegebene Ablaufmonat ist ungültig.',
        'invalid_cvc'          => 'Die eingegebene Kartenprüfnummer ist ungültig.',
        'invalid_swipe_data'   => 'Der Swipe Daten der eingegebenen Karte ist ungültig.',
        'incorrect_number'     => 'Der eingegebene Kartennummer ist inkorrekt.',
        'expired_card'         => 'Die eingegebene Karte ist bereits abgelaufen.',
        'incorrect_cvc'        => 'Die eingegebene Kartenprüfnummer ist inkorrekt.',
        'incorrect_zip'        => 'Der eingegebene Postleitzahl stimmt nicht mit der Karte überein.',
        'card_declined'        => 'Die eingegebene Karte wurde abgelehnt.',
        'missing'              => 'Es existiert keine Karte in deinem Profil, mit welcher bezahlt werden kann.',
        'processing_error'     => 'Ein Fehler ist während der Verarbeitung aufgetreten. Bitte versuche es noch einmal.'
    ],

    'coupon' => 'Dieser Gutscheincode existiert nicht oder ist nicht mehr gültig.'

];
