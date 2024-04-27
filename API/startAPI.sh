#!/bin/bash

test_connection() {
    php artisan migrate:status >/dev/null 2>&1
}

# Boucle pour tester la connexion
while ! test_connection; do
    echo "The database connection has failed. Retry in 1 second..."
    sleep 1
done

php artisan db:seed
php artisan serve --host=pa_api --port=8000
