<?php

namespace Notification;

use Laminas\Mvc\Middleware\PipeSpec;
use Laminas\Router\Http\Literal;
use User\Middleware\AuthenticationMiddleware;
use User\Middleware\AuthorizationMiddleware;
use User\Middleware\SecurityMiddleware;

return [
    'service_manager' => [
        'aliases' => [
            Repository\NotificationRepositoryInterface::class => Repository\NotificationRepository::class,
            Repository\MessageRepositoryInterface::class => Repository\MessageRepository::class,
            Repository\PlatformRepositoryInterface::class => Repository\PlatformRepository::class,
            Repository\IdValueRepositoryInterface::class => Repository\IdValueRepository::class,
        ],
        'factories' => [
            Repository\NotificationRepository::class => Factory\Repository\NotificationRepositoryFactory::class,
            Service\NotificationService::class => Factory\Service\NotificationServiceFactory::class,

            Repository\MessageRepository::class => Factory\Repository\MessageRepositoryFactory::class,
            Service\MessageService::class => Factory\Service\MessageServiceFactory::class,

            Repository\PlatformRepository::class => Factory\Repository\PlatformRepositoryFactory::class,
            Service\PlatformService::class => Factory\Service\PlatformServiceFactory::class,

            Repository\IdValueRepository::class => Factory\Repository\IdValueRepositoryFactory::class,
            Service\IdValueService::class => Factory\Service\IdValueServiceFactory::class,


//            Middleware\ValidationMiddleware::class => Factory\Middleware\ValidationMiddlewareFactory::class,
            Handler\Api\DashboardHandler::class => Factory\Handler\Api\DashboardHandlerFactory::class,
            Handler\Api\SendHandler::class => Factory\Handler\Api\SendHandlerFactory::class,
//            Handler\InstallerHandler::class => Factory\Handler\InstallerHandlerFactory::class,
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
                    'dashboard' => [
                        'type' => Literal::class,
                        'options' => [
                            'route' => '/dashboard',
                            'defaults' => [
                                'module' => 'notification',
                                'section' => 'api',
                                'package' => 'dashboard',
                                'handler' => 'dashboard',
                                'permissions' => 'notification-dashboard',
                                'controller' => PipeSpec::class,
                                'middleware' => new PipeSpec(
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
//                                    AuthorizationMiddleware::class,
                                    Handler\Api\DashboardHandler::class
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
                                'permissions' => 'notification-dashboard',
                                'controller' => PipeSpec::class,
                                'middleware' => new PipeSpec(
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
//                                    AuthorizationMiddleware::class,
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