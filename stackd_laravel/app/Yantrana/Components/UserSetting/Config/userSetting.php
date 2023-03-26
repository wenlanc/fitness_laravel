<?php

return [

    /* user setting data-types id
    ------------------------------------------------------------------------- */
    'datatypes'  => [
        'string' => 1,
        'bool'   => 2,
        'int'    => 3,
        'json'   => 4
    ],

    /* User Setting Items
	------------------------------------------------------------------------- */
    'items' => [
        'notification' => [
            // Receive Notification method
            'show_visitor_notification'  => [
                'key'           => 'show_visitor_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_like_notification'  => [
                'key'           => 'show_like_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_gift_notification'  => [
                'key'           => 'show_gift_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_message_notification'  => [
                'key'           => 'show_message_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_user_login_notification'  => [
                'key'           => 'show_user_login_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'display_user_mobile_number'  => [
                'key'           => 'display_user_mobile_number',
                'data_type'     => 1,    // string
                'default'       => 1
            ],
            'notification_match_push'  => [
                'key'           => 'notification_match_push',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'notification_match_email'  => [
                'key'           => 'notification_match_email',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'notification_follower_push'  => [
                'key'           => 'notification_follower_push',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'notification_follower_email'  => [
                'key'           => 'notification_follower_email',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_message_notification_push'  => [
                'key'           => 'show_message_notification_push',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_message_notification_email'  => [
                'key'           => 'show_message_notification_email',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_news_notification_push'  => [
                'key'           => 'show_news_notification_push',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_news_notification_email'  => [
                'key'           => 'show_news_notification_email',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_product_notification_push'  => [
                'key'           => 'show_product_notification_push',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_product_notification_email'  => [
                'key'           => 'show_product_notification_email',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'allow_notifications'  => [
                'key'           => 'allow_notifications',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
        ],
        'basic_search' => [
            'looking_for'  => [
                'key'           => 'looking_for',
                'data_type'     => 1,    // string
                'default'       => 'all',
            ],
            'min_age'  => [
                'key'           => 'min_age',
                'data_type'     => 3,    // int
                'default'       => config('__tech.user_settings.default_min_age', 18),
            ],
            'max_age'  => [
                'key'           => 'max_age',
                'data_type'     => 3,    // int
                'default'       => config('__tech.user_settings.default_max_age', 100),
            ],
            'distance'  => [
                'key'           => 'distance',
                'data_type'     => 3,    // int
                'default'       => null,
            ],
        ],
        'basic_search_pt' => [
            'looking_for'  => [
                'key'           => 'looking_for_pt',
                'data_type'     => 1,    // string
                'default'       => 'all',
            ],
            'min_age'  => [
                'key'           => 'min_age_pt',
                'data_type'     => 3,    // int
                'default'       => config('__tech.user_settings.default_min_age', 18),
            ],
            'max_age'  => [
                'key'           => 'max_age_pt',
                'data_type'     => 3,    // int
                'default'       => config('__tech.user_settings.default_max_age', 100),
            ],
            'distance'  => [
                'key'           => 'distance_pt',
                'data_type'     => 3,    // int
                'default'       => null,
            ],
        ],
        'site_defaults' => [
            'selected_theme'  => [
                'key'           => 'selected_theme',
                'data_type'     => 1,    // string
                'default'       => '',
            ],
            'selected_locale'  => [
                'key'           => 'selected_locale',
                'data_type'     => 1,    // string
                'default'       => '',
            ],
        ],
        'account' => [
            // Receive Notification method
            'show_visitor_notification'  => [
                'key'           => 'show_visitor_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_like_notification'  => [
                'key'           => 'show_like_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_gift_notification'  => [
                'key'           => 'show_gift_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_message_notification'  => [
                'key'           => 'show_message_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_user_login_notification'  => [
                'key'           => 'show_user_login_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'display_user_mobile_number'  => [
                'key'           => 'display_user_mobile_number',
                'data_type'     => 1,    // string
                'default'       => 1
            ]
        ],
        'privacy_security' => [
            // Receive Notification method
            'show_visitor_notification'  => [
                'key'           => 'show_visitor_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_like_notification'  => [
                'key'           => 'show_like_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_gift_notification'  => [
                'key'           => 'show_gift_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_message_notification'  => [
                'key'           => 'show_message_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_user_login_notification'  => [
                'key'           => 'show_user_login_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'display_user_mobile_number'  => [
                'key'           => 'display_user_mobile_number',
                'data_type'     => 1,    // string
                'default'       => 1
            ]
        ],
        'help' => [
            // Receive Notification method
            'show_visitor_notification'  => [
                'key'           => 'show_visitor_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_like_notification'  => [
                'key'           => 'show_like_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_gift_notification'  => [
                'key'           => 'show_gift_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_message_notification'  => [
                'key'           => 'show_message_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_user_login_notification'  => [
                'key'           => 'show_user_login_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'display_user_mobile_number'  => [
                'key'           => 'display_user_mobile_number',
                'data_type'     => 1,    // string
                'default'       => 1
            ]
        ],
        'about' => [
            // Receive Notification method
            'show_visitor_notification'  => [
                'key'           => 'show_visitor_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_like_notification'  => [
                'key'           => 'show_like_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_gift_notification'  => [
                'key'           => 'show_gift_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_message_notification'  => [
                'key'           => 'show_message_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'show_user_login_notification'  => [
                'key'           => 'show_user_login_notification',
                'data_type'     => 2,    // boolean
                'default'       => true,
            ],
            'display_user_mobile_number'  => [
                'key'           => 'display_user_mobile_number',
                'data_type'     => 1,    // string
                'default'       => 1
            ]
        ]

    ]
];
