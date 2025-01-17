FROM php:8.1-apache

# Install required tools and extensions
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    dos2unix \
    default-mysql-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Enable PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    mysqli \
    mbstring \
    exif \
    pcntl \
    bcmath \
    gd \
    intl
    

COPY ./docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf

# Enable Apache modules for PHP
RUN a2enmod rewrite

# Add Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set up user
RUN useradd -G www-data,root -u 1000 -d /home/dev dev
RUN mkdir -p /home/dev/.composer && \
    chown -R dev:dev /home/dev

# Set working directory
WORKDIR /var/www/html

# Copy app source code
COPY . .

EXPOSE 8080

# Configure permissions
RUN chown -R www-data:www-data /var/www/html/writable && \
    chmod -R 775 /var/www/html/writable && \
    chown -R www-data:www-data /var/www/html/public && \
    chmod -R 775 /var/www/html/public

# Copy entrypoint script
COPY ./docker-entrypoint.sh /usr/local/bin/
RUN dos2unix /usr/local/bin/docker-entrypoint.sh
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Switch to non-root user
USER dev

# Run entrypoint
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]

USER root
