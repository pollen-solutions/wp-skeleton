<?php

declare(strict_types=1);

use Pollen\Http\Response;
use Pollen\Kernel\ApplicationInterface;
use Pollen\Routing\RouterInterface;
use Pollen\Support\Env;

return static function (RouterInterface $router, ApplicationInterface $app) {
    if (Env::inDev()) {
        $router->get('/phpinfo', function () {
            ob_start();
            phpinfo();
            $content = ob_get_clean();
            return new Response($content);
        });
    }

    $router->get('/__demo', function () use ($app) {
        return view('__demo/index', ['name' => 'John Doe']);
    });
};