FROM php:8.2-cli

# Install required packages
RUN apt-get update \
    && apt-get install -y git unzip libzip-dev libpng-dev libxml2-dev \
    && docker-php-ext-install zip gd xml

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . /app

RUN composer install --no-interaction --prefer-dist

CMD ["bash"]
