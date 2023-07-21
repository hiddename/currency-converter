FROM php:8.2.8-fpm-alpine3.18

RUN apk update && apk --no-cache add sudo bash zsh vim nano git curl

RUN sh -c "$(curl -fsSL https://raw.github.com/robbyrussell/oh-my-zsh/master/tools/install.sh)"

RUN apk update && apk add --no-cache \
    $PHPIZE_DEPS \
    curl-dev \
    libpq-dev \
    mpdecimal-dev

RUN nice docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql &&\
    nice docker-php-ext-install -j $(nproc) opcache curl pdo pdo_pgsql pgsql &&\
    nice pecl install redis && docker-php-ext-enable redis &&\
    nice pecl install decimal && docker-php-ext-enable decimal

COPY --from=composer:latest /usr/bin/composer /usr/local/bin/composer
