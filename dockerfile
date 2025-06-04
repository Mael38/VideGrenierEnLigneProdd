FROM php:8.3.0-apache   

RUN apt-get update && apt-get install -y \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install zip pdo pdo_mysql



RUN a2enmod rewrite

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

WORKDIR /var/www/html


COPY composer.json composer.lock ./
COPY package.json package-lock.json ./

RUN composer install

COPY . .

RUN composer dump-autoload --optimize

RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

RUN sed -i -e 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf \
    && echo "DocumentRoot /var/www/html/public" >> /etc/apache2/apache2.conf \
    && echo "<Directory /var/www/html/public>" >> /etc/apache2/apache2.conf \
    && echo "    AllowOverride All" >> /etc/apache2/apache2.conf \
    && echo "    Require all granted" >> /etc/apache2/apache2.conf \
    && echo "</Directory>" >> /etc/apache2/apache2.conf

RUN mkdir -p /var/www/html/public/storage \
    && chown -R www-data:www-data /var/www/html/public/storage \
    && chmod -R 755 /var/www/html/public/storage

EXPOSE 80
