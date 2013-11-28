<?php
class SubirArchivo extends CAction
{

	public $accept_file_types 	= '/(\.|\/)(gif|jpe?g|png)$/i';
	public $directorio;
	public $image_versions 		= array();
	public $max_number_of_files = null;
	public $param_name;
	private $baseUrl;
	private $basePath;
	private $controlador;

	public function run()	
	{
		$this->controlador 	= $this->controller->id;
		$this->baseUrl 		= Yii::app()->request->baseUrl . '/';
		$this->basePath 	= Yii::getPathOfAlias('webroot');

		$data = array(	
					'image_versions' 		=> $this->image_versions,
					'script_url' 			=> $this->baseUrl . $this->controlador.'/'.$this->id,
				  	'max_number_of_files' 	=> $this->max_number_of_files,
					'upload_dir' 			=> $basePath . $this->directorio,
            		'upload_url' 			=> $this->baseUrl . $this->directorio,	
            		'accept_file_types' 	=> $this->accept_file_types,
            		'param_name' 			=> $this->param_name,
				);
		$messages = array(
        			1 => 'El archivo subido excede la directiva upload_max_filesize en php.ini',
        			2 => 'El archivo subido excede la directiva MAX_FILE_SIZE que se especificó en el formulario HTML',
        			3 => 'El archivo subido fue sólo parcialmente cargado. Por favor cargarlo nuevamente.',
        			4 => 'Ningún archivo fue subido',
        			6 => 'La carpeta temporal no se encuentra',
        			7 => 'Falló la escritura en el servidor',
        			8 => 'Una extensión de PHP interrumpió la carga de archivos',
        			'post_max_size' => 'El archivo subido excede la directiva post_max_size en php.ini',
        			'max_file_size' => 'El archivo es demasiado pesado',
        			'min_file_size' => 'El archivo no tiene el peso suficiente',
        			'accept_file_types' => 'Tipo de archivo no permitido',
        			'max_number_of_files' => 'Número máximo de archivos se superó. Solo se permite una imagen',
        			'max_width' => 'La imagen excede el ancho máximo',
        			'min_width' => 'La imagen no tiene el ancho suficiente',
        			'max_height' => 'La imagen excede el alto máximo',
        			'min_height' => 'La imagen no tiene el alto suficiente'
    			);		
		$upload_handler = new UploadHandler($data, true, $messages);
	}
}