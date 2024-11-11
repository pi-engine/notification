<?php

namespace Notification;

use Laminas\Mvc\Middleware\PipeSpec;
use Laminas\Router\Http\Literal;
use Logger\Middleware\LoggerRequestResponseMiddleware;
use Pi\Core\Middleware\InstallerMiddleware;
use Pi\Core\Middleware\RequestPreparationMiddleware;
use Pi\Core\Middleware\SecurityMiddleware;
use User\Middleware\AuthenticationMiddleware;
use User\Middleware\AuthorizationMiddleware;

return [
    'service_manager' => [
        'aliases'   => [
            Repository\NotificationRepositoryInterface::class => Repository\NotificationRepository::class,
        ],
        'factories' => [
            Repository\NotificationRepository::class => Factory\Repository\NotificationRepositoryFactory::class,
            Service\NotificationService::class       => Factory\Service\NotificationServiceFactory::class,
            Handler\Admin\SendHandler::class         => Factory\Handler\Admin\SendHandlerFactory::class,
            Handler\Admin\ListHandler::class         => Factory\Handler\Admin\ListHandlerFactory::class,
            Handler\Api\ListHandler::class           => Factory\Handler\Api\ListHandlerFactory::class,
            Handler\Api\UpdateHandler::class         => Factory\Handler\Api\UpdateHandlerFactory::class,
            Handler\Api\CountHandler::class          => Factory\Handler\Api\CountHandlerFactory::class,
            Sender\Mail\LaminasMail::class           => Factory\Sender\Mail\LaminasMailFactory::class,
            Sender\Mail\Mailer::class                => Factory\Sender\Mail\MailerFactory::class,
            Sender\SMS\Twilio::class                 => Factory\Sender\SMS\TwilioFactory::class,
            Sender\SMS\Nexmo::class                  => Factory\Sender\SMS\NexmoFactory::class,
            Sender\SMS\PayamakYab::class             => Factory\Sender\SMS\PayamakYabFactory::class,
            Sender\SMS\KaveNegar::class              => Factory\Sender\SMS\KaveNegarFactory::class,
            Sender\Push\Fcm::class                   => Factory\Sender\Push\FcmFactory::class,
            Sender\Push\Apns::class                  => Factory\Sender\Push\ApnsFactory::class,
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
                                    RequestPreparationMiddleware::class,
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
                                    RequestPreparationMiddleware::class,
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    LoggerRequestResponseMiddleware::class,
                                    Handler\Api\ListHandler::class
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
                                    RequestPreparationMiddleware::class,
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    LoggerRequestResponseMiddleware::class,
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
                    'list'      => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/list',
                            'defaults' => [
                                'title'       => 'Admin notification list',
                                'module'      => 'notification',
                                'section'     => 'admin',
                                'package'     => 'notification',
                                'handler'     => 'list',
                                'permissions' => 'notification-list',
                                'controller'  => PipeSpec::class,
                                'middleware'  => new PipeSpec(
                                    RequestPreparationMiddleware::class,
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    AuthorizationMiddleware::class,
                                    LoggerRequestResponseMiddleware::class,
                                    Handler\Admin\ListHandler::class
                                ),
                            ],
                        ],
                    ],
                    'send'      => [
                        'type'    => Literal::class,
                        'options' => [
                            'route'    => '/send',
                            'defaults' => [
                                'title'       => 'Admin notification send',
                                'module'      => 'notification',
                                'section'     => 'admin',
                                'package'     => 'notification',
                                'handler'     => 'send',
                                'permissions' => 'notification-send',
                                'controller'  => PipeSpec::class,
                                'middleware'  => new PipeSpec(
                                    RequestPreparationMiddleware::class,
                                    SecurityMiddleware::class,
                                    AuthenticationMiddleware::class,
                                    AuthorizationMiddleware::class,
                                    LoggerRequestResponseMiddleware::class,
                                    Handler\Admin\SendHandler::class
                                ),
                            ],
                        ],
                    ],
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
                                    RequestPreparationMiddleware::class,
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