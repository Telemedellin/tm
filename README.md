# telemedellin.tv
## Configuración básica
Este sitio utiliza el framework [Yii](http://www.yiiframework.com/) versión 1.1.16, se debe ubicar en el directorio *framework* encima del público.
###.htaccess
Se recomienda revisar o comentar las reglas de redireccionamiento según el caso de instalación.

[.htaccess](public_html/.htaccess)
```apacheconf
#Redirecciona para canonizar el dominio
RewriteCond %{HTTP_HOST} ^138\.128\.186\.34 [OR]
...
RewriteRule ^(.*)$ "http\:\/\/telemedellin\.tv\/$1" [R=301,L]

RewriteCond %{REQUEST_FILENAME} !-f
RewriteCond %{REQUEST_FILENAME} !-d
RewriteRule ^(.*)\?*$ index.php/$1 [L,QSA]
```
###Yii
- Asignar permisos 777 a los directorios *public_html/assets/*, *protected-tm/runtime/* y *protected-tm/extensions/yii-feed-widget/cache/*.
- En el directorio [config/](protected-tm/config/) se debe modificar los archivos [main.php] y [console.php].   

[main.php]   
```php   
...
50. 'baseUrl'=>'http://localhost/tm/',
...
187. 'db'=>array(
188.	'connectionString' => 'mysql:host=localhost;dbname=telemedellin',
189.	'emulatePrepare' => true,
190.	'username' => 'root',
191.	'password' => '',
...
200. 'callback' => 'http://concursomedellin2018.com/tm/usuario/registro/twitter',
...
```   
[console.php]   
```php   
...
19. 'db'=>array(
20.	'connectionString' => 'mysql:host=localhost;dbname=telemedellin',
21.	'emulatePrepare' => true,
22.	'username' => 'root',
23.	'password' => '',
...
```   
- En el archivo [index.php] se deben comentar los scripts de ClickTale para que no interfiera con las estadísticas del sitio web.   

[index.php]   
```php   
...
8. if($track)
9.   require_once( '/home/telemedellin/public_html' . "/ClickTale/ClickTaleTop.php" );
...
22. if($track)
23.   require_once( '/home/telemedellin/public_html' . "/ClickTale/ClickTaleBottom.php");
```   

###Grunt
Se recomienda instalar [Grunt](http://gruntjs.com/getting-started) con [npm](https://www.npmjs.com/) si va a modificar los archivos CSS y JavaScript.
####Instalar grunt globalmente
```sh
$ npm install -g grunt-cli
```
####Instalar las dependencias del proyecto
```sh
$ npm install
```
En el archivo [Gruntfile.js](Gruntfile.js) se encuentra la configuración para concatenar y minificar los estilos CSS y los JavaScript para producción.  
Se recomienda antes de modificar estos archivos ejecutar la tarea *watch* de Grunt en la consola (no cerrarla) para que se compilen los archivos minificados.
```sh
$ grunt watch
```

###JavaScript
Cuando el sitio se carga en un subdirectorio se debe configurar la url base en los script para las llamadas al servidor.   
[app-dev.js](public_html/js/app-dev.js)
```javascript
1. var url_base = '/',
```
[file.app-dev.js](public_html/js/file.app-dev.js)
```javascript
1. jQuery(function($) {
2.   var url_base = '/';
```
[iframe.app-dev.js](public_html/js/iframe.app-dev.js)
```javascript
23. jQuery(function($) {
24.   var url_base = '/';
```
[mobile-dev.js](public_html/js/mobile-dev.js)
```javascript
1. function abrir_multimedia(hash) {
2.   var url_base = '/', 
```
## Configuración para producción

###CKFinder
Plugin utilizado para la subida de archivos en el administrador.   
Se debe modificar el archivo de configuración y el plugin admintm.   

[config.php](public_html/857--edatm-ckfinder/config.php)
```php
...
66. $baseUrl = 'http://telemedellin.tv/';
...
87. $baseDir = '/home/telemedellin/public_html/';
```
[admintm/plugin.php](857--edatm-ckfinder/plugins/admintm/plugin.php)
```php
...
10. $base_path = '/home/telemedellin/public_html/archivos/';
...
87. function bd()
88. {
89.     $host = 'localhost';
90.     $user = 'root';
91.     $pass = '';
92.     $bd   = 'telemedellin';
```

###Xcloner
Aplicación utilizada para generar backups del sitio bajo demanda.   
Verificar el acceso en el archivo de configuración.

```php
$_CONFIG['jcuser'] = 'admin';
$_CONFIG['jcpass'] = md5('admin');
```
[index.php]: public_html/index.php
[main.php]: protected-tm/config/main.php
[console.php]: protected-tm/config/console.php
