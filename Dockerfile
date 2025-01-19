FROM dunglas/frankenphp

COPY . /app
COPY . /public /app/public

RUN install-php-extensions \
	pdo_mysql \
	gd \
	intl \
	zip \
	opcache