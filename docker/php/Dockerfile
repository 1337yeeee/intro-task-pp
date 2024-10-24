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

ENV DB_ROOT_PASSWORD ${DB_ROOT_PASSWORD}
ENV DB_DATABASE ${DB_DATABASE}
ENV DB_USER ${DB_USER}
ENV DB_PASSWORD ${DB_PASSWORD}

# Устанавливаем права
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN apt-get install -y wait-for-it

# Экспонируем порт
EXPOSE 9000

CMD ["sh", "-c", "composer install --prefer-dist --optimize-autoloader && wait-for-it yii2-mysql:3306 -- php yii migrate --interactive=0 && php-fpm"]
