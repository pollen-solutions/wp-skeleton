<?php

declare(strict_types=1);

use Pollen\Kernel\ApplicationInterface;
use Pollen\Routing\RouterInterface;
use Pollen\Support\Env;
use Pollen\View\ViewManagerInterface;

return static function (ViewManagerInterface $view, ApplicationInterface $app) {
    $view
        // Use plates|twig as view engine
        ->setDefaultEngine('plates')
        ->setDirectory($app->getBasePath('/resources/views'))
        ->setCacheDir(!Env::inDev() ? $app->getBasePath('/var/cache/views') : null);

    $view->addExtension('url', function ($route_name, $route_parameters = [], $schemeRelative = false) use ($app) {
        /** @var RouterInterface $router */
        if ($router = $app->resolve(RouterInterface::class)) {
            echo $router->getNamedRouteUrl($route_name, $route_parameters, !$schemeRelative);
        }
    });
};
