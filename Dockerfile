FROM php:5.6.30-fpm-alpine
RUN apk update &amp;&amp; apk add build-base
RUN apk add postgresql postgresql-dev \
  &amp;&amp; docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
  &amp;&amp; docker-php-ext-install pdo pdo_pgsql pgsql
RUN apk add zlib-dev git zip \
  &amp;&amp; docker-php-ext-install zip
RUN curl -sS https://getcomposer.org/installer | php \
        &amp;&amp; mv composer.phar /usr/local/bin/ \
        &amp;&amp; ln -s /usr/local/bin/composer.phar /usr/local/bin/composer
COPY . /app
WORKDIR /app
RUN composer install --prefer-source --no-interaction
ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"