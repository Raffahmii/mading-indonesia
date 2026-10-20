<?php

return [
    'app_name' => env('APP_NAME', 'Mading Indonesia'),

    'pagination' => [
        'public'  => 12,
        'admin'   => 15,
        'member'  => 10,
        'logs'    => 25,
    ],

    'upload' => [
        'logo_max_kb'   => 2048,
        'cover_max_kb'  => 4096,
        'image_mimes'   => ['jpg', 'jpeg', 'png', 'webp', 'svg'],
        'logo_path'     => 'universities/logos',
        'cover_path'    => 'posts/covers',
        'avatar_path'   => 'users/avatars',
    ],

    'theme' => [
        'default_primary'   => '#8E1EA2',
        'default_secondary' => '#C654C3',
        'default_accent'    => '#ED96D7',
        'default_soft'      => '#FFC0DE',
    ],

    'workflow' => [
        'statuses' => [
            'draft',
            'pending',
            'approved',
            'rejected',
            'published',
            'archived',
        ],
        'transitions' => [
            'draft'     => ['pending', 'archived'],
            'pending'   => ['approved', 'rejected'],
            'approved'  => ['published', 'archived'],
            'rejected'  => ['draft', 'archived'],
            'published' => ['archived'],
            'archived'  => [],
        ],
    ],

    'cache' => [
        'university_theme_ttl' => 3600,
        'homepage_featured_ttl' => 900,
    ],
];