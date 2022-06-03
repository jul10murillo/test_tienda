
# Tienda Evertec

Prueba hecha por Julio Murillo en la que podemos evidenciar gestión de productos, enlace con pasarela de pago y ordenes.

## Requisitos

Verifique los requisitos del servidor para la configuración: 
PHP> = 7.3 
Extensión PHP BCMath 
Extensión PHP Ctype 
Extensión PHP Fileinfo 
Extensión PHP JSON 
Extensión PHP Mbstring 
Extensión PHP OpenSSL 
Extensión PHP PDO 
Extensión PHP Tokenizer 
Extensión PHP XML. 

## Pasos
- Bajar el repositorio al servidor
- Actualizar a rama develop
- en terminal usar composer install


Seguidamente se puede crear un host con "php artisan serve" o se crea un host virtual

 - Actualizar el archivo .env con la información solicitada 
 - Ejecutar las migraciones y los seeders

## Contenido

- Módulo administrativo con información de los productos y ordenes
- Front tienda
- Carrito de compras
- Conexión con PlaceToPay
- Pruebas unitarias
