<?php

return [

    /*
    |--------------------------------------------------------------------------
    | User Types
    |--------------------------------------------------------------------------
    | Defines the database keys of the valid and available user types of the application.
    |
    */

    'user_type'        => [
        'athlete'   => 'athlete',
        'organizer' => 'organizer',
        'trainer'   => 'trainer',
        'company'   => 'company',
        'admin'     => 'admin',
    ],

    /*
    |--------------------------------------------------------------------------
    | General Error Key
    |--------------------------------------------------------------------------
    | The key name of json server responses with errors that occured on the server.
    |
    */
    'server_error_key' => 'server',
];
