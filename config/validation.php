<?php

return [
    'user' => [
        'email'              => [
            'max' => 190
        ],
        'password'           => [
            'max' => 250,
            'min' => 6
        ],
        'street'             => [
            'max' => 250
        ],
        'country'            => [
            'max' => 3
        ],
        'postcode'           => [
            'max' => 10
        ],
        'city'               => [
            'max' => 250
        ],
        'phone'              => [
            'max' => 250
        ],
        'confirmation_token' => [
            'max' => 190
        ]
    ],

    'athlete' => [
        'title'      => [
            'max' => 10
        ],
        'first_name' => [
            'max' => 80
        ],
        'last_name'  => [
            'max' => 100
        ],
        'slug'       => [
            'max' => 190
        ],
        'starter_number' => [
            'max' => 10
        ]
    ],

    'organizer' => [
        'name' => [
            'max' => 150
        ],
        'slug' => [
            'max' => 190
        ]
    ],

    'admin' => [
        'display_name' => [
            'max' => 185
        ],
        'first_name'   => [
            'max' => 80
        ],
        'last_name'    => [
            'max' => 100
        ],
        'slug'         => [
            'max' => 190
        ]
    ],

    'event' => [
        'title'             => [
            'max' => 150
        ],
        'description_short' => [
            'max' => 250
        ],
        'email'             => [
            'max' => 250
        ],
        'phone'             => [
            'max' => 250
        ],
        'slug'              => [
            'max' => 190
        ],
        'street'            => [
            'max' => 250
        ],
        'country'           => [
            'max' => 3
        ],
        'state'             => [
            'max' => 10
        ],
        'postcode'          => [
            'max' => 10
        ],
        'city'              => [
            'max' => 250
        ],
    ],

    'check_point' => [
        'title'    => [
            'max' => 250
        ],
        'street'   => [
            'max' => 250
        ],
        'country'  => [
            'max' => 3
        ],
        'postcode' => [
            'max' => 10
        ],
        'city'     => [
            'max' => 250
        ],
    ],

    'participation_class' => [
        'title' => [
            'max' => 150
        ]
    ],

    'visit_class' => [
        'title' => [
            'max' => 150
        ]
    ],

    'sport_type' => [
        'label' => [
            'max' => 190
        ],
        'slug' => [
            'max' => 190
        ]
    ],

    'participation_state' => [
        'label' => [
            'max' => 190
        ]
    ],

    'settings' => [
        'key' => [
            'max' => 50
        ]
    ]
];
