# Wordpress Skeleton

[![Latest Stable Version](https://img.shields.io/packagist/v/pollen-solutions/wp-skeleton.svg?style=for-the-badge)](https://packagist.org/packages/pollen-solutions/wp-skeleton)
[![MIT Licensed](https://img.shields.io/badge/license-MIT-green?style=for-the-badge)](LICENSE.md)
[![PHP Supported Versions](https://img.shields.io/badge/PHP->=7.4-8892BF?style=for-the-badge&logo=php)](https://www.php.net/supported-versions.php)

**WordPress Skeleton** Component provides structures of WordPress project based on Pollen Solutions suite.

## Table of contents

- [Features](#features)
- [Installation](#installation)
- [Configuration](#configuration)
- [Directory structure](#directory-structure)

## Features

The Pollen solutions **Wordpress Skeleton** component embeds :

- [Composer](https://getcomposer.org/), as package manager for PHP libraries.
- [ViteJS](https://vitejs.dev/) as assets bundler and responsible for compiling, transpilating, versioning,
  optimizing ...
- [Pollen solutions components suite](https://github.com/pollen-solutions) that includes :
    - A dependency injection container
    - A routing system
    - A templating library
    - An asset manager and injector
    - An expandable command line interface
    - An event manager
    - ...
- A preconfigured docker environment
- ... And a lot of other kinds of magic !

This is undoubtedly one of the best solutions to easily develop application with the WordPress couple and good PHP
practices.

To try it is already to contribute, you are welcome !

## Installation

### Standard installation

#### Prerequisite

- **PHP** must be installed on your machine [see details](https://www.php.net/manual/install.php).
- **Composer** must be installed on your machine [see details](https://getcomposer.org/download/).

#### Launch installation

```sh
composer create-project pollen-solutions/wp-skeleton your-app-name
```

#### Serve the app

Serve your application using
the [built-in web server in PHP](https://www.php.net/manual/en/features.commandline.webserver.php) (or your server of
choice) from the ```public``` directory:

```sh
php -S 127.0.0.1:8000 -t public
```

Visit the application in the browser:

- [http://127.0.0.1:8000](http://127.0.0.1:8000)

### Docker installation

#### Prerequisite

- Docker must be installed on your machine [see details](https://docs.docker.com/get-docker/)

#### Launch installation

Clone projet from the [github repository](https://github.com/pollen-solutions/wp-skeleton)

```sh
git clone git@github.com:pollen-solutions/wp-skeleton.git
```

Launch application builder

```sh
bin/app.build
```

Visit the application in the browser:

- [http://127.0.0.1:8000](http://127.0.0.1:8000)

Retrieve [More details about docker usage](docs/Docker.md) in a Pollen application from the built-in documentation.

## Configuration

### Environment configuration

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

### .env.local

To customize your application configuration, you can directly edit the ```.env``` file, but the best practice is to
create a new ```.env.local``` file that will contain all the configuration attributes specific to your installation.
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

You can use another existing global or previously defined environment variable like this :

```dotenv
DB_USERNAME=${MYSQL_USER}
DB_PASSWORD=${MYSQL_PASSWORD}
```

Note that, for security reasons, global environnement variables couldn't be overridden.

### .env merge vars

In some special cases, you may need to access application data to complete the
configuration of your environment variables and the merge vars could help you.

The paths of the application are natively available :

- ```%%app.base_dir%%```: Absolute path to the root directory of the app.

- ```%%app.public_dir%%```: Absolute path to the public directory of the app.

Example of usage :

```dotenv
DATABASE_URL=sqlite:///%%app.base_dir%%/var/database.sqlite
```

Pollen solutions suite uses the **vlucas/phpdotenv** library to work. More information
on its [github repository](https://github.com/vlucas/phpdotenv).

### wp-config.local.php

Another way to configure your application is to create at the root of the application directory a file
```wp-config.local.php```.
Its syntax is similar to that of the native WordPress file ```wp-config.php```.
[More details](https://wordpress.org/support/article/how-to-install-wordpress/#step-3-set-up-wp-config-php) on the
official WordPress setup page.

## Directory structure

The **WordPress Skeleton** component is a micro-framework to work with the Wordpress CMS.
Like other solutions of this type, it is opinionated and its directory structure is intended to provide a starting point
for creating a complete web application.

### The Root directory structure

```
|–– bin
|–– bootstrap
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
|–– tests
|–– var
|–– (vendor)
```

### The Root directory

#### src

The ```src``` directory contains the core PHP code of your application.

#### resources

The ```resources``` directory contains the templating code. This included views and css, js, fonts, images and all other
assets files.

#### public

The ```public``` directory contains the index.php file, which is the entry point for all requests entering your
application and configures autoload.

This directory also houses the build assets such css, js, fonts, images and all other assets files.

#### config

The ```config``` directory, as the name implies, contains all of your application's PHP configuration files.

#### docs

The ```docs``` directory contains the complete documentation of the micro framework and its components. 
Work in progress ;)