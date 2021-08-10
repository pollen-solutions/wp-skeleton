<?php

use Pollen\WpKernel\WpApplicationInterface;

if(function_exists('app') && ($app = app()) && $app instanceof WpApplicationInterface) {
    $app->build();
}

