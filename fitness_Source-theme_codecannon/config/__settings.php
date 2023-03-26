<?php

return [

    /* Configuration setting data-types id
    ------------------------------------------------------------------------- */
    'datatypes'  => [
        'string' => 1,
        'bool'   => 2,
        'int'    => 3,
        'json'   => 4
    ],

    /* Configuration Setting Items
    ------------------------------------------------------------------------- */
    'items' => [
        'general'   => [
            'logo_name' => [
                'key'           => 'logo_name',
                'data_type'     => 1,    // string,
                'placeholder'   => '',
                'default'       => 'logo.svg'
            ],
            'small_logo_name' => [
                'key'           => 'small_logo_name',
                'data_type'     => 1,    // string,
                'placeholder'   => '',
                'default'       => 'small-short.svg'
            ],
            'favicon_name' => [
                'key'           => 'favicon_name',
                'data_type'     => 1,    // string,
                'placeholder'   => '',
                'default'       => 'favicon.ico'
            ],
            'name' => [
                'key'           => 'name',
                'data_type'     => 1,    // string,
                'placeholder'   => 'Your Website Name',
                'default'       => 'STACKD'
            ],
            'business_email' => [
                'key'           => 'business_email',
                'data_type'     => 1,    // string
                'placeholder'   => 'your-email-address@example.com',
                'default'       => 'your-business-email@domain.com'
            ],
            'contact_email' => [
                'key'           => 'contact_email',
                'data_type'     => 1,    // string
                'placeholder'   => 'your-email-address@example.com',
                'default'       => 'your-contact-email@domain.com'
            ],
            'default_language' => [
                'key'           => 'default_language',
                'data_type'     => 1,    // string
                'default'       => config('__tech.default_translation_language.id', 'en_US')
            ],
            'timezone' => [
                'key'           => 'timezone',
                'data_type'     => 1,    // string
                'default'       => 'UTC'
            ],
            'distance_measurement' => [
                'key'           => 'distance_measurement',
                'data_type'     => 1,    // string
                'default'       => '6371'
            ],

            'color_theme' => [
                'key'           => 'color_theme',
                'data_type'     => 1,    // string
                'default'       => 'dark'
            ],
            'allow_user_to_change_theme' => [
                'key'           => 'allow_user_to_change_theme',
                'data_type'     => 2,    // bool
                'default'       => true
            ],
        ],
        'user'      => [
            'activation_required_for_new_user'        => [
                'key'           => 'activation_required_for_new_user',
                'data_type'     => 2,    // bool
                'default'       => false
            ],
            'activation_required_for_change_email'        => [
                'key'           => 'activation_required_for_change_email',
                'data_type'     => 2,    // boolean
                'default'       => false
            ],
            'enable_bonus_credits'  => [
                'key'           => 'enable_bonus_credits',
                'data_type'     => 2,     // boolean
                'default'       => false
            ],
            'number_of_credits'    => [
                'key'           => 'number_of_credits',
                'data_type'     => 3,    // integer
                'default'       => 0
            ],
            'terms_and_conditions_url'    => [
                'key'           => 'terms_and_conditions_url',
                'data_type'     => 1,    // string
                'default'       => ""
            ],
            'user_photo_restriction'    => [
                'key'           => 'user_photo_restriction',
                'data_type'     => 1,    // string
                'default'       => 10
            ],
            'include_exclude_admin'    => [
                'key'           => 'include_exclude_admin',
                'data_type'     => 2,    // string
                'default'       => false
            ],
            'display_mobile_number'    => [
                'key'           => 'display_mobile_number',
                'data_type'     => 1,    // string
                'default'       => 1
            ]
        ],
        'currency'      => [
            'currency_format'   => [
                'key'           => 'currency_format',
                'data_type'     => 1,    // string
                'default'       => '{__currencySymbol__}{__amount__} {__currencyCode__}'
            ],
            // Currency settings
            'currency'              => [
                'key'           => 'currency',
                'data_type'     => 1,    // string
                'default'       => 'USD'
            ],
            'currency_symbol'       => [
                'key'           => 'currency_symbol',
                'data_type'     => 1,    // string
                'default'       => '&#36;'
            ],
            'currency_value'        => [
                'key'           => 'currency_value',
                'data_type'     => 1,    // string
                'default'       => 'USD'
            ],
            'round_zero_decimal_currency' => [
                'key'           => 'round_zero_decimal_currency',
                'data_type'     => 2, // boolean
                'default'       => true // round
            ]
        ],
        'payment' => [
            // Payment method
            'enable_paypal'  => [
                'key'           => 'enable_paypal',
                'data_type'     => 2,    // boolean
                'default'       => false,
            ],
            'use_test_paypal_checkout'  => [
                'key'           => 'use_test_paypal_checkout',
                'data_type'     => 2,    // boolean
                'default'       => false
            ],
            'paypal_checkout_testing_client_id' => [
                'key'           => 'paypal_checkout_testing_client_id',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'paypal_checkout_testing_secret_key'  => [
                'key'           => 'paypal_checkout_testing_secret_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'paypal_checkout_live_client_id' => [
                'key'           => 'paypal_checkout_live_client_id',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'paypal_checkout_live_secret_key'  => [
                'key'           => 'paypal_checkout_live_secret_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            // Payment method
            'enable_stripe'  => [
                'key'           => 'enable_stripe',
                'data_type'     => 2,    // boolean
                'default'       => false
            ],
            'use_test_stripe'            => [
                'key'           => 'use_test_stripe',
                'data_type'     => 2,    // boolean
                'default'       => false
            ],
            'stripe_testing_secret_key'          => [
                'key'           => 'stripe_testing_secret_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'placeholder'   => 'Test Secret Key',
                'hide_value'    => true
            ],
            'stripe_testing_publishable_key'          => [
                'key'           => 'stripe_testing_publishable_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'placeholder'   => 'Test Publishable key',
                'hide_value'    => true
            ],
            'stripe_live_secret_key'          => [
                'key'           => 'stripe_live_secret_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'placeholder'   => 'Live secret key',
                'hide_value'    => true
            ],
            'stripe_live_publishable_key'          => [
                'key'           => 'stripe_live_publishable_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'placeholder'   => 'Live Publishable Key',
                'hide_value'    => true
            ],
            'enable_razorpay'        => [
                'key'           => 'enable_razorpay',
                'data_type'     => 2,    // boolean
                'default'       => false
            ],
            'use_test_razorpay'            => [
                'key'           => 'use_test_razorpay',
                'data_type'     => 2,    // boolean
                'default'       => false
            ],
            'razorpay_live_key'        => [
                'key'           => 'razorpay_live_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'placeholder'   => 'Razorpay Live Key',
                'hide_value'    => true
            ],
            'razorpay_live_secret_key'          => [
                'key'           => 'razorpay_live_secret_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'placeholder'   => 'Razorpay Live Secret Key',
                'hide_value'    => true
            ],
            'razorpay_testing_key'        => [
                'key'           => 'razorpay_testing_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'placeholder'   => 'Razorpay Testing Key',
                'hide_value'    => true
            ],
            'razorpay_testing_secret_key'          => [
                'key'           => 'razorpay_testing_secret_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'placeholder'   => 'Razorpay Testing Secret Key',
                'hide_value'    => true
            ],
        ],
        'social-login' => [
            // Social Login Settings
            'allow_facebook_login'  => [
                'key'           => 'allow_facebook_login',
                'data_type'     => 2,     // boolean
                'default'       => false
            ],
            'facebook_client_id'    => [
                'key'           => 'facebook_client_id',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'facebook_client_secret' => [
                'key'           => 'facebook_client_secret',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'allow_google_login' => [
                'key'           => 'allow_google_login',
                'data_type'     => 2,     // boolean
                'default'       => false
            ],
            'google_client_id'      => [
                'key'           => 'google_client_id',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'google_client_secret'  => [
                'key'           => 'google_client_secret',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
        ],
        'integration' => [
            'allow_pusher'  => [
                'key'           => 'allow_pusher',
                'data_type'     => 2,     // boolean
                'default'       => false
            ],
            'pusher_app_id'    => [
                'key'           => 'pusher_app_id',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'pusher_app_key' => [
                'key'           => 'pusher_app_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'pusher_app_secret' => [
                'key'           => 'pusher_app_secret',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'pusher_app_cluster_key' => [
                'key'           => 'pusher_app_cluster_key',
                'data_type'     => 1,    // string
                'default'       => 'ap2',
                'hide_value'    => true
            ],
            'allow_agora'  => [
                'key'           => 'allow_agora',
                'data_type'     => 2,     // boolean
                'default'       => false
            ],
            'agora_app_id'    => [
                'key'           => 'agora_app_id',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'agora_app_certificate_key' => [
                'key'           => 'agora_app_certificate_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'allow_google_map'  => [
                'key'           => 'allow_google_map',
                'data_type'     => 2,     // boolean
                'default'       => false
            ],
            'google_map_key'  => [
                'key'           => 'google_map_key',
                'data_type'     => 1,     // boolean
                'default'       => '',
                'hide_value'    => true
            ],
            'allow_giphy'  => [
                'key'           => 'allow_giphy',
                'data_type'     => 2,     // boolean
                'default'       => false
            ],
            'giphy_key' => [
                'key'           => 'giphy_key',
                'data_type'     => 1,    // string
                'default'       => '',
                'hide_value'    => true
            ],
            'use_static_city_data'  => [
                'key'           => 'use_static_city_data',
                'data_type'     => 2,     // boolean
                'default'       => true
            ],
        ],
        'language-settings' => [
            'translation_languages' => [
                'key'           => 'translation_languages',
                'data_type'     => 4,    // string
                'default'       => ''
            ],
        ],
        'premium-plans' => [
            'plan_duration' => [
                'key'            =>    'plan_duration',
                'data_type'        => 4, // json
                'default'       => [
                    'one_day' => [
                        'title' => __tr('1 Day'),
                        'enable' => true,
                        'price' => 1
                    ],
                    'one_week' => [
                        'title' => __tr('1 Week'),
                        'enable' => true,
                        'price' => 5
                    ],
                    'one_month' => [
                        'title' => __tr('1 Month'),
                        'enable' => true,
                        'price' => 20
                    ],
                    'half_year' => [
                        'title' => __tr('Half Year'),
                        'enable' => true,
                        'price' => 60
                    ],
                    'year' => [
                        'title' => __tr('Year'),
                        'enable' => true,
                        'price' => 80
                    ],
                    'life_time' => [
                        'title' => __tr('Life Time'),
                        'enable' => true,
                        'price' => 100
                    ]
                ]
            ]
        ],
        'premium-feature' => [
            'feature_plans' => [
                'key'            =>    'feature_plans',
                'data_type'        => 4, // json
                'default'       => [
                    'no_adds' => [
                        'title'         => __tr('No Adds'),
                        'enable'         => true,
                        'select_user'     => 2,
                        'icon' => '<span class="fa-stack fa-2x"><i class="fas fa-tv fa-stack-1x"></i><i class="fas fa-ban fa-stack-2x" style="color:Tomato"></i></span>',
                        'options' => [
                            [
                                'title'       => __tr('All Users'),
                                'value'       => 1
                            ],
                            [
                                'title'       => __tr('Premium Users'),
                                'value'       => 2
                            ],
                        ]
                    ],
                    'browse_incognito_mode' => [
                        'title'     => __tr('Browse in Incognito mode'),
                        'enable'     => true,
                        'select_user'     => 2,
                        'icon' => '<i class="fas fa-user-secret fa-3x"></i>',
                        'options' => [
                            [
                                'title'       => __tr('All Users'),
                                'value'       => 1
                            ],
                            [
                                'title'       => __tr('Premium Users'),
                                'value'       => 2
                            ],
                        ]
                    ],
                    'show_like' => [
                        'title'       => __tr('Show Who Likes Me'),
                        'enable'       => true,
                        'select_user'     => 2,
                        'icon' => '<i class="fas fa-heartbeat fa-3x text-primary"></i>',
                        'options' => [
                            [
                                'title'       => __tr('All Users'),
                                'value'       => 1
                            ],
                            [
                                'title'       => __tr('Premium Users'),
                                'value'       => 2
                            ],
                        ]
                    ],
                    'audio_call_via_messenger' => [
                        'title'       => __tr('Audio Call Via Messenger'),
                        'enable'       => true,
                        'select_user'     => 2,
                        'icon' => '<i class="fas fa-headset fa-3x"></i>',
                        'options' => [
                            [
                                'title'       => __tr('All Users'),
                                'value'       => 1
                            ],
                            [
                                'title'       => __tr('Premium Users'),
                                'value'       => 2
                            ],
                        ]
                    ],
                    'video_call_via_messenger' => [
                        'title'       => __tr('Video Call Via Messenger'),
                        'enable'       => true,
                        'select_user'     => 2,
                        'icon' => '<i class="fas fa-video fa-3x"></i>',
                        'options' => [
                            [
                                'title'       => __tr('All Users'),
                                'value'       => 1
                            ],
                            [
                                'title'       => __tr('Premium Users'),
                                'value'       => 2
                            ],
                        ]
                    ],
                    'user_encounter' => [
                        'title'       => __tr('User Encounter'),
                        'enable'       => true,
                        'select_user'     => 2,
                        'icon' => '<i class="fas fa-surprise fa-3x"></i>',
                        'encounter_all_user_count'     => 10,
                        'options' => [
                            [
                                'title'       => __tr('All Users'),
                                'value'       => 1
                            ],
                            [
                                'title'       => __tr('Premium Users'),
                                'value'       => 2
                            ],
                        ]
                    ]
                ]
            ]
        ],
        'advertisement' => [
            'header_advertisement' => [
                'key'           => 'header_advertisement',
                'data_type'     => 4,
                'placeholder'   => __tr('Your Website Name'),
                'default'       => [
                    'title'   => __tr('728 X 90 (Appear in Header)'),
                    'status'  => false,
                    'height'  => 728,
                    'width'   => 90,
                    'content' => ''
                ]
            ],
            'footer_advertisement' => [
                'key'           => 'footer_advertisement',
                'data_type'     => 4,
                'placeholder'   => __tr('Your Website Name'),
                'default'       => [
                    'title'   => __tr('728 X 90 (Appear in Footer)'),
                    'status'  => false,
                    'height'  => 728,
                    'width'   => 90,
                    'content' => ''
                ]
            ],
            'user_sidebar_advertisement' => [
                'key'           => 'user_sidebar_advertisement',
                'data_type'     => 4,
                'placeholder'   => __tr('Your Website Name'),
                'default'       => [
                    'title'   => __tr('200 X 200 (Appear in User Sidebar)'),
                    'status'  => false,
                    'height'  => 200,
                    'width'   => 200,
                    'content' => ''
                ]
            ]
        ],
        'email'   => [
            'use_env_default_email_settings'       => [
                'key'           => 'use_env_default_email_settings',
                'data_type'     => 2,    // boolean
                'placeholder'   => '',
                'default'       => true
            ],
            'mail_driver'       => [
                'key'           => 'mail_driver',
                'data_type'     => 1,    // integer
                'placeholder'   => '',
                'default'       => 'smtp'
            ],
            'mail_from_address'          => [
                'key'           => 'mail_from_address',
                'data_type'     => 1,    // string
                'placeholder'   => '',
                'default'       => ''
            ],
            'mail_from_name'          => [
                'key'           => 'mail_from_name',
                'data_type'     => 1,    // string
                'placeholder'   => '',
                'default'       => ''
            ],
            'smtp_mail_port'    => [
                'key'           => 'smtp_mail_port',
                'data_type'     => 3,    // integer
                'placeholder'   => '',
                'default'       => null
            ],
            'smtp_mail_host'    => [
                'key'           => 'smtp_mail_host',
                'data_type'     => 1,    // string
                'placeholder'   => '',
                'default'       => ''
            ],
            'smtp_mail_username'  => [
                'key'           => 'smtp_mail_username',
                'data_type'     => 1,    // string
                'placeholder'   => '',
                'default'       => ''
            ],
            'smtp_mail_encryption' => [
                'key'           => 'smtp_mail_encryption',
                'data_type'     => 1,    // string
                'placeholder'   => '',
                'default'       => ''
            ],
            'smtp_mail_password_or_apikey' => [
                'key'           => 'smtp_mail_password_or_apikey',
                'data_type'     => 1,    // string
                'placeholder'   => '',
                'default'       => ''
            ],
            'sparkpost_mail_password_or_apikey' => [
                'key'           => 'sparkpost_mail_password_or_apikey',
                'data_type'     => 1,    // string
                'placeholder'   => '',
                'default'       => ''
            ],
            'mailgun_mail_password_or_apikey' => [
                'key'           => 'mailgun_mail_password_or_apikey',
                'data_type'     => 1,    // string
                'placeholder'   => '',
                'default'       => ''
            ],
            'mailgun_domain'          => [
                'key'           => 'mailgun_domain',
                'data_type'     => 1,    // string
                'placeholder'   => '',
                'default'       => ''
            ],
            'mailgun_endpoint'          => [
                'key'           => 'mailgun_endpoint',
                'data_type'     => 1,    // string
                'placeholder'   => '',
                'default'       => ''
            ]
        ],
        'booster' => [
            'booster_period'       => [
                'key'           => 'booster_period',
                'data_type'     => 3,    // int
                'placeholder'   => '',
                'default'       => 5
            ],
            'booster_price'       => [
                'key'           => 'booster_price',
                'data_type'     => 3,    // int
                'placeholder'   => '',
                'default'       => 0
            ],
            'booster_price_for_premium_user'       => [
                'key'           => 'booster_price_for_premium_user',
                'data_type'     => 3,    // int
                'placeholder'   => '',
                'default'       => 0
            ]
        ],
        'random_user' => [
            'booster_user_count'       => [
                'key'           => 'booster_user_count',
                'data_type'     => 3,    // int
                'default'       => 4
            ],
            'premium_user_count'       => [
                'key'           => 'premium_user_count',
                'data_type'     => 3,    // int
                'default'       => 4
            ],
            'normal_user_count'       => [
                'key'           => 'normal_user_count',
                'data_type'     => 3,    // int
                'default'       => 4
            ]
        ],
        'product_registration' => [
            'product_registration' => [
                'key'           => 'product_registration',
                'data_type'     => 4, // json
                'default'       => [
                    'registration_id' => '',
                    'email' => '',
                    'registered_at' => '',
                    'licence' => '',
                    'signature' => ''
                ]
            ]
        ]
    ]
];
