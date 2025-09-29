FROM php:8.2-fpm

RUN apt-get update && apt-get install -y --no-install-recommends \
        git \
        curl \
        zip \
        unzip \
        libzip-dev \
        libpq-dev \
        pkg-config \
        libssl-dev \
        libonig-dev \
    && docker-php-ext-configure zip \
    && docker-php-ext-install -j$(nproc) zip mbstring pdo pdo_pgsql \
    && pecl install redis \
    && docker-php-ext-enable redis \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

COPY composer.json composer.lock ./
RUN composer install --no-scripts --no-interaction

COPY . .

RUN chown -R www-data:www-data /var/www && chmod 755 /var/www

EXPOSE 9000

CMD ["php-fpm"]
