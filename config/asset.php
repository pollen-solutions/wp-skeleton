<?php

declare(strict_types=1);

use Pollen\Asset\AssetManagerInterface;
use Pollen\Asset\Loaders\ViteDevManifestLoader;
use Pollen\Asset\Loaders\ViteBuildManifestLoader;
use Pollen\Asset\Types\TagJsType;
use Pollen\Kernel\ApplicationInterface;
use Pollen\Support\Env;

return static function (AssetManagerInterface $asset, ApplicationInterface $app) {
    $viteLoaded = false;
    if (Env::inDev()) {
        $devLoader = new ViteDevManifestLoader($app->getBasePath('resources/assets/manifest.json'));
        if ($devLoaded = $devLoader->load()) {
            $viteLoaded = true;

            foreach ($devLoaded as $type) {
                $asset->enqueueType($type);
            }
        }
    }

    //
    $buildLoader = new ViteBuildManifestLoader(
        $app->getPublicPath('manifest.json')
    );
    foreach ($buildLoader->load() as $handleName => $args) {
        $type = $args['type'];

        if ($type instanceof TagJsType) {
            $type->setHtmlAttrs(['defer', 'type' => 'module']);
            $asset->register($handleName, $type, true);
        } else {
            $asset->register($handleName, $type);
        }
    }

    if ($viteLoaded === false) {
        try {
            $asset->enqueueRegistered('app.js');
            $asset->enqueueRegistered('app.css');
        } catch (Throwable $e) {
            unset($e);
        }
    }

    $asset->enqueueCharset(get_bloginfo('charset'));
    $asset->enqueueMeta('viewport', 'width=device-width, initial-scale=1, shrink-to-fit=no, maximum-scale=1');
};