FROM php:7.4-fpm

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

# Install system dependencies
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/
RUN install-php-extensions exif gd imagick intl mysqli pdo_mysql pdo_sqlite sockets xdebug zip

# Sendmail
RUN echo "hostname=localhost.localdomain" > /etc/ssmtp/ssmtp.conf
RUN echo "mailhub=smtp:1025" >> /etc/ssmtp/ssmtp.conf
RUN echo "localhost localhost.localdomain" >> /etc/hosts

# Custom configuration
RUN echo "sendmail_path=sendmail -i -t" >> ${PHP_INI_DIR}/conf.d/98-sendmail.ini
RUN echo "smtp_port=1025" >> ${PHP_INI_DIR}/conf.d/98-sendmail.ini
COPY ./docker/conf/php/php.ini ${PHP_INI_DIR}/conf.d/99-custom.ini

# Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Create system user to run Composer
RUN useradd -G www-data,root -u ${USER_UID} -d /home/${USER_NAME} ${USER_NAME}
RUN mkdir -p /home/${USER_NAME}/.composer && \
    chown -R ${USER_NAME}:${USER_NAME} /home/${USER_NAME}

USER ${USER_NAME}

# Set working directory
WORKDIR /var/www/html