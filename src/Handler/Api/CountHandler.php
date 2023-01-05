<?php

namespace Notification\Handler\Api;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Notification\Service\NotificationService;

class CountHandler implements RequestHandlerInterface
{
    /** @var ResponseFactoryInterface */
    protected ResponseFactoryInterface $responseFactory;

    /** @var StreamFactoryInterface */
    protected StreamFactoryInterface $streamFactory;

    /** @var NotificationService */
    protected NotificationService $notificationService;


    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        NotificationService $notificationService
    ) {
        $this->responseFactory     = $responseFactory;
        $this->streamFactory       = $streamFactory;
        $this->notificationService = $notificationService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Get account
        $account = $request->getAttribute('account');

        // Set record params
        $params = [
            'user_id' => $account['id'],
        ];

        // Get list of notifications
        $result = $this->notificationService->getNotViewedCount($params);

        return new JsonResponse($result);
    }
}