FROM php:8.0.6-apache-buster

# Update the image to get the latest stuff
RUN apt-get update
RUN apt-get upgrade -y

RUN apt-get install --fix-missing -y libpq-dev
RUN apt-get install --no-install-recommends -y libpq-dev
RUN apt-get install -y libxml2-dev libbz2-dev zlib1g-dev libpng-dev
RUN apt-get -y install libsqlite3-dev libsqlite3-0 mariadb-client curl exif ftp

# Install and Enable extensions
RUN docker-php-ext-install intl gd mysqli pdo pdo_mysql
RUN docker-php-ext-enable intl gd mysqli pdo pdo_mysql

RUN apt-get -y install --fix-missing zip unzip
RUN apt-get -y install --fix-missing git

# Get composer and update to the latest version
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer self-update --2

# Copy apache config
COPY conf/apache.conf /etc/apache2/sites-available/000-default.conf

# Add start script
RUN printf "#!/bin/bash\n/usr/sbin/apache2ctl -D FOREGROUND" > /start_script.sh
RUN chmod +x /start_script.sh

# Enable rewrite URL capability so we can remove the trailing index.php
RUN a2enmod rewrite

# Cleanup
RUN apt-get clean \
    && rm -r /var/lib/apt/lists/*

# Expose port and setup volumes
EXPOSE 80
VOLUME ["/var/www/html", "/var/log/apache2", "/etc/apache2"]

CMD ["bash", "/start_script.sh"]
