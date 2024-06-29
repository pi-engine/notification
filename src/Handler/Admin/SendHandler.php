<?php

namespace Notification\Handler\Admin;

use Fig\Http\Message\StatusCodeInterface;
use Laminas\Diactoros\Response\JsonResponse;
use Notification\Service\NotificationService;
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
        // Retrieve the raw JSON data from the request body
        $stream      = $this->streamFactory->createStreamFromFile('php://input');
        $rawData     = $stream->getContents();
        $requestBody = json_decode($rawData, true);

        // Check if decoding was successful
        if (json_last_error() !== JSON_ERROR_NONE) {
            // JSON decoding failed
            $errorResponse = [
                'result' => false,
                'data'   => null,
                'error'  => [
                    'message' => 'Invalid JSON data',
                ],
            ];
            return new JsonResponse($errorResponse, StatusCodeInterface::STATUS_UNAUTHORIZED);
        }

        // Send notification
        $this->notificationService->send($requestBody);

        // Set result
        $result = [
            'result' => true,
            'data'   => [
                'message' => 'Message sent successfully !',
            ],
            'error'  => [],
        ];

        return new JsonResponse($result, $result['status'] ?? StatusCodeInterface::STATUS_OK);
    }
}