# telemedellin.tv
## Configuración
Este sitio está utiliza el framework [Yii](http://www.yiiframework.com/) versión 1.1.16, se debe ubicar en el directorio *framework* encima del público.
###.htaccess
Se recomienda revisar o comentar las reglas de redireccionamiento según el caso de instalación.
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
- Crear los directorios *assets* y *protected/runtime* con permisos 777.
- En el directorio [protected/config](protected/config/) se debe modificar los archivos [main.php] y [console.php].
   [main.php]
   ```php
   ...
    50. 'baseUrl'=>'http://localhost/tm/',
   ...
    180. 'db'=>array(
	181.	'connectionString' => 'mysql:host=localhost;dbname=telemedellin',
	182.	'emulatePrepare' => true,
	183.	'username' => 'root',
	184.	'password' => '',
	...
	193. 'callback' => 'http://concursomedellin2018.com/tm/usuario/registro/twitter',
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
- El directorio *protected* se renombra por **protected-tm** y se mueve fuera de la carpeta pública.   

**TODO:** Verificar la carga de los scripts en el layout [iframe.php](protected/views/layouts/iframe.php) y en la vista [_carpeta](protected/views/telemedellin/_carpeta.php)
 
###CKFinder
Se debe modificar el archivo de configuración y el plugin admintm.   

[config.php](857--edatm-ckfinder/config.php)
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
###Xcloner (Backups)
Verificar el acceso en el archivo de configuración.
```php
$_CONFIG['jcuser'] = 'admin';
$_CONFIG['jcpass'] = md5('admin');
```
###JavaScript
Cuando el sitio se carga en un subdirectorio se debe configurar la url base en los script para las llamadas al servidor.   
[app-dev.js](/js/app-dev.js)
```javascript
1. var url_base = '/',
```
[file.app-dev.js](/js/file.app-dev.js)
```javascript
1. jQuery(function($) {
2.   var url_base = '/';
```
[iframe.app-dev.js](/js/iframe.app-dev.js)
```javascript
23. jQuery(function($) {
24.   var url_base = '/';
```
[mobile-dev.js](/js/mobile-dev.js)
```javascript
1. function abrir_multimedia(hash) {
2.   var url_base = '/', 
```
###Grunt
Se recomienda instalar [Grunt](http://gruntjs.com/getting-started) con [npm](https://www.npmjs.com/) si va a modificar los archivos CSS y JavaScript.
```sh
$ npm install -g grunt-cli
```
En el archivo [Gruntfile.js](Gruntfile.js) se encuentra la configuración para concatenar y minificar los estilos CSS y los JavaScript para producción.  
Se recomienda antes de modificar estos archivos ejecutar la tarea *watch* de Grunt en la consola (no cerrarla).
```sh
$ grunt watch
```
[index.php]: index.php
[main.php]: protected/config/main.php
[console.php]: protected/config/console.php
