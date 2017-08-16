FROM debian:jessie

MAINTAINER Anthony PAUSE <anthony.pause@gmail.com>

RUN apt-get update && apt-get install -y \
    nginx

# Args
ARG uid
ARG gid

# User www-data UID/GID
RUN groupmod -g $uid www-data && \
    usermod -u $gid -g www-data www-data

# Configure
ADD docker/nginx/configs/nginx.conf /etc/nginx/
ADD docker/nginx/configs/symfony.conf /etc/nginx/sites-available/

RUN ln -s /etc/nginx/sites-available/symfony.conf /etc/nginx/sites-enabled/symfony && \
    rm /etc/nginx/sites-enabled/default

RUN echo "upstream php-upstream { server php:9000; }" > /etc/nginx/conf.d/upstream.conf

EXPOSE 80
EXPOSE 443

CMD ["nginx"]
