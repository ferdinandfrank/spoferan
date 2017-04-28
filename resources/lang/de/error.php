<?php

return [

    /*
    |--------------------------------------------------------------------------
    | General error messages
    |--------------------------------------------------------------------------
    |
    |
    */

    'throttle'    => 'Zu viele Versuche. Bitte versuche es in :seconds Sekunden erneut.',
    'unconfirmed' => 'Dein Account wurde noch nicht bestätigt. Wir haben dir nochmals eine E-Mail an :email gesendet. Bitte klicke auf den darin enthaltenen Link, um deinen Account zu bestätigen.',


    /*
    |--------------------------------------------------------------------------
    | Alert error messages
    |--------------------------------------------------------------------------
    | Error messages which will be shown within a alert. The first key defines the 'alert-key' i.e. the
    | circumstances of the alert to show. The second key defines the request method.
    |
    */

    'default' => [
        'delete' => [
            'title'   => 'Löschen fehlgeschlagen',
            'content' => 'Beim Löschen von :name ist ein Fehler aufgetreten. Bitte versuche es noch einmal.'
        ],
        'post'   => [
            'title'   => 'Sorry!',
            'content' => 'Beim Speichern ist ein Fehler aufgetreten. Bitte versuche es noch einmal.'
        ],
        'put'    => [
            'title'   => 'Sorry!',
            'content' => 'Beim Aktualisieren von :name ist ein Fehler aufgetreten. Bitte versuche es noch einmal.'
        ]
    ],

    'participation' => [
        'delete' => [
            'title'   => 'Stornieren fehlgeschlagen',
            'content' => 'Beim Stornieren deiner Anmeldung beim Event :name ist ein Fehler aufgetreten. Bitte versuche es noch einmal.'
        ]
    ],

    'user' => [
        'post' => [
            'title'   => 'Registrieren fehlgeschlagen',
            'content' => 'Beim Registrieren ist ein unbekannter Fehler aufgetreten. Bitte versuche es noch einmal.'
        ]
    ]
];