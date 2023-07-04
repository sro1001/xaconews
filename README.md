# Xaconews
Xaconews es una acplicación web que obtiene noticias a través de Google News, relacionadas con los bienes de interés cultural del Camino de Santiago a su paso por la comunidad autónoma de Castilla y León. Posteriormente ofrece la posibilidad de  analizar los sentimientos transmitidospor cada noticia con la API de ChatGPT, para conocer así conocer la positividad de las noticias acerca de este histórico recorrido.

![logoLogin](https://github.com/sro1001/xaconews/assets/44772062/60d517ce-603f-49fc-93c7-99d9efec3b27)


Es una aplicación en PHP que implementa el framework de Laravel y utiliza diversas herramientas que componen un dashboard y administrador de noticias, un administrador de usuarios y un dashboard de estadísiticas con los resultados de los análisis de sentimientos realizados.

# Instalación en local

Para configurar un entorno de desarrollo será necesario instalar Xampp. En nuestro caso la versión 7.2.34 que es la misma versión que PHP. Descargable desde https://sourceforge.net/projects/xampp/files/XAMPP%20Windows/7.2.34/

Dentro de la estructura de carpetas de Xampp, hay que modificar el fichero ”httpd-vhosts.conf” en la ruta “/apache/conf/extra/” para especificar el directorio de nuestra aplicación y la url que queremos configurar:
 
![image](https://github.com/sro1001/xaconews/assets/44772062/2afb1f71-3c7b-40a0-bd44-72e8a291d9d8)

Esta url también tendrá que ser añadida en el fichero “hosts” en el caso de nuestro equipo Windows en la ruta “C:\Windows\System32\drivers\etc”

*127.0.0.1   xaconews.sro.desa*

También habrá que instalar Composer, para obtener todas las dependencias el proyecto. Descargable desde https://getcomposer.org/download/ y posteriormente, tras obtener el código del proyecto a través de GitHub, ejecutaremos el comando

*composer install*

para tener todo listo
Uno de los siguientes pasos es configurar el PHP de Xampp en las variables de entorno de nuestro ordenador:

![image](https://github.com/sro1001/xaconews/assets/44772062/33ebdaa2-2cac-421d-839c-d5891a129a97)

 
Después, necesitaremos configurar el archivo “.env” con la configuración que queramos para nuestro entorno. Se puede tomar como ejemplo el fichero “.env.example” y posteriormente renombrar el fichero. 

Finalmente, tendremos que ejecutar el archivo “xampp_start.exe” para que se configure correctamente, y ya podremos acceder al panel de control de Xampp ejecutando el archivo “xampp-control.exe”. Desde este panel de control podremos arrancar el servidor de Apache y MySQL.

Por último, con el servidor de MySQL arrancado, podremos crear una base de datos y ejecutar los comandos para ejecutar las migraciones y seeders 

*php artisan migrate | php artisan db:seed*

para tener lista la base de datos con la estructura e información necesaria.

# Despliegue

Se ha conseguido desplegar la aplicación a través de Railway.app en el dominio https://xaconews-production.up.railway.app/
Ya que el registro público solo ofrece acceso como rol lector, he creado un usuario administrador para las pruebas que se deseen realizar.
Usuario: admin@xaconews.es
Contraseña: PruebasXaconews

# Pruebas en mailtrap
Para probar los mails de recuperación de contraseña hay que acceder a mailtrap (https://mailtrap.io/signin) con las siguientes credenciales:
Usuario: sro1001@alu.ubu.es
Contraseña: PruebasXaconews
Para llegar a la bandeja de entrada de mail hay que seguir este link: https://mailtrap.io/inboxes/2214795/messages
