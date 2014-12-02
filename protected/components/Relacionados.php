<?php
class Relacionados
{
	public static function obtener($micrositio_id)
	{
		$d1 = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM micrositio WHERE id = ". $micrositio_id . " AND estado <> 0");
		$d2 = new CDbCacheDependency("SELECT MAX(creado) FROM micrositio_x_relacionado WHERE micrositio_id = ". $micrositio_id . " AND estado <> 0");
		
		$generos = Micrositio::model()->cache(21600, $d1)->with('micrositio_x_genero')->findByPk($micrositio_id);
		$relacionados = MicrositioXRelacionado::model()->cache(21600, $d2)->with('relacionado')->findAllByAttributes( array('micrositio_id' => $micrositio_id), array('order' => 'orden ASC') );
		
		$listado = array();
		foreach($generos->micrositio_x_genero as $genero)
		{
			$dependencia = new CDbCacheDependency("SELECT MAX(creado) FROM micrositio_x_genero WHERE genero_id = ". $genero->genero_id ." AND micrositio_id != ". $micrositio_id ." AND estado <> 0");

			$mxg = MicrositioXGenero::model()->cache(21600, $dependencia)->with('micrositio')->findAllByAttributes(array('genero_id' => $genero->genero_id), 'micrositio_id != '.$micrositio_id);
			foreach ($mxg as $m) {
				if($m->micrositio->miniatura)
					$listado[$m->micrositio_id] = $m->micrositio;
			}
		}
		$destacados = array();
		foreach($relacionados as $relacionado)
		{
			$clave = array_keys($listado, $relacionado->relacionado_id);
			if($clave !== FALSE)
			{
				unset($listado[$relacionado->relacionado_id]);
			}/**/

			$destacados[] = $relacionado->relacionado;
		}

		shuffle($listado);
		$listado = array_merge($destacados, $listado);
		return array_slice($listado, 0, 3);
	}

}