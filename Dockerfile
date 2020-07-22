FROM mgonzalezbaile/php-fpm-dev:7.4

RUN set -xeu \
    && install-php-extensions \
        pdo_mysql \
        redis
