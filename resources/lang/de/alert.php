<?php

return [

    'error' => [
        'delete' => [
            'title'   => 'Löschen fehlgeschlagen',
            'content' => 'Beim Löschen von :name ist ein Fehler aufgetreten. Versuche es noch einmal.'
        ],
        'post'   => [
            'title'   => 'Sorry!',
            'content' => 'Beim Speichern ist ein Fehler aufgetreten. Versuche es noch einmal.'
        ],
        'put'    => [
            'title'   => 'Sorry!',
            'content' => 'Beim Aktualisieren von :name ist ein Fehler aufgetreten. Versuche es noch einmal.'
        ]
    ],

    'default' => [
        'delete' => [
            'title'   => 'Gelöscht!',
            'content' => ':name wurde erfolgreich gelöscht.'
        ],
        'post'   => [
            'title'   => 'Gespeichert!',
            'content' => 'Dein Objekt wurde erfolgreicht erstellt.'
        ],
        'put'    => [
            'title'   => 'Gespeichert!',
            'content' => ':name wurde erfolgreich aktualisiert.'
        ]
    ],

    'registration' => [
        'post' => [
            'title'   => 'Account bestätigen!',
            'content' => 'Wir haben dir eine E-Mail an deine E-Mail-Adresse gesendet. Bitte klicke auf den darin enthaltenen Link, um deinen Account und deine E-Mail-Adresse zu bestätigen.'
        ]
    ],

    'account_confirmed' => [
        'title'   => 'Account bestätigt!',
        'content' => 'Dein Account und deine E-Mail-Adresse wurde erfolgreich bestätigt. Du kannst dich nun einloggen.',
    ],

    'password_reset' => [
        'post' => [
            'title'   => 'Passwort zurückgesetzt',
            'content' => 'Dein Passwort wurde erfolgreich zurückgesetzt.'
        ]
    ],

    'password_forgot' => [
        'post' => [
            'title'   => 'E-Mail gesendet!',
            'content' => 'Wir haben dir eine E-Mail zum Zurücksetzen deines Passworts zugeschickt.'
        ]
    ],

    'participation_payed' => [
        'post' => [
            'title'   => 'Erfolgreich angemeldet!',
            'content' => 'Du hast dich erfolgreich für das Event angemeldet.'
        ]
    ],

];