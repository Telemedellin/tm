<?php
// A simple protection against calling this file directly.
if (!defined('IN_CKFINDER')) exit;

class DBConnector
{
    function onAfterFileUpload( $currentFolder, $uploadedFile, $filePath )
    {

        $base_path = '/home4/med2018/public_html/tm/archivos/';

        $name = $uploadedFile['name'];
        $type = $uploadedFile['type'];

        $pre_path = str_replace($base_path, '', $filePath);
        $pre_path = explode( '/', $pre_path );
        $path = '';
        
        for($i=0; $i < (count($pre_path)-1); $i++)
        {
            $path .= $pre_path[$i] .'/';
        }
        $path = substr($path, 0, -1);
        
        $conexion = $this->bd();


        //1. Busco la carpeta padre
        $query = '';
        $query .= 'SELECT c.id AS id, c.url_id, c.ruta, u.id AS uid, u.slug AS slug FROM carpeta AS c ';
        $query .= 'INNER JOIN url AS u ON c.url_id = u.id ';
        $query .= 'WHERE c.ruta LIKE "%' . $path . '%" ';

        $parent_resource = mysqli_query($conexion, $query);
        if( $parent_resource === FALSE )
        {
            echo 'Error ' . mysqli_error($conexion);
        }
        else
        {
            $parent = mysqli_fetch_array($parent_resource);
            //2. Creo la URL del archivo
            $slug = $parent['slug'] . '/' . $this->slugger($name);
            $creado = date('Y-m-d H:i:s');

            $url = '';
            $url .= 'INSERT INTO url ';
            $url .= '(slug, tipo_id, creado, estado) ';
            $url .= 'VALUES ("'.$slug.'", 11, "'.$creado.'", 1) ';

            $url_resource = mysqli_query($conexion, $url);
            //3. Agrego el archivo a la bd
            $url_id = mysqli_query($conexion, 'SELECT MAX(id) AS id FROM url');
            $url_id = mysqli_fetch_array($url_id);
            $url_id = $url_id["id"];
            switch($type)
            {
                case 'application/pdf':
                    $tipo_id = 1;
                    break;
                case 'application/vnd.ms-excel':
                case 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet':
                case 'application/vnd.openxmlformats-officedocument.spreadsheetml.template':
                    $tipo_id = 2;
                    break;
                case 'application/msword':
                case 'application/vnd.openxmlformats-officedocument.wordprocessingml.document':
                    $tipo_id = 3;
                default:
                    $tipo_id = 4;
            }

            $insert = '';
            $insert .= 'INSERT INTO archivo ';
            $insert .= '(url_id, tipo_archivo_id, carpeta_id, nombre, archivo, creado, estado) ';
            $insert .= 'VALUES (' . $url_id . ', '. $tipo_id .', ' . $parent['id'] . ', "'. $name .'", "'. $name .'", "'. $creado .'", 1) ';

            $insert_resource = mysqli_query($conexion, $insert);

        }

                

        return true;
    }

    function bd()
    {
        $host = 'localhost';
        $user = 'med2018_tm';
        $pass = 'asdf1234*';
        $bd   = 'med2018_tm';
        return mysqli_connect($host, $user, $pass, $bd);
    }

    function slugger($title)
    {
        $characters = array(
            "Á" => "A", "Ç" => "c", "É" => "e", "Í" => "i", "Ñ" => "n", "Ó" => "o", "Ú" => "u", 
            "á" => "a", "ç" => "c", "é" => "e", "í" => "i", "ñ" => "n", "ó" => "o", "ú" => "u",
            "à" => "a", "è" => "e", "ì" => "i", "ò" => "o", "ù" => "u"
        );
        
        $string = strtr($title, $characters); 
        $string = strtolower(trim($string));
        $string = preg_replace("/[^a-z0-9-]/", "-", $string);
        $string = preg_replace("/-+/", "-", $string);
        
        if(substr($string, strlen($string) - 1, strlen($string)) === "-") {
            $string = substr($string, 0, strlen($string) - 1);
        }
        
        return $string;
    }
}
 
$DBConnector = new DBConnector();
$config['Hooks']['AfterFileUpload'][] = array($DBConnector, "onAfterFileUpload");