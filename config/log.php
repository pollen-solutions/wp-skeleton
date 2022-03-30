<?php

declare(strict_types=1);

use Pollen\Kernel\ApplicationInterface;
use Pollen\Log\LogManagerInterface;

return static function (LogManagerInterface $log, ApplicationInterface $app) {
    $log->setDefaultStoragePath($app->getBasePath('var/log'));
};