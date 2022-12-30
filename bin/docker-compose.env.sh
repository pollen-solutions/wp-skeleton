#!/usr/bin/env bash

# !! DO NOT MODIFY THIS FILE !!

# Source the ".project.env" file if it is available...
if [ -f ./docker/conf/.project.env ]; then
  source ./docker/conf/.project.env 2>/dev/null
fi

if [ -f .env ]; then
  source .env 2>/dev/null
fi

if [ -f .env.local ]; then
  source .env.local 2>/dev/null
fi

# Define environment variables...
## Project
export PROJECT_NAME=${PROJECT_NAME:-$(basename $(pwd))}
## Local user
export LOCAL_USERNAME=${LOCAL_USERNAME:-$(id -un)}
export LOCAL_UID=${LOCAL_UID:-$(id -u)}
export LOCAL_GID=${LOCAL_UID:-$(id -g)}
## MySql
export MYSQL_ROOT_PASSWORD=${MYSQL_ROOT_PASSWORD:-root}
export MYSQL_DATABASE=${MYSQL_DATABASE:-${PROJECT_NAME}}
export MYSQL_USER=${MYSQL_USER:-${PROJECT_NAME}}
export MYSQL_PASSWORD=${MYSQL_USER:-${PROJECT_NAME}}
## Expose
export EXPOSE_SHARE_SERVER_HOST=${EXPOSE_SHARE_SERVER_HOST:-"eu-1.sharedwithexpose.com"}
export EXPOSE_SHARE_SERVER_PORT=${EXPOSE_SHARE_SERVER_PORT:-""}
export EXPOSE_SHARE_SUBDOMAIN=${EXPOSE_SHARE_SUBDOMAIN:-"${PROJECT_NAME}"}
export EXPOSE_SHARE_TOKEN=${EXPOSE_SHARE_TOKEN:-""}