# See https://github.com/docker-library/php/blob/4677ca134fe48d20c820a19becb99198824d78e3/7.0/fpm/Dockerfile
FROM php:7.1.8-fpm

MAINTAINER Anthony PAUSE <anthony.pause@gmail.com>

RUN apt-get update && apt-get install -y \
    git \
    unzip

RUN pecl install xdebug

# Args
ARG uid
ARG gid

# User www-data UID/GID
RUN groupmod -g $uid www-data && \
    usermod -u $gid -g www-data www-data

# Set timezone
RUN rm /etc/localtime && \
    ln -s /usr/share/zoneinfo/Europe/Paris /etc/localtime && \
    "date"

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer --version

# Type docker-php-ext-install to see available extensions
RUN docker-php-ext-install pdo pdo_mysql && \
    docker-php-ext-enable xdebug 

# NPM and gulp install
RUN apt-get update && apt-get install -y npm && \
	npm install -g gulp && \
	npm install -g bower

# Config xdebug
RUN echo "error_reporting = E_ALL" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "display_startup_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "display_errors = On" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.remote_enable=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.remote_connect_back=1" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.idekey=\"PHPSTORM\"" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini && \
    echo "xdebug.remote_port=9001" >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini

# Alias
RUN echo 'alias sf="php app/console"' >> ~/.bashrc && \
    echo 'alias sf3="php bin/console"' >> ~/.bashrc

# Scripts
ADD docker/php7-fpm/scripts /scripts
RUN chmod +x /scripts/*;

WORKDIR /var/www/symfony

ENV FORCE_CHOWN_WWWW=false

ENTRYPOINT ["/scripts/entrypoint.sh"]
CMD ["php-fpm"]
