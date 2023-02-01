# Foodgrams
## _Instalacion Local_


El presente repositorio contiene el proyecto desarrollado previo a la obtención del título profesional, a continuación se presenta las temáticas de instalación.
- Requisitos de instalación
- Proceso de instalación
- Errores comunes

## Requisitos de instalación

Previo a la descarga e instalación del proyecto, es necesario tener instalado las siguientes herramientas, las cuales permiten la ejecución de dependencias que se necesita.
- [Composer](https://getcomposer.org/download/)
- [Node.js](https://nodejs.org/en/download/)
- [Xampp](https://www.apachefriends.org/es/download.html)


## Proceso de instalación
##### 1.-Clonación del proyecto
En el cmd nos ubicamos en la carpeta en la cual vamos a clonar el repositorio.
Una vez ubicado en la carpeta, se procede con la clonacion del presente repositorio mediante el siguiente comando.
```sh
git clone {repository URL}
```
##### 2.-Ejecución del xampp

Una vez instalado y configurado xampp, se procede con su ejecucion del mismo y abrimos el phpmyadmin, el cual nos ayuda con la gestion de base de datos.

Creamos una base de datos, para mayor facilidad se debe implmeentar con el nombre del proyecto que vayamos a ejecutar.
##### 3.-Creación del archivo ".env"
Cuando se clona el proyecto, viene consigo un archivos ".env-Example", el mismo se debe duplicar y cambiar por ".env", esto se hace para poder implementar las credenciales de los diferentes servicios que se requieres.
##### 4.-Configuracion de base de datos.
En el archivo ".env" se configura con las credenciales de la base de datos previamente creada.
```
DB_CONNECTION=mysql
DB_HOST=localhost
DB_PORT=3306
DB_DATABASE=laravel_project
DB_USERNAME=root
DB_PASSWORD=secret
```
##### 4.-Comandos de instalación de dependencias.

Con el siguiente comando instalamos las dependencias que se encuentran en el "composer.json".
```
composer install
```
Como siguiente, se instala las dependencias que se encuentra en el "package.json" con el siguiente comando .
```
npm install
```
Generamos una llave, la cual nos permite el enlace con la base de datos
```
php artisan key:generate
```
Se procede a realizar la migración con el siguiente comando.
```
php artisan migrate 
```
Finalizado la ejecución de los comandos, se procede a crear un enlace simbólico del storage el cual nos permite almacenar documentos o imágenes que son necesarios para el proyecto.
```
php artisan storage:link
```
##### 5.-Servicios utilizados.
Previo a la ejecución del proyecto se necesitan obtener las credenciales de los servicios utilizados.
###### Mailtrap
Para el servio de mails, se utiliza [Mailtrap](https://mailtrap.io/) el cual premite el testear envios de email para la recuperacion de contraseñas.
###### Pusher
Para el chat en vivo, se utiliza [Pusher](https://pusher.com/) el cual no otorga un servio en la nube en tiempo real, para el envio de notificacion y mensajes.

En la vista ["chat.vue"](https://github.com/JosueEPN/Foodgrams/blob/main/resources/js/Pages/Auth/Login.vue) y la vista "login.vue" en la sección  de funciones, cambiar las credenciales por las cual otorga pusher estas son credenciales apartes las cuales permite el enlace al canal apenas se inicia una conversacion o se ingresa al sistema.

## 6.-Ejecución del proyecto.
Antes de ejecutar el servidor de laravel, se debe compilar todos los archivos ".vue" con el siguiente comando.
```
npm run dev
```
Si se realiza cambios en los archivos ".vue" se debe ejecutar de nuevo el comando anterior o ejecutar el siguiente comando que esta constantemente compilando al guardar las modificaciones 
```
npm run watch
```
Para la ejecucion del servicio, se debe ejecutar el sigueinte comando

```
php artisan serve
```
## Errores comunes
##### Envio de mail.
Revisar los puertos en el cual se ejecuta el envio de mails, puede cambiar el puerto 2525 que se encuentra predeterminado por el puerto 587.
##### Chat en vivo.

Revisar el Javascript de las vista de chat de ser el caso o del "APPlayaout" de los cuales se necesita establecer el canal para el envio de mensajes.



## License


**Free Software, Hell Yeah!**
