<?php

namespace Notification\Handler\Api;

use Laminas\Diactoros\Response\JsonResponse;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Notification\Service\NotificationService;

class DashboardHandler implements RequestHandlerInterface
{
    /** @var ResponseFactoryInterface */
    protected ResponseFactoryInterface $responseFactory;

    /** @var StreamFactoryInterface */
    protected StreamFactoryInterface $streamFactory;

    /** @var NotificationService */
    protected NotificationService $adjustmentService;



    public function __construct(
        ResponseFactoryInterface $responseFactory,
        StreamFactoryInterface $streamFactory,
        NotificationService $adjustmentService
    )
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->adjustmentService = $adjustmentService;
    }
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Get account
        $account = $request->getAttribute('account');

        // Set record params
        $params = [
            'user_id' => $account['id'],
        ];



        // Get record
        $result = [];

        // Set result
        $result = [
            'result' => true,
            'data'   => $result,
            'error'  => [],
        ];

        return new JsonResponse($result);
    }
}