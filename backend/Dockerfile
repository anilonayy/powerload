FROM php:8.3-fpm-alpine

# Setting environment variables
ENV PHPGROUP=laravel
ENV PHPUSER=laravel
ENV WORKDIR=/var/www

WORKDIR $WORKDIR
ADD ./ $WORKDIR

# Create user and group as 'laravel'
RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}

# Change the group and user from www-data to laravel for www.conf
RUN sed -i "s/user www-data/user ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group www-data/group ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf

# Apply all access to storage folder to working properly
RUN chown -R 777 $WORKDIR

# Install pdo and pdo_mysql extensions
RUN docker-php-ext-install pdo pdo_mysql

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]
