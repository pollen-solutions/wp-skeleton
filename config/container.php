<?php

declare(strict_types=1);

use Pollen\Asset\AssetManager;
use Pollen\Asset\AssetManagerInterface;
use Pollen\Asset\AssetServiceProvider;
use Pollen\Console\Console;
use Pollen\Console\ConsoleInterface;
use Pollen\Console\ConsoleServiceProvider;
use Pollen\Container\Container;
use Pollen\Container\ContainerInterface;
use Pollen\Debug\DebugManager;
use Pollen\Debug\DebugManagerInterface;
use Pollen\Debug\DebugServiceProvider;
use Pollen\Event\EventDispatcher;
use Pollen\Event\EventDispatcherInterface;
use Pollen\Event\EventServiceProvider;
use Pollen\Faker\Faker;
use Pollen\Faker\FakerInterface;
use Pollen\Faker\FakerServiceProvider;
use Pollen\Http\Request;
use Pollen\Http\RequestInterface;
use Pollen\Kernel\ApplicationInterface;
use Pollen\Kernel\ApplicationEmitterInterface;
use Pollen\Kernel\ApplicationRequestHandlerInterface;
use Pollen\Kernel\Http\HttpKernel;
use Pollen\Kernel\Http\HttpKernelInterface;
use Pollen\Http\HttpServiceProvider;
use Pollen\Log\LogManager;
use Pollen\Log\LogManagerInterface;
use Pollen\Log\LogServiceProvider;
use Pollen\Routing\Router;
use Pollen\Routing\RouterInterface;
use Pollen\Routing\RoutingServiceProvider;
use Pollen\Validation\Validator;
use Pollen\Validation\ValidatorInterface;
use Pollen\Validation\ValidationServiceProvider;
use Pollen\View\ViewManager;
use Pollen\View\ViewManagerInterface;
use Pollen\View\ViewServiceProvider;
use Pollen\ViewExtends\ViewExtendsServiceProvider;
use Psr\Container\ContainerInterface as PsrContainer;
use Psr\EventDispatcher\EventDispatcherInterface as PsrEventDispatcher;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Log\LoggerInterface;

return static function (ContainerInterface $container, ApplicationInterface $app) {
    // CONFIGURATION
    $container->enableAutoWiring();
    $container->defaultToShared();

    // SERVICE PROVIDERS
    // -- Components
    $container->addServiceProvider(new AssetServiceProvider());
    $container->addServiceProvider(new ConsoleServiceProvider());
    $container->addServiceProvider(new DebugServiceProvider());
    $container->addServiceProvider(new EventServiceProvider());
    $container->addServiceProvider(new FakerServiceProvider());
    $container->addServiceProvider(new HttpServiceProvider());
    $container->addServiceProvider(new LogServiceProvider());
    $container->addServiceProvider(new RoutingServiceProvider());
    $container->addServiceProvider(new ValidationServiceProvider());
    $container->addServiceProvider(new ViewServiceProvider());
    $container->addServiceProvider(new ViewExtendsServiceProvider());

    // -- Application
    // [...]

    // ALIASES
    $aliases = [
        ApplicationInterface::class     => [
            'app',
            'container',
            Container::class,
            ContainerInterface::class,
            PsrContainer::class,
        ],
        AssetManagerInterface::class    => [
            'assets',
            AssetManager::class,
        ],
        ConsoleInterface::class         => [
            'console',
            Console::class,
        ],
        DebugManagerInterface::class    => [
            'debug',
            DebugManager::class,
        ],
        EventDispatcherInterface::class => [
            'event',
            EventDispatcher::class,
            PsrEventDispatcher::class,
        ],
        FakerInterface::class           => [
            'faker',
            Faker::class,
        ],
        HttpKernelInterface::class      => [
            'http-kernel',
            HttpKernel::class,
        ],
        LogManagerInterface::class      => [
            'log',
            LogManager::class,
            LoggerInterface::class,
        ],
        RouterInterface::class          => [
            'router',
            Router::class,
            // Required by kernel
            ApplicationEmitterInterface::class,
            ApplicationRequestHandlerInterface::class
        ],
        RequestInterface::class         => [
            'request',
            Request::class,
        ],
        ServerRequestInterface::class   => [
            'psr_request',
        ],
        ValidatorInterface::class       => [
            'validator',
            Validator::class,
        ],
        ViewManagerInterface::class     => [
            'view',
            ViewManager::class,
        ],
    ];

    foreach ($aliases as $definitionAlias => $altAliases) {
        foreach ($altAliases as $altAlias) {
            $container->addAlias($definitionAlias, $altAlias);
        }
    }
};
