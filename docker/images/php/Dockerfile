FROM php:8.0-apache as php

# Arguments defined in docker-compose.yml
ARG USER_UID
ARG USER_NAME

# Install system dependencies
RUN apt-get update && apt-get install -y \
    build-essential \
    libpng-dev \
    libjpeg62-turbo-dev \
    libfreetype6-dev \
    locales \
    zlib1g-dev \
    libzip-dev \
    ssmtp \
    sqlite3 \
    libsqlite3-dev \
    zip \
    jpegoptim optipng pngquant gifsicle \
    unzip

# Clean
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/000-default.conf

# Install system dependencies
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions @composer exif gd imagick intl mysqli pdo_mysql sockets xdebug zip

# Sendmail
RUN echo "hostname=localhost.localdomain" > /etc/ssmtp/ssmtp.conf
RUN echo "mailhub=smtp:1025" >> /etc/ssmtp/ssmtp.conf

# Custom configuration
RUN echo "sendmail_path=sendmail -i -t" >> ${PHP_INI_DIR}/conf.d/98-sendmail.ini
RUN echo "smtp_port=1025" >> ${PHP_INI_DIR}/conf.d/98-sendmail.ini
COPY ./docker/conf/php/php.ini ${PHP_INI_DIR}/conf.d/99-custom.ini

# Create system user to run Composer
RUN useradd -G www-data,root -u ${USER_UID} -d /home/${USER_NAME} ${USER_NAME}
RUN mkdir -p /home/${USER_NAME} && chown -R ${USER_NAME}:${USER_NAME} /home/${USER_NAME}

RUN a2enmod rewrite

# Use local user
USER ${USER_NAME}

# Set working directory
WORKDIR /var/www/html

CMD ["apachectl", "-D", "FOREGROUND"]

EXPOSE 80 443