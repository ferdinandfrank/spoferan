<?php

return [
    'email'              => [
        'max' => 190
    ],
    'password'           => [
        'max' => 100,
        'min' => 6
    ],
    'street'             => [
        'max' => 60
    ],
    'user_type'             => [
        'max' => 10
    ],
    'state'             => [
        'max' => 10
    ],
    'country'            => [
        'max' => 3
    ],
    'postcode'           => [
        'max' => 20
    ],
    'city'               => [
        'max' => 60
    ],
    'phone'              => [
        'max' => 30
    ],
    'confirmation_token' => [
        'max' => 190
    ],
    'slug'       => [
        'max' => 190
    ],
    'facebook'              => [
        'max' => 50
    ],
    'twitter'              => [
        'max' => 20
    ],
    'youtube'              => [
        'max' => 20
    ],
    'instagram'              => [
        'max' => 30
    ],
    'snapchat'              => [
        'max' => 30
    ],
    'starter_number' => [
        'max' => 10
    ],
    'stripe_id'              => [
        'max' => 50
    ],
    'charge_id'              => [
        'max' => 50
    ],

    'payment_type'              => [
        'max' => 20
    ],

    'athlete' => [
        'title'      => [
            'max' => 10
        ],
        'first_name' => [
            'max' => 50,
            'min' => 2
        ],
        'last_name'  => [
            'max' => 50,
            'min' => 2
        ]
    ],

    'organizer' => [
        'name' => [
            'max' => 100
        ]
    ],

    'admin' => [
        'display_name' => [
            'max' => 105
        ],
        'first_name'   => [
            'max' => 50
        ],
        'last_name'    => [
            'max' => 50
        ]
    ],

    'role' => [
        'label' => [
            'max' => 50
        ],
    ],

    'permission' => [
        'label' => [
            'max' => 50
        ],
    ],

    'event' => [
        'title'             => [
            'max' => 100
        ],
        'description_short' => [
            'max' => 250
        ]
    ],

    'event_group' => [
        'title'             => [
            'max' => 100
        ]
    ],

    'coupon' => [
        'code'             => [
            'max' => 10
        ],
        'type' => [
            'max' => 20
        ]
    ],

    'conversation' => [
        'title'             => [
            'max' => 50
        ]
    ],

    'ad' => [
        'title'             => [
            'max' => 100
        ],
        'text'             => [
            'max' => 200
        ],
        'label'             => [
            'max' => 100
        ],
        'budget_type' => [
            'max' => 10
        ],
    ],

    'target_group' => [
        'title'             => [
            'max' => 100
        ],
    ],

    'image' => [
        'title'             => [
            'max' => 30
        ]
    ],

    'check_point' => [
        'title'    => [
            'max' => 100
        ]
    ],

    'participation_class' => [
        'title' => [
            'max' => 100
        ]
    ],

    'visit_class' => [
        'title' => [
            'max' => 100
        ]
    ],

    'club' => [
        'title' => [
            'max' => 100
        ]
    ],

    'club_forum_posts' => [
        'title' => [
            'max' => 100
        ]
    ],

    'training_plan' => [
        'title' => [
            'max' => 100
        ]
    ],

    'sport_type' => [
        'label' => [
            'max' => 100
        ]
    ],

    'label' => [
        'label' => [
            'max' => 100
        ]
    ],

    'ad_placement' => [
        'label' => [
            'max' => 50
        ],
        'type' => [
            'max' => 50
        ]
    ],

    'participation_state' => [
        'label' => [
            'max' => 100
        ]
    ],

    'settings' => [
        'key' => [
            'max' => 50
        ]
    ]
];
