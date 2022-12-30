# Docker

Pollen comes with a ready-to-use environment through Docker technology.

## Table of content

- [Bigfish](#bigfish)
  - [Configuring a Shell alias](#configuring-a-shell-alias)
  - [Docker compose commands](#docker-compose-commands)
  - [PHP Commands](#php-commands)
  - [Composer commands](#composer-commands)
  - [Previewing Emails](#previewing-emails)
  - [NodeJS commands](#nodejs-commands)
  - [NPM commands](#npm-commands)
  - [NPX commands](#npx-commands)
  - [Yarn commands](#yarn-commands)
  - [Application Console commands](#application-console-commands)
  - [Container CLI](#container-cli)
  - [Environnement variable command](#environnement-variable-command)
  - [Sharing your local application](#sharing-your-local-application)
  - [Displaying services information](#displaying-services-information)
- [Docker Compose](#docker-compose)
  - [Prerequisites](#prerequisites-1)
  - [Some use case](#some-use-case)

## BigFish

Bifish is a light-weight command-line interface for interacting with Docker development environment.
It draws on the work of Taylor Otwell and his team on [Laravel Sail](https://laravel.com/docs/sail).

### Configuring a Shell alias

By default, bigfish command-line are invoked using the ```bin/bigfish``` script.
Instead of repeatedly typing this instruction, configure a Bash alias may be a good alternative.

```sh
alias bigfish='[ -f bigfish ] && bash bigfish || bash bin/bigfish'
```

In the rest of this documentation, alias ```bigfish``` will be used instead of ```bin/bigfi.sh```.

### Docker compose commands

#### Install command

Building all containers and up them.

```sh
bigfish install
```

#### Uninstall command

Stop all containers and removes them.

```sh
bigfish uninstall
```

#### Reinstall command

Reinstalling the entire stack (uninstall and install).

```sh
bigfish reinstall
```

#### Build command

Building all containers.

```sh
bigfish build
```

Force rebuilding all containers with --no-cache flag.

```sh
bigfish build --no-cache
```

Building a specific container (e.g. php).

```sh
bigfish build php
```

#### Up command

Restart all containers.

```sh
bigfish up
```

Restart all containers in the background.

```sh
bigfish up -d
```

Restart a specific container (e.g. php).

```sh
bigfish up php
```

#### Flush command

Remove all orphans containers and restart the application.

```sh
bigfish flush
```

Remove all orphans containers and restart the application in the background.

```sh
bigfish flush -d
```

#### Stop command

Stop all containers.

```bash
bigfish stop
```

Stop a specific container (e.g. php).

```bash
bigfish stop php
```

#### Status command

Lists all containers statuses.

```bash
bigfish ps
```

Get a specific container status (e.g. php).

```bash
bigfish ps php
```

#### Logs command

Display the log of all containers.

```bash
bigfish logs
```

Display the log of all containers and follow.

```bash
bigfish logs -f
```

Display logs for a specific container logs(e.g. php).

```bash
bigfish logs php
```

#### IPs helper command

List the docker network ips of all containers.

```bash
bigfish ips
```

### PHP Commands

Get the PHP command-line help.

```bash
bigfish php
```

Execute a specific PHP command (e.g. Display version)

```bash
bigfish php -v
```

### Composer commands

Composer is a package manager for PHP libraries.

#### Show help

```bash
bigfish composer
```

#### List installed dependencies

```bash
bigfish composer show
```

#### Update dependencies

```bash
bigfish composer update
```

#### Add a new dependency (e.g. Monolog)

```bash
bigfish composer require monolog/monolog
```

#### Remove dependency (e.g. Monolog)

```bash
bigfish composer remove monolog/monolog 
```

### Previewing Emails

Get the SMTP (Mailhog) command-line help.

```bash
bigfish smtp
```

#### Send a mail

```bash
bigfish smtp sendmail --smtp-addr="smtp:1025" <<EOF
From: Sender SampleName <from@example.com>
To: Recipient SampleName <to@example.com>
Subject: Hello World !

Hey there,

It's works

Bye
EOF
```

### NodeJS commands

Get the NodeJS command-line help.

```bash
bigfish node
```

Execute a specific NodeJS command (e.g. Display version)

```bash
bigfish node -v
```

### NPM commands

#### Display help

```bash
bigfish npm
```

#### List installed dependencies

```bash
bigfish npm la
```

#### Update dependencies

```bash
bigfish npm update
```

#### List outdated dependencies

```bash
bigfish npm outdated
```

#### Upgrade outdated dependencies

```bash
bigfish npm upgrade 
```

#### Add new dependency (e.g. lodash)

```bash
bigfish npm i lodash
```

For development dependency, use -D flag (e.g. @babel/core)

```bash
bigfish npm i @babel/core -D
```

#### Remove dependency (e.g. lodash)

```bash
bigfish npm r lodash
```

### NPX commands

#### Show help

```bash
bigfish npx
```

#### Execute command (e.g. building assets with viteJS)

```bash
bigfish npx vite build
```

### Yarn commands

#### Display help

```bash
bigfish yarn
```

#### Execute command (e.g. displaying version)

```bash
bigfish yarn -v
```

### Application Console commands

#### Get the Application command-line help.

```bash
bigfish console
```

#### Execute a specific command (e.g. demo:styles)

```bash
bigfish console demo:styles
```

### Container CLI

#### Open a shell for the PHP default container.

```bash
bigfish shell
```

#### Open a shell for a specific container (e.g. node).

```bash
bigfish shell node
```

### Environnement variable command

#### List all variables

```bash
bigfish env
```

#### Show specific variable

```bash
bigfish env LOCAL_USERNAME
```

### Sharing your local application

It may be convenient to share your application publicly, for testing purposes or because some third-party services may
need to access your application int the background.
The online service provided by [expose.dev](https://expose.dev) allows you to create a secure tunnel to expose publicly
your local application on the web.

#### Prerequisites

1. Previously you must create a free account [Create a free account in expose.dev](https://expose.dev/register) and get
   your personal token.
2. Edit your ```.env``` or ```.env.local``` file and add :

```dotenv
EXPOSE_SHARE_TOKEN=your-personal-token
```

#### Start sharing

```bash
bigfish share
```

### Displaying services information

```bash
bigfish info
```

## Docker-compose

Instead of Bigfish CLI, for experienced users, all docker-compose commands are available from the root of the project.

### Prerequisites

The ```docker-compose.yml``` requires environnement variables. Before issuing the command ```docker-compose``` you must
sourcing your terminal session.

```bash
source bin/docker-compose.env.sh
```

And check config with :

```bash
docker-compose config
```

### Some use case

#### Logs (e.g. php)

```bash
docker-compose logs -f php
```

#### Composer

```bash
docker-compose exec php composer show
```

#### NPM

```bash
docker-compose exec node npm la
```