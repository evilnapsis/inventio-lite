# Inventio Lite v4
Inventio Lite es un sistema de Inventario y Ventas de proposito general desarrollado con PHP y MySQL.

## Modulos
- Productos
- Categorias
- Caja
- Clientes
- Proveedores
- Inventario
- Usuarios

## Update v4 2023
- Se actualizo la Plantilla Principal por Core UI v4


## Instalacion
Para instalar el Sistema Requieres Apache+PHP+MySQL o tener instalado el XAMPP/LAMPP

1. Primero debes descargar este repositorio y colocarlo en tu carpeta htdocs o /var/www/ segun sea el caso.
2. Deberas crear la base de datos llamada inventiolite en tu servidor mysql, las tablas requeridas estan en el archivo schema.sql
3. Deberas modificar el archivo inventio-lite/core/controller/Database.php y agregar los datos de conexion a tu base de datos.
4. Ejecutar el sistema desde http://localhost/inventio-lite/ depende del nombre que le pusiste a la carpeta del proyecto.
5. Los datos de usuario por default son:
    Usuario: admin
    Password: admin
6. DIsfrutar el sistema

## Mas informacion
Encuentra mas informacion, instrucciones y demos en el siguiente link.
Link: http://evilnapsis.com/2015/07/11/inventio-lite-sistema-de-inventario-y-ventas/

# Docker compose

Para poder correr el Sistema de Inventario, se puede utilizar la configuracion de docker-compose.yaml para levantar los servicios de mysql y phpmyadmin.

`docker compose up`

Al terminar de levantar el servicio hay que restaurar el schema.sql desde la pestanhan SQL.

Ten encuenta que se necesita el archivo `.env` en el directorio raiz, para poder leer las credenciales para la configuracion del mysql y phpmyadmin.

Ejemplo:
```
MYSQL_DATABASE=inventiolite
MYSQL_ROOT_PASSWORD=admin
MYSQL_USER=cocodrilo
MYSQL_PASSWORD=cocodrilo_password

PMA_HOST=mysql
PMA_PORT=3306
PMA_USER=root
PMA_PASSWORD=admin
```

