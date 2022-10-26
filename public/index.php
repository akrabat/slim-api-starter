<?php

declare(strict_types=1);

use DI\ContainerBuilder;
use Slim\Factory\AppFactory;

require __DIR__ . '/../vendor/autoload.php';

// Set up DIC & configure it
$containerBuilder = new ContainerBuilder();
if(getenv('DI_COMPILATION_PATH')) {
    // compile the DI container for performance
    $diComplicationPath = getenv('DI_COMPILATION_PATH');
    if ($diComplicationPath[0] !== '/') {
        // Maybe it's relative to the app's root directory
        $diComplicationPath = __DIR__ . '/../' . $diComplicationPath;
    }
    if (is_dir($diComplicationPath)) {
        $containerBuilder->enableCompilation($diComplicationPath);
        $containerBuilder->writeProxiesToFile(true, $diComplicationPath . '/proxies');
    }
}
(require __DIR__ . '/../config/dependencies.php')($containerBuilder, array_merge($_ENV, $_SERVER));

// Create app
AppFactory::setContainer($containerBuilder->build());
$app = AppFactory::create();

// Register middleware
(require __DIR__ . '/../config/middleware.php')($app, array_merge($_ENV, $_SERVER));

// Register routes
(require __DIR__ . '/../config/routes.php')($app);

// Run app
$app->run();
