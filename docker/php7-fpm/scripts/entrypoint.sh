#!/bin/bash
set -e

if [[ ! -f /firstrun ]]; then 

    mkdir -p /var/www/symfony/data

    if [ "$FORCE_CHOWN_WWW" = true ]; then

        echo "Chown www-data on /var/www";
        chown -R www-data:www-data /var/www

    else

        chown -R www-data:www-data /var/www/symfony/data

    fi

    touch /firstrun
fi

exec docker-php-entrypoint "$@" 
