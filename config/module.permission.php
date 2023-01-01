<?php

return [
    'api'   => [
        [
            'module'      => 'notification',
            'section'     => 'api',
            'package'     => 'notification',
            'handler'     => 'dashboard',
            'permissions' => 'dashboard',
            'role'        => [
                'member',
                'admin',
            ],
        ],
    ],
];