#!/bin/bash
set -e

mkdir -p /var/www/symfony/data

# Install vendors
gosu www-data composer install

# Configure App
chown -R www-data:www-data /var/www

touch /initialized
