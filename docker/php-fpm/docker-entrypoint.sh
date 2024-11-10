#!/bin/bash

echo "Waiting for MySQL to be ready..."
while ! mysqladmin ping -h"$DB_HOST" -u"$DB_USER" -p"$DB_PASSWORD" --silent; do
    sleep 1
done

if [ ! -f ".env" ]; then
    echo "Setting up .env file..."
    cp env .env
    
    sed -i 's/# database.default.hostname = localhost/database.default.hostname = '"$DB_HOST"'/g' .env
    sed -i 's/# database.default.database = ci4/database.default.database = '"$DB_NAME"'/g' .env
    sed -i 's/# database.default.username = root/database.default.username = '"$DB_USER"'/g' .env
    sed -i 's/# database.default.password = root/database.default.password = '"$DB_PASSWORD"'/g' .env
    
    sed -i 's/# CI_ENVIRONMENT = production/CI_ENVIRONMENT = development/g' .env
    
    sed -i 's/# database.default.DBDriver = MySQLi/database.default.DBDriver = MySQLi/g' .env
    sed -i 's/# database.default.port = 3306/database.default.port = 3306/g' .env
fi

# Install composer dependencies if vendor directory doesn't exist
if [ ! -d "vendor" ]; then
    echo "Installing composer dependencies..."
    composer install
fi

# Run migrations
echo "Running database migrations..."
php spark migrate

# Run seeders
echo "Running database seeders..."
php spark db:seed RoleSeeder
php spark db:seed UserSeeder
php spark db:seed CourseSeeder
php spark db:seed CourseLecturerSeeder
php spark db:seed EnrollmentsSeeder

# Start PHP-FPM
echo "Starting PHP-FPM..."
php-fpm