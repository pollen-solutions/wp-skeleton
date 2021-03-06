# Wordpress Skeleton

[![Latest Stable Version](https://img.shields.io/packagist/v/pollen-solutions/wp-skeleton.svg?style=for-the-badge)](https://packagist.org/packages/pollen-solutions/wp-skeleton)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)
[![PHP Supported Versions](https://img.shields.io/badge/PHP->=7.4-8892BF?style=for-the-badge&logo=php)](https://www.php.net/supported-versions.php)

**Wordpress Skeleton** Component provides structures of WordPress project based on Pollen Solutions suite.

## Table of contents

- [Directory structure](#Directory structure)
- [Features](#Features)
- [Installation](#Installation)
- [Configuration](#Configuration)

## Directory structure

### The Root directory structure

```
|–– bin
|–– config
|–– docker
|–– docs
|–– (node_modules)
|–– public
    |–– (assets)
    |–– languages
    |–– mu-plugins
    |–– plugins
    |–– themes
    |–– uploads
    |–– (wordpress)
|–– resources
    |–– assets
    |–– views
|–– src
    |–– Providers
    |–– App.php
|–– tests
|–– var
|–– (vendor)
```

### The Root directory

#### src

The ```src``` directory contains the core PHP code of your application.

#### resources

The ```resources``` directory contains the templating code. This included views and css, js, fonts, images and all other
assets files ...

#### public

The ```public``` directory contains the index.php file, which is the entry point for all requests entering your
application and configures autoload.

This directory also houses the build assets such css, js, fonts, images and all other assets files.

#### config

The ```config``` directory, as the name implies, contains all of your application's PHP configuration files.

#### docs

The ```docs``` directory contains the complete documentation of the micro framework and its components.

### The Application directory structure (src)

============
@todo
============

- Providers
- App.php

#### The Templating directory structure (resources)

============
@todo
============

- assets
- views


## Features

============
@todo
============

## Installation

```sh
composer create-project pollen-solutions/wp-skeleton project_name
```

## Environment configuration

During the installation process, the file ```.env.example``` is copied to ```.env```.
This file contains all required default configuration.

```dotenv
# ENVIRONMENT
APP_ENV=dev
APP_DEBUG=true
APP_URL=http://127.0.0.1:8000
APP_TIMEZONE=Europe/Paris

# DATABASE
DB_DRIVER=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wordpress
DB_USERNAME=root
DB_PASSWORD=
DB_PREFIX=wp_
```

You can directly edit this file, but the best practice is to create a new ```.env.local``` file that will contain all of
the configuration attributes specific to your installation.

Through the ```.env.local``` file you can if necessary override an environment value declared in the ```.env``` file or
define new ones :

```dotenv
# DATABASE
DB_DATABASE=pollen-solutions
DB_USERNAME=root
DB_PASSWORD=
DB_PREFIX=xyz_

#REDIS
REDIS_CLIENT=phpredis
REDIS_HOST=127.0.0.1
```

### .env syntax

```dotenv
STRING_VAR=string
QUOTES_VAR="quoted variable"
EMPTY_STRING=
BOOL_VAR=true
NULL_VAR=null
```

You can use another previously defined environment variable like this :

```dotenv
DB_USERNAME=root
DB_PASSWORD=${DB_USER}
```

Pollen solutions suite uses the **vlucas/phpdotenv** library to work. More information
on its [github repository](https://github.com/vlucas/phpdotenv).

### .env.local

============
@todo
============

### wp.config.local

============
@todo
============

### Serve the app

Serve your application using
the [built-in web server in PHP](https://www.php.net/manual/en/features.commandline.webserver.php) (or your server of
choice) from the ```public``` directory:

```shell
php -S 127.0.0.1:8000 -t public
```

Visit the application in the browser:

- [http://127.0.0.1:8000](http://127.0.0.1:8000)

## Configuration

============
@todo
============