FROM composer:latest AS composer
FROM php:8.2-apache
RUN apt update -y
RUN apt install nano
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions zip gd intl pdo_mysql mysqli
COPY --from=composer /usr/bin/composer /usr/bin/composer
ENV COMPOSER_HOME=/.composer
ENV COMPOSER_ALLOW_SUPERUSER=1
RUN a2enmod headers rewrite
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
RUN mkdir -p /var/www/html /.composer && chown -R www-data:www-data /var/www/html

WORKDIR /var/www/html

COPY --chown=www-data composer.json composer.lock /var/www/html/

# Install all composer dependencies without running the autoloader and the scripts since these
# actions rely on the source files of the application.
# Also, volume mounting a bind-mounted cache to composer's /.composer folder helps speeding up the build
# since even when you break the cache by adding/removing a composer package, all previously installed
# packages are served from the mounted cache.
RUN --mount=type=cache,target=/.composer/cache composer install --no-autoloader --no-scripts

# Copy the rest of the source code to the container. Now, if source files are changed, the cache-layer
# breaks here and the only the 'composer dump-autoload' command will have to run again.
COPY --chown=www-data . /var/www/html/

# Generate an optimized autoloader after copying the source files to the container
RUN composer dump-autoload --optimize

# Change ownership of the root folder to www-data
# RUN mkdir -p /var/www/html/session/
# RUN chmod -R 755 /var/www/html/session/
# RUN chown www-data /var/www/html/session/

# RUN chmod -R 755 /var/www/html/writable/cache/
RUN chown -R www-data:www-data vendor/