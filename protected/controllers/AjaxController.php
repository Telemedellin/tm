<?php

class AjaxController extends Controller
{
	public function actions()
	{
		return array(
			'video'=>array(
                'class'=>'application.components.actions.SubirArchivo',
                'directorio' => 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d') . '/',
                'param_name' => 'archivoVideo', 
                'accept_file_types' => '/(\.|\/)(mov|mp?eg?4|mp4|avi|wmv|3gpp|webm)$/i', 
            ),
		);
	}
}