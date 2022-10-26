<?php

declare(strict_types=1);

use App\Handler\PingHandler;
use Slim\App;

return function (App $app) {
    $app->get('/[{name}]', PingHandler::class)->setName('home');
};
