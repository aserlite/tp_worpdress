ARG PHP_VERSION
ARG ALPINE_VERSION

FROM php:${PHP_VERSION}-fpm-alpine${ALPINE_VERSION}

USER root

ARG XDEBUG_VERSION

RUN echo "UTC+2" > /etc/timezone

RUN apk --no-cache add git nano bash curl redis shadow automake iproute2 libstdc++ gettext \
    linux-headers && \
    apk add --no-cache --virtual .build-deps $PHPIZE_DEPS && \
    pecl install redis xdebug-${XDEBUG_VERSION} \
    && docker-php-ext-enable redis \
    && apk del .build-deps

# SETUP PHP-FPM CONFIG SETTINGS (max_children / max_requests)
RUN echo 'pm.max_children = 15' >> /usr/local/etc/php-fpm.d/zz-docker.conf && \
    echo 'pm.max_requests = 500' >> /usr/local/etc/php-fpm.d/zz-docker.conf

RUN apk --no-cache add apache2 apache2-proxy mysql-client \
    libzip-dev libpng-dev libxslt-dev libwebp-dev icu-dev jpegoptim optipng libxml2-dev jpeg-dev freetype-dev \
    xvfb ttf-dejavu ttf-droid ttf-freefont ttf-liberation && \
    docker-php-ext-configure gd --with-jpeg=/usr/include/ --with-freetype=/usr/include/ --with-webp=/usr/include/

RUN apk add --no-cache libssh2-dev autoconf build-base && \
    pecl install ssh2-1.3.1 && docker-php-ext-enable ssh2

RUN docker-php-ext-install bcmath intl zip soap sockets simplexml xmlwriter pdo_mysql mysqli xsl dom xml gd exif opcache

RUN curl -O https://raw.githubusercontent.com/wp-cli/builds/gh-pages/phar/wp-cli.phar && \
    chmod +x wp-cli.phar && \
    mv wp-cli.phar /usr/local/bin/wp

#Docker

COPY ./scripts/app/run.sh ./scripts/app/entrypoint.sh /docker/

#Apache

COPY ./config/httpd/vhost.conf /etc/apache2/conf.d/vhost.conf
COPY ./config/httpd/httpd.conf /etc/apache2/httpd.conf

#PHP

COPY ./config/php/php.ini ./config/php/xdebug.ini /usr/local/etc/php/conf.d/

RUN docker-php-ext-enable xdebug

#Composer

COPY ./scripts/app/install-composer.sh /docker/install-composer.sh

#RUN sh /docker/install-composer.sh && \
#    composer self-update --2.2

#ZSH

COPY ./scripts/app/bash/.zshrc ./scripts/app/bash/.custom.zshrc /home/www-data/
RUN apk add --no-cache zsh zsh-vcs fzf && \
    mkdir -p /home/www-data/.antigen && \
    curl -L git.io/antigen > /home/www-data/.antigen/antigen.zsh && \
    chown -R www-data:www-data /home/www-data/ && \
    ln -s /home/www-data/.zshrc $HOME/.zshrc

RUN /bin/zsh /root/.zshrc

#Setup uid & gid layer
ARG DOCKER_WWW_DATA_UID
ARG DOCKER_WWW_DATA_GID

RUN echo "Docker user uid and gid is ${DOCKER_WWW_DATA_UID}:${DOCKER_WWW_DATA_GID}"
#RUN usermod -u ${DOCKER_WWW_DATA_UID} www-data
#RUN groupmod -g ${DOCKER_WWW_DATA_GID} www-data


#RIGHTS

RUN touch /root/.profile

RUN ls -la /

RUN chmod -R 777 /var/log/apache2 /run/apache2 \
    && chmod +x /docker/run.sh /docker/entrypoint.sh

USER www-data

RUN /bin/zsh /home/www-data/.zshrc

# https://httpd.apache.org/docs/2.4/stopping.html#gracefulstop
STOPSIGNAL SIGWINCH

CMD ["/docker/run.sh"]
