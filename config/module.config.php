<?php

namespace Notification;

use Laminas\Mvc\Middleware\PipeSpec;
use Laminas\Router\Http\Literal;
use User\Middleware\AuthenticationMiddleware;
use User\Middleware\SecurityMiddleware;

return [
    'service_manager' => [
        'aliases' => [
            Repository\NotificationRepositoryInterface::class => Repository\NotificationRepository::class,
        ],
        'factories' => [
            Repository\NotificationRepository::class => Factory\Repository\NotificationRepositoryFactory::class,
            Service\NotificationService::class => Factory\Service\NotificationServiceFactory::class,
            Service\SendService::class => Factory\Service\SendServiceFactory::class,

            Sender\Mail\Mail::class        => Factory\Sender\Mail\MailFactory::class,
            Sender\Push\Push::class        => Factory\Sender\Push\PushFactory::class,
            Sender\SMS\SMS::class          => Factory\Sender\SMS\SMSFactory::class,

            Handler\Api\ListHandler::class => Factory\Handler\Api\ListHandlerFactory::class,
            Handler\Api\SendHandler::class => Factory\Handler\Api\SendHandlerFactory::class,
        ],
    ],
    'router' => [
        'routes' => [
            // Api section
            'api_notification' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/notification',
                    'defaults' => [],
                ],
                'child_routes' => [
                    'list' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/list',
                            'defaults' => [
                                'module' => 'notification',
                                'section' => 'api',
                                'package' => 'list',
                                'handler' => 'list',
                                'permissions' => 'notification-list',
                                'controller' => PipeSpec::class,
                                'middleware' => new PipeSpec(
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    Handler\Api\ListHandler::class
                                ),
                            ],
                        ],
                    ],
                    'send' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/send',
                            'defaults' => [
                                'module' => 'notification',
                                'section' => 'api',
                                'package' => 'send',
                                'handler' => 'send',
                                'permissions' => 'notification-send',
                                'controller' => PipeSpec::class,
                                'middleware' => new PipeSpec(
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    Handler\Api\SendHandler::class
                                ),
                            ],
                        ],
                    ],
                ],
            ],
            // Admin section
            'admin_notification' => [
                'type' => Literal::class,
                'options' => [
                    'route' => '/admin/notification',
                    'defaults' => [],
                ],
                'child_routes' => [
                    // Admin installer
                    'installer' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/installer',
                            'defaults' => [
                                'module' => 'notification',
                                'section' => 'admin',
                                'package' => 'installer',
                                'handler' => 'installer',
                                'controller' => PipeSpec::class,
                                'middleware' => new PipeSpec(
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    Handler\InstallerHandler::class
                                ),
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],

    'view_manager' => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];