
Para iniciar el proyecto se debe realizar en un ambiente lamp, Clonar el repo en htdocs 
Ademas se debe crear una base de datos por defecto es "laravel" con el usuario root y password (Estos se modifican en el archivo .env) *En esta ocacion se subio el archivo env para evitar errores. 

Como indica en la documentacion se debe enviar un header de autorizacion al usar la api, Se hardcode un api_key a la base de datos con un usuario por defecto  
ej header Authorization:yQNEKsH0b0x1qllkk1W7czq6hKE62jdTckqj7GgU5IMYtElu4JTpuwl6ZHYj

Para iniciar se puede ejecutar el comando start.sh el cual inicia tambien el job queue que tomara los trabajos y los procesara segun el {ṕriority} opcional por defecto low.

Documentacion swagger 
http://localhost/monkey-test-back/public/index.php/api/documentation
