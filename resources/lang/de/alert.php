<?php

return [

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

    'user' => [
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

    'participation' => [
        'post' => [
            'title'   => 'Erfolgreich angemeldet!',
            'content' => 'Du hast dich erfolgreich für das Event angemeldet.'
        ],

        'delete' => [
            'title'   => 'Anmeldung erfolgreich storniert!',
            'content' => 'Deine Anmeldung bei dem Event :name wurde erfolgreich storniert. Die bereits gezahlte Teilnahmegebühr wurde dir auf deinem Konto gut geschrieben.'
        ]
    ],

    'credit_card' => [
        'post' => [
            'title'   => 'Kreditkarte hinzugefügt',
            'content' => 'Die Kreditkarte wurde deinem Account erfolgreich hinzugefügt.'
        ]
    ],

    'bank_account' => [
        'post' => [
            'title'   => 'Bankeinzugskonto hinzugefügt',
            'content' => 'Das Bankeinzugskonto wurde deinem Account erfolgreich hinzugefügt.'
        ]
    ],
];