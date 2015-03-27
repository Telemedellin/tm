<?php
class Relacionados
{
	private $_micrositio_id;
	private $_relacionados;

	public function __construct( $micrositio_id )
	{
		$this->_micrositio_id = $micrositio_id;
		$this->_relacionados = $this->obtener();
		return $this;
	}

	public function render( $class = false, $copy = false )
	{
		if( !is_array($this->_relacionados) || !count($this->_relacionados) )
			return false;

		$items;
		foreach($this->_relacionados as $relacionado)
		{
			$items .= 
			'<a href="'.bu($relacionado->url->slug).'" class="relacionado"'.
			'title="Ir a '.str_replace('"', "'", $relacionado->nombre).'">'.PHP_EOL.
			'<img src="'.bu('images/'.$relacionado->miniatura).'" />'.PHP_EOL.
			'<p>'.$relacionado->nombre.'</p>'.PHP_EOL.
			'</a>'.PHP_EOL;
		}
		$head = '<h4>'.($copy?$copy:'También te puede interesar...').'</h4>'.PHP_EOL;

		$html = '<div id="relacionados"'.($class?' class="'.$class.'"':'').'>'.PHP_EOL.
		$html .= $head;
		$html .= $items;
		$html .= '</div>'.PHP_EOL;

		return $html;
	}

	private function obtener()
	{
		$listado = $this->get_defaults();
		$destacados = $this->get_featured();

		//Integrar la opción de seleccionar un recomendado general que se asigne en ocasiones especiales y siempre salga de primero.
			
		$listado = array_merge( $destacados, $listado );
		return array_slice($listado, 0, 3);					
	}

	private function get_defaults()
	{
		$d1 = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM micrositio WHERE id = ". $this->_micrositio_id . " AND estado <> 0");
		$generos = Micrositio::model()
					->cache(21600, $d1)
					->with('micrositio_x_genero')
					->findByPk($this->_micrositio_id);
		
		$listado = array();
		foreach($generos->micrositio_x_genero as $genero)
		{
			$dependencia = new CDbCacheDependency("SELECT MAX(creado) FROM micrositio_x_genero WHERE genero_id = ". $genero->genero_id ." AND micrositio_id != ". $this->_micrositio_id ." AND estado <> 0");

			$mxg = MicrositioXGenero::model()
					->cache(21600, $dependencia)
					->with('micrositio')
					->findAllByAttributes(
						array(
							'genero_id' => $genero->genero_id
						), 
						'micrositio_id != '.$this->_micrositio_id
					);
			foreach ($mxg as $m) {
				if($m->micrositio->miniatura)
					$listado[$m->micrositio_id] = $m->micrositio;
			}
		}
		if( count($listado) ) shuffle($listado);
		
		return $listado;
	}

	private function get_featured()
	{
		$d2 = new CDbCacheDependency("SELECT MAX(creado) FROM micrositio_x_relacionado WHERE micrositio_id = ". $this->_micrositio_id . " AND estado <> 0");
		$relacionados = MicrositioXRelacionado::model()
						->cache(21600, $d2)
						->with('relacionado')
						->findAllByAttributes( 
							array('micrositio_id' => $this->_micrositio_id), 
							array('order' => 'orden ASC') 
						);
		
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

		return $destacados;
	}

}