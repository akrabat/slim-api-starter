<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class HeartbeatHandler
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Simple endpoint to return the current date to help an integrator check that they can connect to the API.
     * If the `state` query parameter is provided, then return it.
     */
    public function __invoke(Request $request, Response $response, array $args): ResponseInterface
    {
        $data = [
            'date' => gmdate('Y-m-d\TH:i:sp')
        ];

        $state = $request->getParam('state', '');
        if ($state) {
            $data['state'] = $state;
        }

        $this->logger->info('Heartbeat handler dispatched', $data);

        return $response->withJson($data);
    }
}
