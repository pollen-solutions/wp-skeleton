<?php

declare(strict_types=1);

use Pollen\Http\Response;
use Pollen\Kernel\ApplicationInterface;
use Pollen\Routing\RouterInterface;
use Pollen\Support\Env;

return static function (RouterInterface $router, ApplicationInterface $app) {
    $router->get('/__demo', function () use ($app) {
        return view('__demo/index', ['name' => 'John Doe']);
    });

    if (Env::inDev()) {
        $router->get('/__demo/phpinfo', function () {
            ob_start();
            phpinfo();
            $content = ob_get_clean();
            return new Response($content);
        });
    }
};