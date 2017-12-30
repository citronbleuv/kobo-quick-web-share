#!/bin/bash
set -e

if [[ ! -f /initialized ]]; then
    /prepare/init.sh
fi

exec docker-php-entrypoint "$@" 
