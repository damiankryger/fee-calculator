FROM composer:2 AS composer

FROM php:8.3-cli AS runtime

RUN apt-get update && \
    apt-get install -y git unzip libzip-dev && \
    docker-php-ext-configure zip && \
    docker-php-ext-install zip

COPY --from=composer /usr/bin/composer /usr/local/bin/composer

WORKDIR /app

COPY . /app

RUN composer install
RUN vendor/bin/phpstan analyse src --level max
RUN vendor/bin/php-cs-fixer fix src --dry-run --diff --format=json
RUN vendor/bin/phpunit

CMD ["php", "vendor/bin/phpunit"]