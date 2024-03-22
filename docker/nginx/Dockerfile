FROM nginx:stable-alpine

# Variables to be used in dockerfile.
ENV NGINXUSER=laravel
ENV NGINXGROUP=laravel

# Create a directory for the html files on image.
RUN mkdir -p /var/www

# Add default nginx configuration into image.
ADD ./default.conf /etc/nginx/conf.d/default.conf

# "sed" is stream editor for regex replacement.
# Change the user from www-data to laravel for nginx.conf.
RUN sed -i "s/user www-data/user ${NGINXUSER}/g" /etc/nginx/nginx.conf

# Add the user and group
RUN adduser -g ${NGINXGROUP} -s /bin/sh -D ${NGINXUSER}