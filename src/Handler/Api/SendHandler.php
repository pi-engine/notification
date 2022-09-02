<?php

namespace Notification\Handler\Api;

use Laminas\Diactoros\Response\JsonResponse;
use Notification\Service\SendService;
use Psr\Http\Message\ResponseFactoryInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\StreamFactoryInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Notification\Service\NotificationService;

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
        StreamFactoryInterface   $streamFactory,
        NotificationService      $notificationService,
        SendService      $sendService
    )
    {
        $this->responseFactory = $responseFactory;
        $this->streamFactory = $streamFactory;
        $this->notificationService = $notificationService;
        $this->sendService = $sendService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        // Get account
        $account = $request->getAttribute('account');

        // Get request body
        $requestBody = $request->getParsedBody();


//        $result = $this->notificationService->sendNotification($requestBody, $account);




        ///TODO: must resolve

        switch ($requestBody["action"]){
            ///test store message in draft
            case "draft":
                $result =  $this->notificationService->draft($requestBody, $account);
                break;
            case "send":
                $result =  $this->sendService->sendNotification($requestBody, $account);
                break;
            default:
                $result = [];
                break;
        }

        // Get record
        // $result = [];

        // Set result
        $result = [
            'result' => true,
            'data' => $result,
            'error' => [],
        ];

        return new JsonResponse($result);
    }
}