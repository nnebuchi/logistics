#!/bin/bash

echo "Deployment started ..."

# Enter maintenance mode
(php artisan down --render 'The app is being (quickly!) updated. Please try again in a minute.') || true

# Install dependencies based on lock file

composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Clear the old cache

php artisan clear-compiled
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan migrate --force
php artisan db:seed --force

#add symbolic link for storage folder

php artisan storage:link
# Exit maintenance mode
php artisan up

echo "Application deployed!"