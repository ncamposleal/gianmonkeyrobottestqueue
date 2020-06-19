#!/bin/bash

composer update 

php artisan migrate

chmod -R 777 .

# Inicia los Jobs Creados
php artisan queue:work --queue=high,low
echo "running queue job"
