<?php

return [

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