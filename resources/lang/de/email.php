<?php

return [

    'greeting'       => 'Hallo :name',
    'greeting_plain' => 'Hallo',
    'salutation'     => 'Viele Grüße',
    'any_questions'  => 'Du hast Fragen oder benötigst Hilfe?',

    'button_help' => 'Falls du Probleme hast den ":button" Button zu klicken, kopiere den folgenden Link und füge ihn in deinen Browser ein',

    'contact' => [
        'title' => 'Neue Kontaktnachricht über die Website',
    ],

    'test' => [
        'subject'        => 'Test-E-Mail von :title',
        'title'          => 'Hier steht der Titel der E-Mail!',
        'content'        => 'hier steht der Hauptinhalt der E-Mail, welcher dem Empfänger wichtige Informationen mitteilt, wie etwa eine Registrierungs- oder Zahlungsbestätigung. Dieser kann zusätzlich dynamische Daten über Benutzer von :title enthalten.',
        'receiving_info' => 'Du erhälst diese E-Mail, weil auf :title eine Test-E-Mail angefordert wurde.'
    ],

    'registration' => [
        'subject'        => 'Deine Registrierung bei :title',
        'title'          => 'Vielen Dank für deine Registrierung!',
        'content'        => 'vielen Dank für deine Registrierung als :user_type bei :title. Bitte klicke auf den folgenden Button, um deine E-Mail-Adresse und damit deinen Account zu bestätigen. Bitte beachte, dass du dich erst bei :title anmelden kannst, nachdem du deinen Account bestätigt hast.',
        'salutation'     => 'Wir wünschen dir viel Spaß',
        'receiving_info' => 'Du erhälst diese E-Mail, weil du dich auf der Seite :title registriert hast. Sollte diese Aktion nicht von dir selber getätigt worden sein, so kannst du diese E-Mail ignorieren.'
    ],

    'password_reset' => [
        'title'   => 'Dein neues Passwort auf Spoferan',
        'content' => 'du hast soeben ein neues Passwort für deinen Account bei :title angefragt. Klicke auf den folgenden Button, um dein Passwort zurückzusetzen. Solltest du nicht um eine Zurücksetzung deines Passworts gebeten haben, so kannst du diese E-Mail ignorieren.'
    ],

];
