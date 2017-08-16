#!/bin/bash
set -e

if [[ ! -f /firstrun ]]; then 

    if [ "$FORCE_CHOWN_WWW" = true ]; then

        echo "Chown www-data on /var/www";
        chown -R www-data:www-data /var/www
    fi

    touch /firstrun
fi

exec docker-php-entrypoint "$@" 
