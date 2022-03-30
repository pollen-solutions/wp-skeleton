<?php

declare(strict_types=1);

//error_reporting(-1);
//ini_set('display_errors', 'On');

defined('START_TIME') ?: define('START_TIME', microtime(true));

require_once dirname(__DIR__) . '/vendor/autoload.php';

$app = require __DIR__.'/../bootstrap/app.php';

require_once(ABSPATH . 'wp-settings.php');