sudo su

composer install 

apt install php-mysql
php artisan migrate

php artisan l5-swagger:generate
chmod -R 777 .
# Inicia los Jobs Creados
php artisan queue:work --queue=high,low