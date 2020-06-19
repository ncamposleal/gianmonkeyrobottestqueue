#!/bin/bash

#Instala dependencias
composer update 

#Crea tablas y usuario (Se debe ya haber seteado en el .env la configuracion a la bd)
php artisan migrate

#Permisos para la documentacion de swagger
chmod -R 777 .

#Este proceso toma los Jobs enviados a la query y los procesa segun orden de prioridad del job  
php artisan queue:work --queue=high,low
echo "running queue job"
