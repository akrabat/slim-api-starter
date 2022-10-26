<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Monolog\Handler\ErrorLogHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

return static function (ContainerBuilder $containerBuilder, array $env) {
    $containerBuilder->addDefinitions([
        LoggerInterface::class => function (ContainerInterface $c) {
            $processors = [
                new UidProcessor()
            ];

            $handlers = ($env['IS_CLI'] ?? false)
                ? [new StreamHandler('php://stderr')]
                : [new ErrorLogHandler()];

            return new Logger('app', $handlers, $processors);
        },
    ]);
};
