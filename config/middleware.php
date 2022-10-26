<?php

declare(strict_types=1);

use App\Middleware\AuthorizationMiddleware;
use App\Middleware\DefaultAcceptHeaderMiddleware;
use Slim\App;

return static function (App $app, array $env) {
    // Slim middleware is last-in, first-out
    // i.e. the last one on this list is the outermost middleware and should be the error handler.

    $app->addRoutingMiddleware();
    $app->addBodyParsingMiddleware();
    $app->addMiddleware(new DefaultAcceptHeaderMiddleware());
    $app->addErrorMiddleware((bool)($env['DISPLAY_ERROR_DETAILS'] ?? false), (bool)($env['LOG_ERRORS'] ?? true), true);
};
