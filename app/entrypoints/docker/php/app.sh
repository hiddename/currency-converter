#!/bin/sh

composer install --prefer-dist --ignore-platform-reqs --ansi --no-interaction --no-plugins --no-scripts

#php bin/console php bin/console doctrine:database:create --if-not-exists

php bin/console doctrine:migrations:migrate --no-interaction

php bin/console app:rate:refresh

php-fpm
