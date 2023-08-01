FROM php:8.1.22RC1-apache

RUN set -ex; \
    apt-get update; \
    apt-get install -y --no-install-recommends \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    unzip \
    gnupg \
    && apt-get clean; \
    rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* 

RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g yarn

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

RUN if [ -d "/var/www/html/storage"]; then chown -R www-data:www-data /var/www/html/storage; fi
RUN if [ -d "/var/www/html/bootstrap/cache"]; then chown -R www-data:www-data /var/www/html/bootstrap/cache; fi

COPY start-container.sh /usr/local/bin/start-container.sh
RUN chmod +x /usr/local/bin/start-container.sh

RUN useradd -G www-data,root -u 100 -d /home/devuser devuser

RUN mkdir -p /home/devuser/.composer && \
    chown -R devuser:devuser /home/devuser && \
    chown -R devuser:devuser /var/www/html

RUN a2enmod rewrite headers

ENTRYPOINT [ "start-container.sh" ]