# Use the official PHP image as a base image
FROM php:8.2-cli

# Set the working directory in the container
WORKDIR /var/www

# Copy the current directory contents into the container at /var/www
COPY . /var/www

# Install required PHP extensions and tools
RUN apt-get update && apt-get install -y \
    libicu-dev \
    git \
    unzip \
    zip \
    && docker-php-ext-install intl pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Allow Composer to run as root (not recommended for production)
ENV COMPOSER_ALLOW_SUPERUSER=1

# Install project dependencies using Composer
RUN composer install

# Expose port 8080 for the development server
EXPOSE 8080

# Run the PHP Spark server when the container starts
CMD ["php", "spark", "serve", "--host=0.0.0.0", "--port=8080"]
