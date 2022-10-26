<?php

declare(strict_types=1);

namespace App\Handler;

use Psr\Http\Message\ResponseInterface;
use Psr\Log\LoggerInterface;
use Slim\Exception\HttpBadRequestException;
use Slim\Http\Response;
use Slim\Http\ServerRequest as Request;

class CommandHandler
{
    private $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    /**
     * Example RPC-type endpoint. Assumes that command and data is POSTed to it, and then it's executed.
     */
    public function __invoke(Request $request, Response $response, array $args): ResponseInterface
    {
        $data = $request->getParsedBody();
        $this->logger->info('Command handler dispatched', ['posted_data' => $data]);

        $command = $data['command'] ?? '';
        if (!$command) {
            throw new HttpBadRequestException($request, 'Command parameter is missing');
        }

        // Do the work based on the $command that was sent

        return $response->withJson(['result' => "Executed $command"]);
    }
}
