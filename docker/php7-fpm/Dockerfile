# See https://github.com/docker-library/php/blob/4677ca134fe48d20c820a19becb99198824d78e3/7.0/fpm/Dockerfile
FROM php:7.1.8-fpm

MAINTAINER Anthony PAUSE <anthony.pause@gmail.com>

# Install Packages
RUN set -x && \
    apt-get update && \
    apt-get -y upgrade && \
    apt-get -y install --no-install-recommends git

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer --version

# Install Gosu
RUN gpg --keyserver pool.sks-keyservers.net --recv-keys B42F6819007F00F88E364FD4036A9C25BF357DD4 \
    && curl -o /usr/local/bin/gosu -SL "https://github.com/tianon/gosu/releases/download/1.2/gosu-amd64" \
    && curl -o /usr/local/bin/gosu.asc -SL "https://github.com/tianon/gosu/releases/download/1.2/gosu-amd64.asc" \
    && gpg --verify /usr/local/bin/gosu.asc \
    && rm /usr/local/bin/gosu.asc \
    && rm -r /root/.gnupg/ \
    && chmod +x /usr/local/bin/gosu

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

# Prepare
ADD docker/php7-fpm/prepare /prepare
RUN chmod +x /prepare/*;

WORKDIR /var/www/symfony

ENTRYPOINT ["/prepare/run.sh"]
CMD ["php-fpm"]
