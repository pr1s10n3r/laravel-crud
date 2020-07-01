# Instalación

1. Clonar este proyecto
2. Instalar las dependencias de JavaScript
    - `$ npm install`
3. Instalar dependencias de PHP utilizando Composer
    - `$ composer install`
4. Este proyecto fue desarrollando utilizando MariaDB, pero debería funcionar con cualquier motor de base de datos soportado por Laravel. Luego de instalar una base de datos y configurar el archivo .env se deben cargar los esquemas utilizando migraciones. Estos esquemas se cargan utilizando el siguiente comando:
    - `$ php artisan migrate:fresh`
5. Ahora se debe llenar la base de datos con algunos registros iniciales (un usuario administrador y unos productos).
    - `$ php artisan db:seed`
    - `$ php artisan db:seed --class=ProductSeeder`
6. Para correr el proyecto, se puede hacer de varias maneras. Recomiendo utilizar:
    - `$ php artisan serve`
    - El comando de arriba lanzará un servidor de desarrollo en el puerto 8000.

**Nota:** Todos los comandos deben ser ejecutados dentro del directorio del proyecto.

# Usuario Administrador

Por defecto se crea un usuario administrador llamado "Tester Junior". Sus credenciales son:

-   Correo Electrónico: tester@gmail.com
-   Contraseña: s3cr3t

# Vista Previa

### Vista de la página principal

![](https://i.imgur.com/SHtjpjs.png)

### Vista del administrador de productos

![](https://i.imgur.com/oLeqKBk.png)

# Dudas

En caso de tener alguna duda sobre la instalación y/o el funciomaniento de este proyecto, puedes escribirme a [alvarostagg@protonmail.com](mailto:alvarostagg@protonmail.com)
