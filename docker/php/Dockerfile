FROM php:8.2-fpm

# Устанавливаем зависимости
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Устанавливаем Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Копируем проект в контейнер
WORKDIR /var/www/html
COPY ./application /var/www/html

# Устанавливаем права
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

# Устанавливаем зависимости через Composer
RUN composer install --prefer-dist --no-dev --optimize-autoloader

# Экспонируем порт
EXPOSE 9000

CMD ["php-fpm"]
