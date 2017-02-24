<?php

return [
    'user' => [
        'email'              => [
            'max' => 250
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
            'max' => 250
        ]
    ],

    'athlete' => [
        'title'      => [
            'max' => 250
        ],
        'first_name' => [
            'max' => 250
        ],
        'last_name'  => [
            'max' => 250
        ],
        'slug'       => [
            'max' => 250
        ]
    ],

    'organizer' => [
        'name' => [
            'max' => 250
        ],
        'slug' => [
            'max' => 250
        ]
    ],

    'admin' => [
        'display_name' => [
            'max' => 250
        ],
        'first_name'   => [
            'max' => 250
        ],
        'last_name'    => [
            'max' => 250
        ],
        'slug'         => [
            'max' => 250
        ]
    ],

    'event' => [
        'title'             => [
            'max' => 250
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
            'max' => 250
        ],
        'street'            => [
            'max' => 250
        ],
        'country'           => [
            'max' => 3
        ],
        'postcode'          => [
            'max' => 10
        ],
        'city'              => [
            'max' => 250
        ],
    ],

    'check_point' => [
        'title' => [
            'max' => 250
        ],
        'street'            => [
            'max' => 250
        ],
        'country'           => [
            'max' => 3
        ],
        'postcode'          => [
            'max' => 10
        ],
        'city'              => [
            'max' => 250
        ],
    ],

    'participation_class' => [
        'title' => [
            'max' => 250
        ]
    ],

    'visit_class' => [
        'title' => [
            'max' => 250
        ]
    ],

    'sport_type' => [
        'label' => [
            'max' => 250
        ]
    ],

    'participation_state' => [
        'label' => [
            'max' => 250
        ]
    ]
];
