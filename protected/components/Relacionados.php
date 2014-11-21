<?php
class Relacionados
{
	public static function obtener($micrositio_id)
	{
		$generos = Micrositio::model()->with('micrositio_x_genero')->findByPk($micrositio_id);
		$relacionados = array();
		foreach($generos->micrositio_x_genero as $genero)
		{
			$mxg = MicrositioXGenero::model()->with('micrositio')->findAllByAttributes(array('genero_id' => $genero->genero_id), 'micrositio_id != '.$micrositio_id);
			foreach ($mxg as $m) {
				if($m->micrositio->miniatura)
					$relacionados[] = $m->micrositio;
			}
		}
		shuffle($relacionados);
		return array_slice($relacionados, 0, 3);
	}

}