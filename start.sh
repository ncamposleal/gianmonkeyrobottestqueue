#!/bin/bash
sudo su

#clonar repositorio
git clone https://github.com/ncamposleal/gianmonkeyrobottestqueue.git monkey-test-back

composer update 

php artisan migrate

php artisan l5-swagger:generate
chmod -R 777 .

# Inicia los Jobs Creados
php artisan queue:work --queue=high,low