<?php

declare(strict_types=1);

use App\Handler\CommandHandler;
use App\Handler\HeartbeatHandler;
use App\Middleware\AuthorizationMiddleware;
use Slim\App;
use Slim\Interfaces\RouteCollectorProxyInterface;

return function (App $app) {
    $app->get('/heartbeat', HeartbeatHandler::class);

    // Group all routes that require authorization
    $app->group('', function (RouteCollectorProxyInterface $group) {
        $group->post('/', CommandHandler::class);
    })->addMiddleware(new AuthorizationMiddleware());
};
