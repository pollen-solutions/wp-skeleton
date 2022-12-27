#!/usr/bin/env bash

if ! [ -x "$(command -v docker-compose)" ]; then
  shopt -s expand_aliases
  alias docker-compose='docker compose'
fi

UNAMEOUT="$(uname -s)"

WHITE='\033[1;37m'
NC='\033[0m'

# Verify operating system is supported.
case "${UNAMEOUT}" in
Linux*) MACHINE=linux ;;
Darwin*) MACHINE=mac ;;
*) MACHINE="UNKNOWN" ;;
esac

if [ "$MACHINE" == "UNKNOWN" ]; then
  echo "Unsupported operating system [$(uname -s)]. Supports macOS, Linux, and Windows (WSL2)." >&2
  exit 1
fi

# Source the ".env" file if it is available...
if [ -f ./.env ]; then
  source ./.env 2> /dev/null
fi

# Define environment variables...
export APP_PROJECT=${APP_PROJECT:-"wordpress-skeleton"}
export LOCAL_UID=${LOCAL_UID:-$(id -u)}
export LOCAL_GID=${LOCAL_UID:-$(id -g)}
export LOCAL_USER=${LOCAL_USER:-$(id -un)}

# Function that outputs is not running...
function not_running {
  echo -e "${WHITE}Not running.${NC}" >&2
  exit 1
}

# docker-compose function shortcut
function dc() {
  docker-compose -p "$APP_PROJECT" "$@"
}

if [ -z "$SKIP_CHECKS" ]; then
  # Ensure that Docker is running...
  if ! docker info >/dev/null 2>&1; then
    echo -e "${WHITE}Docker is not running.${NC}" >&2
    exit 1
  fi

  # Determine if is currently up...
  PSRESULT="$(dc ps -q)"
  if docker-compose ps | grep "$APP_PROJECT" | grep 'Exit'; then
    echo -e "${WHITE}Shutting down old processes...${NC}" >&2

    docker-compose down >/dev/null 2>&1

    EXEC="no"
  elif [ -n "$PSRESULT" ]; then
    EXEC="yes"
  else
    EXEC="no"
  fi
else
  EXEC="yes"
fi

if [ $# -gt 0 ]; then
  # Installing project
  if [ "$1" == "install" ]; then
    shift 1
    dc build \
      && dc up -d --remove-orphans

  # Uninstalling project
  elif [ "$1" == "uninstall" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc down --remove-orphans -v
    else
      not_running
    fi

  # Reinstalling project
  elif [ "$1" == "reinstall" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc down --remove-orphans -v \
        && dc build --no-cache \
        && dc up -d --remove-orphans
    else
      not_running
    fi

  # Builds docker images
  elif [ "$1" == "build" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc build --no-cache "$@"
    else
      not_running
    fi

  # Starts all containers or a specific container if necessary
  elif [ "$1" == "up" ]; then
    shift 1
    dc up -d --remove-orphans "$@"

  # Stops all containers or a specific container
  elif [ "$1" == "stop" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc stop "$@"
    else
      not_running
    fi

  # Lists all container statuses or for a specific container
  elif [ "$1" == "ps" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc ps "$@"
    else
      not_running
    fi

  # Displays and follows all container logs or for a specific container
  elif [ "$1" == "logs" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc logs -f "$@"
    else
      not_running
    fi

  # Opens a container shell
  elif [ "$1" == "shell" ] || [ "$1" == "bash" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc run --rm "${@:-php}" /bin/bash
    else
      not_running
    fi

  # Displays container IPs
  elif [ "$1" == "ips" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      docker inspect -f '{{.Name}} {{range .NetworkSettings.Networks}}{{.IPAddress}}{{end}}' \
        $(dc ps -aq) |
        column -t |
        sed 's#/##g' |
        sort -t . -k 1,1n -k 2,2n -k 3,3n -k 4,4n
    else
      not_running
    fi

  # Returns PHP command line help or launch a PHP specified command
  elif [ "$1" == "php" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc run --rm php "${@:--h}"
    else
      not_running
    fi

  # Returns NodeJs command line help or launch a NodeJS specified command
  elif [ "$1" == "node" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc run --rm node "${@:--h}"
    else
      not_running
    fi

  # Returns Mailhog command line help or launch a Mailhog specified command
  elif [ "$1" == "smtp" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc run --rm smtp "${@:--h}"
    else
      not_running
    fi

  ## Returns Composer command line help or launch a Composer specified command
  elif [ "$1" == "composer" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc run --rm php composer "${@:--h}"
    else
      not_running
    fi

  ## Returns NPM command line help or launch a NPM specified command
  elif [ "$1" == "npm" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc run -p 3000:3000 --rm node npm "${@:-help}"
    else
      not_running
    fi

  ## Returns NPX command line help or launch a NPX specified command
  elif [ "$1" == "npx" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc run --rm node npx "${@:--h}"
    else
      not_running
    fi

  ## Returns YARN command line help or launch a YARN specified command
  elif [ "$1" == "yarn" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc run --rm node yarn "${@:--h}"
    else
      not_running
    fi

  # Returns App Console command line or launch a App Console specified command
  elif [ "$1" == "console" ]; then
    shift 1
    if [ "$EXEC" == "yes" ]; then
      dc run --rm php php bin/console "${@:--v}"
    else
      not_running
    fi

  elif [ "$1" == "print" ]; then
    shift 1
    if [ -z "$1" ]; then
      echo "ENV arg required"
    else
      echo "$1=${!1}"
    fi

  # Pass unknown commands to the "docker-compose" binary...
  else
    dc "$@"
  fi
else
  dc ps
fi
