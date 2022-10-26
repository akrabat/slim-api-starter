<?php

namespace App\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Slim\Exception\HttpUnauthorizedException;
use Slim\Http\ServerRequest;

class AuthorizationMiddleware implements MiddlewareInterface
{
    /**
     * Middleware that checks for an Authorization header of the format: "token {unique-string}".
     * Note that it assumes that {unique-string} does not contain spaces.
     *
     * @param ServerRequest $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        // Check the Authorization header for "token" authentication scheme
        [$scheme, $token] = explode(' ', $request->getHeaderLine('Authorization') . ' ');
        if (strtolower($scheme) !== 'token') {
            throw new HttpUnauthorizedException($request, "Please provide a valid Authorization header");
        }

        // Check $token is valid
        $validTokens = ['abc123', '987zyx']; // valid tokens hardcoded in example, but should come from elsewhere
        if (!in_array($token, $validTokens, true)) {
            throw new HttpUnauthorizedException($request, "Invalid token in Authorization header");
        }

        return $handler->handle($request);
    }
}
