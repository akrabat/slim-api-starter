<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Http\ServerRequest;

class DefaultAcceptHeaderMiddleware implements MiddlewareInterface
{
    /**
     * @param ServerRequest $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Set the Accept header to 'application/json' if it has not been set by the client (or is set to "everything").
        if (empty($request->getHeaderLine('Accept')) || $request->getHeaderLine('Accept') === '*/*') {
            $request = $request->withHeader('Accept', 'application/json');
        }

        return $handler->handle($request);
    }
}
