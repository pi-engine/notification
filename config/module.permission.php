<?php

return [
    'api' => [
        [
            'module'      => 'notification',
            'section'     => 'api',
            'package'     => 'notification',
            'handler'     => 'count',
            'permissions' => 'notification-count',
            'role'        => [
                'member',
                'admin',
            ],
        ],
        [
            'module'      => 'notification',
            'section'     => 'api',
            'package'     => 'notification',
            'handler'     => 'list',
            'permissions' => 'notification-list',
            'role'        => [
                'member',
                'admin',
            ],
        ],
        [
            'module'      => 'notification',
            'section'     => 'api',
            'package'     => 'notification',
            'handler'     => 'send',
            'permissions' => 'notification-send',
            'role'        => [
                'member',
                'admin',
            ],
        ],
    ],
];