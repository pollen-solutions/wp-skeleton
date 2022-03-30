<?php

declare(strict_types=1);

use Pollen\Asset\AssetManagerInterface;
use Pollen\Asset\Loaders\ViteDevManifestLoader;
use Pollen\Asset\Loaders\ViteBuildManifestLoader;
use Pollen\Asset\Types\TagCssType;
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
                asset()->enqueueType($type);
            }
        }
    }

    if ($viteLoaded === false) {
        $buildLoader = new ViteBuildManifestLoader(
            $app->getPublicPath('assets/manifest.json'),
            '/assets'
        );
        foreach ($buildLoader->load() as $type) {
            if ($type instanceof TagJsType) {
                asset()->enqueueJs($type->getPath(), ['defer'], true);
            } elseif ($type instanceof TagCssType) {
                asset()->enqueueCss($type->getPath());
            }
        }
    }
};