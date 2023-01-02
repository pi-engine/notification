<?php

namespace Notification\Handler\Api;

use Laminas\Diactoros\Response\JsonResponse;
use Notification\Service\NotificationService;
use Notification\Service\SendService;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;

class SendHandler implements RequestHandlerInterface
{
    /** @var ResponseFactoryInterface */
    protected ResponseFactoryInterface $responseFactory;

    /** @var StreamFactoryInterface */
    protected StreamFactoryInterface $streamFactory;

    /** @var NotificationService */
    protected NotificationService $notificationService;

    /** @var SendService */
    protected SendService $sendService;


    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        NotificationService $notificationService,
        SendService $sendService
    ) {
        $this->responseFactory     = $responseFactory;
        $this->streamFactory       = $streamFactory;
        $this->notificationService = $notificationService;
        $this->sendService         = $sendService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Get account
        $account = $request->getAttribute('account');

        // Get request body
        $requestBody = $request->getParsedBody();

        // Set params
        $params = [
            'mail' => [

            ],
            'sms'  => [

            ],
            'push' => [

            ],
        ];

        // Send notification
        $result = $this->notificationService->send($params);

        return new JsonResponse($result);
    }
}