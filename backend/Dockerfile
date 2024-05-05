FROM php:8.3-fpm-alpine as backend

## Setting environment variables
ENV WORKDIR=/var/www

WORKDIR $WORKDIR
ADD ./docker/ $WORKDIR

# Copy composer executable.
COPY --from=composer:2.3.5 /usr/bin/composer /usr/bin/composer

# Copy configuration files.
COPY ./docker/php/php-fpm.conf /usr/local/etc/php-fpm.d/www.conf

# Apply all access to storage folder to working properly
RUN chown -R 777 $WORKDIR

# Install pdo and pdo_mysql extensions
RUN docker-php-ext-install pdo pdo_mysql

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
