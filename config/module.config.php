<?php

namespace Notification;

use Laminas\Mvc\Middleware\PipeSpec;
use Laminas\Router\Http\Literal;
use User\Middleware\AuthenticationMiddleware;
use User\Middleware\InstallerMiddleware;
use User\Middleware\SecurityMiddleware;

return [
    'service_manager' => [
        'aliases'   => [
            Repository\NotificationRepositoryInterface::class => Repository\NotificationRepository::class,
            Sender\Mail\MailInterface::class                  => Sender\Mail\Mailer::class,
            Sender\SMS\SMSInterface::class                    => Sender\SMS\PayamakYab::class,
            Sender\Push\PushInterface::class                  => Sender\Push\Fcm::class,
        ],
        'factories' => [
            Repository\NotificationRepository::class => Factory\Repository\NotificationRepositoryFactory::class,
            Service\NotificationService::class       => Factory\Service\NotificationServiceFactory::class,
            Handler\Api\ListHandler::class           => Factory\Handler\Api\ListHandlerFactory::class,
            Handler\Api\SendHandler::class           => Factory\Handler\Api\SendHandlerFactory::class,
            Handler\Api\UpdateHandler::class         => Factory\Handler\Api\UpdateHandlerFactory::class,
            Handler\Api\CountHandler::class          => Factory\Handler\Api\CountHandlerFactory::class,
            Sender\Mail\LaminasMail::class           => Factory\Sender\Mail\LaminasMailFactory::class,
            Sender\Mail\Mailer::class                => Factory\Sender\Mail\MailerFactory::class,
            Sender\SMS\Nexmo::class                  => Factory\Sender\SMS\NexmoFactory::class,
            Sender\SMS\PayamakYab::class             => Factory\Sender\SMS\PayamakYabFactory::class,
            Sender\SMS\KaveNegar::class              => Factory\Sender\SMS\KaveNegarFactory::class,
            Sender\Push\Fcm::class                   => Factory\Sender\Push\FcmFactory::class,
            Handler\InstallerHandler::class          => Factory\Handler\InstallerHandlerFactory::class,
        ],
    ],
    'router'          => [
        'routes' => [
            // Api section
            'api_notification'   => [
                'type'         => Literal::class,
                'options'      => [
                    'route'    => '/notification',
                    'defaults' => [],
                ],
                'child_routes' => [
                    'count'  => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/count',
                            'defaults' => [
                                'title'       => 'Notification count',
                                'module'      => 'notification',
                                'section'     => 'api',
                                'package'     => 'count',
                                'handler'     => 'count',
                                'permissions' => 'notification-count',
                                'controller'  => PipeSpec::class,
                                'middleware'  => new PipeSpec(
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    Handler\Api\CountHandler::class
                                ),
                            ],
                        ],
                    ],
                    'list'   => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/list',
                            'defaults' => [
                                'title'       => 'Notification list',
                                'module'      => 'notification',
                                'section'     => 'api',
                                'package'     => 'list',
                                'handler'     => 'list',
                                'permissions' => 'notification-list',
                                'controller'  => PipeSpec::class,
                                'middleware'  => new PipeSpec(
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    Handler\Api\ListHandler::class
                                ),
                            ],
                        ],
                    ],
                    'send'   => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/send',
                            'defaults' => [
                                'title'       => 'Notification send',
                                'module'      => 'notification',
                                'section'     => 'api',
                                'package'     => 'send',
                                'handler'     => 'send',
                                'permissions' => 'notification-send',
                                'controller'  => PipeSpec::class,
                                'middleware'  => new PipeSpec(
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    Handler\Api\SendHandler::class
                                ),
                            ],
                        ],
                    ],
                    'update' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/update',
                            'defaults' => [
                                'title'       => 'Notification send update',
                                'module'      => 'notification',
                                'section'     => 'api',
                                'package'     => 'send',
                                'handler'     => 'send',
                                'permissions' => 'notification-send',
                                'controller'  => PipeSpec::class,
                                'middleware'  => new PipeSpec(
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    Handler\Api\UpdateHandler::class
                                ),
                            ],
                        ],
                    ],
                ],
            ],
            // Admin section
            'admin_notification' => [
                'type'         => Literal::class,
                'options'      => [
                    'route'    => '/admin/notification',
                    'defaults' => [],
                ],
                'child_routes' => [
                    // Admin installer
                    'installer' => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/installer',
                            'defaults' => [
                                'module'     => 'notification',
                                'section'    => 'admin',
                                'package'    => 'installer',
                                'handler'    => 'installer',
                                'controller' => PipeSpec::class,
                                'middleware' => new PipeSpec(
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    InstallerMiddleware::class,
                                    Handler\InstallerHandler::class
                                ),
                            ],
                        ],
                    ],
                ],
            ],
        ],
    ],
    'view_manager'    => [
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];