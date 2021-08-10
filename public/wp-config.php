<?php

use App\App;

defined('START_TIME') ?: define('START_TIME', microtime(true));

require_once dirname(__DIR__) . '/vendor/autoload.php';

new App(dirname(__DIR__));

require_once(ABSPATH . 'wp-settings.php');