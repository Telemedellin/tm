<?php

class TelemedellinController extends Controller
{
	public function actionError()
	{
		$this->render('error');
	}

	public function actionIndex()
	{
		$this->render('index');
	}

	public function actionCargar()
	{
		if( isset($_GET['tm']) )
		{
			switch ( $_GET['tm']->tipo ) {
				case 1:
					$this->cargar_seccion();
					break;
				case 2:
					if( $_GET['tm']->slug == 'novedades' )
						$this->cargar_novedades();
					else if( $_GET['tm']->slug == 'programacion' )
						$this->cargar_programacion();
					else
						$this->cargar_micrositio();
					break;
				case 3:
						$this->cargar_micrositio( $_GET['tm']->id );
					break;
				default:
					# code...
					break;
			}
		}
		//print_r($_GET);
	}

	public function actionCargarSeccion()
	{
		switch($_GET['tm']->slug){
			case 'telemedellin':
				$this->cargarTelemedellin();
				Yii::app()->end();
				break;
			case 'documentales':
				$this->cargarDocumentales();
				Yii::app()->end();
				break;
			case 'programas':
				$this->cargarProgramas();
				Yii::app()->end();
				break;
			case 'concursos':
				$this->cargarConcursos();
				Yii::app()->end();
				break;
			case 'especiales':
				$this->cargarEspeciales();
				Yii::app()->end();
				break;
		}

		$url_id = $_GET['tm']->id;
		$seccion = Seccion::model()->cargarPorUrl( $url_id );
		if( !$seccion ) throw new CHttpException(404, 'Invalid request');
		$micrositios = Micrositio::model()->listarPorSeccion( $seccion->id );
		if( !$micrositios ) throw new CHttpException(404, 'Invalid request');
		
		if( Yii::app()->request->isAjaxRequest && $_GET['ajax'] )
		{
			header('Content-Type: application/json; charset="UTF-8"');
			$this->renderPartial( 'json_seccion', array('seccion' => $seccion, 'micrositios' => $micrositios) );
			Yii::app()->end();
		}
		else 
		{
			$datos = $this->renderPartial( 'json_seccion', array('seccion' => $seccion, 'micrositios' => $micrositios), true );
			cs()->registerScript( 'ajax', 
				'success_popup(' . $datos . ');',
				CClientScript::POS_READY
			);
			$this->render('index');
		}
	}

	private function cargarTelemedellin()
	{
		$url_id = $_GET['tm']->id;
		$seccion = Seccion::model()->cargarPorUrl( $url_id );
		if( !$seccion ) throw new CHttpException(404, 'Invalid request');
		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM micrositio WHERE seccion_id = $seccion->id AND estado <> 0");
		$micrositios = Micrositio::model()->cache(3600, $dependencia)->with('paginas')->findAllByAttributes( array('seccion_id' => $seccion->id), array('condition' => 't.estado <> 0', 'order' => 't.creado DESC') );
		
		if( !$micrositios ) throw new CHttpException(404, 'Invalid request');
		
		if( Yii::app()->request->isAjaxRequest && $_GET['ajax'] )
		{
			header('Content-Type: application/json; charset="UTF-8"');
			$this->renderPartial( 'json_telemedellin', array('seccion' => $seccion, 'micrositios' => $micrositios) );
			Yii::app()->end();
		}
		else 
		{
			$datos = $this->renderPartial( 'json_telemedellin', array('seccion' => $seccion, 'micrositios' => $micrositios), true );
			cs()->registerScript( 'ajax', 
				'success_popup(' . $datos . ');',
				CClientScript::POS_READY
			);
			$this->render('index');
		}
	}

	private function cargarProgramas()
	{
		$url_id = $_GET['tm']->id;
		$seccion = Seccion::model()->cargarPorUrl( $url_id );
		if( !$seccion ) throw new CHttpException(404, 'Invalid request');
		$micrositios= Micrositio::model()->listarPorSeccion( $seccion->id );
		if( !$micrositios ) throw new CHttpException(404, 'Invalid request');

		if( Yii::app()->request->isAjaxRequest && $_GET['ajax'])
		{
			header('Content-Type: application/json; charset="UTF-8"');
			$this->renderPartial( 'json_programas', array('seccion' => $seccion, 'micrositios' => $micrositios) );
			Yii::app()->end();
		}
		else 
		{
			$datos = $this->renderPartial( 'json_programas', array('seccion' => $seccion, 'micrositios' => $micrositios), true );
			cs()->registerScript( 'ajax', 
				'success_popup(' . $datos . ');',
				CClientScript::POS_READY
			);
			$this->pageTitle = 'Programas';
			$this->render('index');
		}
	}

	private function cargarDocumentales()
	{
		$url_id = $_GET['tm']->id;

		$seccion = Seccion::model()->cargarPorUrl( $url_id );
		if( !$seccion ) throw new CHttpException(404, 'Invalid request');

		$c = new CDbCriteria;
		$c->addCondition('seccion_id = ' . $seccion->id);
		$c->addCondition(' t.estado <> 0');
		$c->join  = 'JOIN pagina ON pagina.micrositio_id = t.id';
		$c->join  .= ' JOIN pg_documental ON pg_documental.pagina_id = pagina.id';
		$c->limit = 8;
		$c->order = 'pg_documental.anio DESC';

		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM micrositio WHERE seccion_id = $seccion->id AND estado <> 0");

		$recientes= Micrositio::model()->cache(3600, $dependencia)->findAll( $c );

		if( !$recientes ) throw new CHttpException(404, 'Invalid request');
		$dependencia = new CDbCacheDependency("SELECT MAX(creado) FROM micrositio WHERE seccion_id = $seccion->id");
		$micrositios= Micrositio::model()->listarPorSeccion( $seccion->id );
		if( !$micrositios ) throw new CHttpException(404, 'Invalid request');

		if( Yii::app()->request->isAjaxRequest && $_GET['ajax'] )
		{
			header('Content-Type: application/json; charset="UTF-8"');
			$this->renderPartial( 'json_documentales', array('seccion' => $seccion, 'recientes' => $recientes, 'micrositios' => $micrositios) );
			Yii::app()->end();
		}
		else 
		{
			$datos = $this->renderPartial( 'json_documentales', array('seccion' => $seccion, 'recientes' => $recientes, 'micrositios' => $micrositios), true );
			cs()->registerScript( 'ajax', 
				'success_popup(' . $datos . ');',
				CClientScript::POS_READY
			);
			$this->pageTitle = 'Documentales';
			$this->render('index');
		}
	}

	private function cargarEspeciales()
	{
		$url_id = $_GET['tm']->id;

		$seccion = Seccion::model()->cargarPorUrl( $url_id );
		if( !$seccion ) throw new CHttpException(404, 'Invalid request');

		$c = new CDbCriteria;
		$c->addCondition('seccion_id = ' . $seccion->id);
		$c->addCondition(' t.estado <> 0');
		$c->join  = 'JOIN pagina ON pagina.micrositio_id = t.id';
		$c->join  .= ' JOIN pg_especial ON pg_especial.pagina_id = pagina.id';
		$c->join  .= ' LEFT JOIN fecha_especial ON pg_especial.id = fecha_especial.pg_especial_id';
		$c->group = 'pg_especial.id';
		$c->limit = 8;
		$c->order = 'fecha_especial.fecha DESC, t.destacado DESC, t.creado DESC';

		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM micrositio WHERE seccion_id = $seccion->id AND estado <> 0");

		$recientes = Micrositio::model()->cache(3600, $dependencia)->findAll( $c );

		if( !$recientes ) throw new CHttpException(404, 'Invalid request');
		
		$micrositios = Micrositio::model()->listarPorSeccion( $seccion->id );
		
		if( !$micrositios ) throw new CHttpException(404, 'Invalid request');

		if( Yii::app()->request->isAjaxRequest && $_GET['ajax'] )
		{
			header('Content-Type: application/json; charset="UTF-8"');
			$this->renderPartial( 'json_documentales', 
				array('seccion' => $seccion, 'recientes' => $recientes, 'micrositios' => $micrositios) );
			Yii::app()->end();
		}
		else 
		{
			$datos = $this->renderPartial( 'json_documentales', 
				array('seccion' => $seccion, 'recientes' => $recientes, 'micrositios' => $micrositios), true );
			cs()->registerScript( 'ajax', 
				'success_popup(' . $datos . ');',
				CClientScript::POS_READY
			);
			$this->pageTitle = 'Especiales';
			$this->render('index');
		}
	}

	private function cargarConcursos()
	{
		$url_id = $_GET['tm']->id;
		$seccion = Seccion::model()->cargarPorUrl( $url_id );
		if( !$seccion ) throw new CHttpException(404, 'Invalid request');
		$micrositios = Micrositio::model()->listarPorSeccion( $seccion->id );
		//if( !$micrositios ) throw new CHttpException(404, 'Invalid request');
		$this->pageTitle = 'Concursos';
		$this->render( 'seccion', array('seccion' => $seccion, 'micrositios' => $micrositios) );
	}

	public function actionCargarMicrositio( $url_id = 0 )
	{
		if( !$url_id ) $url_id = $_GET['tm']->id;

		if( isset($_GET['slug_id']) )
		{
			$pagina  = Pagina::model()->cargarPorUrl( $_GET['slug_id'] );
			$micrositio = Micrositio::model()->cargarMicrositio( $pagina['pagina']->micrositio_id );
		}
		else
		{
			$micrositio = Micrositio::model()->cargarPorUrl( $url_id );
			if( $micrositio->pagina_id != NULL )
				$pagina  = Pagina::model()->cargarPagina( $micrositio->pagina_id );
			else
				$pagina  = Pagina::model()->cargarPorMicrositio( $micrositio->id );
		}

		if( !is_null($micrositio->menu_id) )
		{
			$menu = $micrositio->menu_id;
		}
		else
		{
			$menu = false;
		}

		$formulario = false;

		if( !empty($micrositio->paginas) )
		{
			foreach($micrositio->paginas as $p)
				if($p->tipo_pagina_id == 7){
					$formulario = true;
					break;
				}
		}
		
		if(!empty($micrositio->albumFotos) )
			$galeria = true;
		else
			$galeria = false;

		if( !empty($micrositio->albumVideos) )
		{
			$videos = true;
		}
		else
			$videos = false;

		if( !$pagina ) throw new CHttpException(404, 'No se encontró la página solicitada');

		$contenido = $this->renderPartial('_' . lcfirst($pagina['partial']), array('contenido' => $pagina), true);
		$fondo_pagina = (isset($pagina['contenido']->imagen) && !is_null($pagina['contenido']->imagen))?$pagina['contenido']->imagen:'';

		$this->render( 
			'micrositio', 
			array(	'seccion' 	=> $micrositio->seccion, 
					'micrositio'=> $micrositio, 
					'menu'		=> $menu,
					'formulario'=> $formulario,
					'galeria'	=> $galeria,
					'video'		=> $videos,
					'pagina' 	=> $pagina['pagina'], 
					'contenido' => $contenido, 
					'fondo_pagina' => $fondo_pagina
				) 
		);
	}

	public function actionCargarProgramacion()
	{
		$url_id = $_GET['tm']->id;
		$micrositio = Micrositio::model()->cargarPorUrl( $url_id );

		$pagina = new stdClass();
		$pagina->id   = NULL;
		$pagina->clase = 'programacion';
		$pagina->tipoPagina = new stdClass();
		$pagina->tipoPagina->tabla = 'programacion';

		date_default_timezone_set('America/Bogota');
		setlocale(LC_ALL, 'es_ES.UTF-8');
		
		$sts = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
		$tts = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

		if( isset($_GET['dia']) &&  isset($_GET['mes']) )
		{
			$dia = $_GET['dia'];
			$mes = $_GET['mes'];
			$anio = ( isset( $_GET['anio'] ) ) ? $_GET['anio'] : date('Y');
			if( checkdate($mes, $dia, $anio) )
			{
				$sts = mktime(0, 0, 0, $mes, $dia, $anio);
			}
		}

		// set current date
		// parse about any English textual datetime description into a Unix timestamp
		$ts 		= $sts;
		// calculate the number of days since Monday
		$dow 		= date('w', $ts);
		$offset 	= $dow - 1;
		if ($offset < 0) $offset = 6;
		// calculate timestamp for the Monday
		$ts 		= $ts - $offset * 86400;
		$semana 	= array();

		// loop from Monday till Sunday
		for ($i = 0; $i < 7; $i++, $ts += 86400){
		    $semana[] = $ts;
		}
		$p = new Programacion;
		$programas = $p->getDay( $sts );

		$contenido = $this->renderPartial(
				'_programacion', 
				array(
					'programas' => $programas,
					'menu'		=> $semana,
				), 
				true
			);
		$this->render( 
			'micrositio', 
			array(	'seccion' 	=> $micrositio->seccion, 
					'micrositio'=> $micrositio, 
					'pagina' 	=> $pagina, 
					'hoy' 		=> $tts,
					'formulario'=> false,
					'galeria'	=> false,
					'video'		=> false, 
					'contenido' => $contenido, 
				) 
		);
	}

	public function actionPopup()
	{
		$this->layout = '//layouts/iframe';
		$this->renderText('');
	}

	public function actionProgramar()
	{
		$dias_semana = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
		$horarios = Horario::model()->with('pgPrograma')->findAll( 
			array('order' => 'dia_semana ASC, hora_inicio ASC', 'condition' => 'pgPrograma.estado = 2') 
		);
		
		foreach($horarios as $horario)
		{
			$pagina = Pagina::model()->findByPk($horario->pgPrograma->pagina_id);
			$micrositio_id = $pagina->micrositio_id;
			$tipo_emision_id = $horario->tipo_emision_id;
			$dia_semana = $horario->dia_semana;
			$hora_inicio = $horario->hora_inicio;
			$hora_fin = $horario->hora_fin;
			$estado = 1;

			date_default_timezone_set('America/Bogota');
			setlocale(LC_ALL, 'es_ES.UTF-8');

			$sts = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
			$tts = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

			// set current date
			// parse about any English textual datetime description into a Unix timestamp
			$ts 		= $sts;
			// calculate the number of days since Monday
			$dow 		= date('w', $ts);
			$offset 	= $dow - 1;
			if ($offset < 0) $offset = 6;
			// calculate timestamp for the Monday
			$ts 		= $ts - $offset * 86400;
			$semana 	= array();

			// loop from Monday till Sunday
			for ($i = 0; $i < 7; $i++, $ts += 86400){
			    $semana[] = $ts;
			}

			//echo 'Hora --- ' . $hora_inicio . ' --- ' . Horarios::hora_a_timestamp($hora_inicio);
			//echo '<br /><br />';

			$hora_inicio = $semana[$dia_semana - 1] + (Horarios::hora_a_timestamp($hora_inicio));
			$hora_fin = $semana[$dia_semana - 1] + (Horarios::hora_a_timestamp($hora_fin));
			$p = new Programacion;
			if( !$p->exists(array('condition' => 'hora_inicio='.$hora_inicio.' AND hora_fin='.$hora_fin.' AND estado=1')) )
			{
				$p->micrositio_id = $micrositio_id;
				$p->hora_inicio = $hora_inicio;
				$p->hora_fin = $hora_fin;
				$p->tipo_emision_id = $tipo_emision_id;
				$p->estado = $estado;
				$p->save();
				if($p) echo 'Guardado ' . $pagina->nombre . ' ' . $hora_inicio . '<br />';
			}else
			{
				echo 'Existía ' . $pagina->nombre . '<br />';
			}
			
		}
	}

	public function actionUrlsHuerfanas()
	{
		$urls = URL::model()->with('albumFotos', 'albumVideos', 'fotos', 'videos', 'archivos', 'carpetas', 'seccions', 'micrositios', 'menuItems', 'paginas')->findAll();
		$huerfanos = array();
		$c = 0;
		echo '<h2>Buscando huerfanos...</h2>';
		foreach($urls as $u){
			if( !empty($u->albumFotos) ) $c++;
			if( !empty($u->albumVideos) ) $c++;
			if( !empty($u->fotos) ) $c++;
			if( !empty($u->videos) ) $c++;
			if( !empty($u->archivos) ) $c++;
			if( !empty($u->carpetas) ) $c++;
			if( !empty($u->seccions) ) $c++;
			if( !empty($u->micrositios) ) $c++;
			if( !empty($u->menuItems) ) $c++;
			if( !empty($u->paginas) ) $c++;
			if($c == 0){
				$huerfanos[] = $u;
				echo('Huerfano... ' . $u->slug . '<br />');
			}else{
				echo('Bueno...... ' . $u->slug . '<br />');
			}
			$c = 0;
		}
		echo '<h2>Limpiando huerfanos...</h2>';
		foreach($huerfanos as $h){
			$utd = new Url;
			$slug = $h->slug;
			if($utd->deleteByPk($h->id))
				echo 'Limpiado............. ' . $slug . '<br />';
			else
				echo 'No se pudo limpiar... ' . $slug . '<br />';
		}
		echo '<h2>Fin</h2>';
	}

	public function actionMapaDelSitio()
	{
		$cc = new CDbCriteria;
		$ccc = array('tipo_id <> 5',
					 'tipo_id <> 6',
					 'tipo_id <> 8',
					 'tipo_id <> 9',
					 'tipo_id <> 10',
					 'tipo_id <> 11',);
		$cc->addCondition($ccc);
		
		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM url WHERE estado <> 0");
		$urls = URL::model()->cache(3600, $dependencia)->findAll($cc);
		header("Content-type: text/xml; charset=utf-8");
		if($this->beginCache('sitemap', 
								array('dependency'=>
										array(
									       	'class'=>'system.caching.dependencies.CDbCacheDependency',
									       	'sql'=>'SELECT GREATEST(MAX(creado), MAX(modificado)) FROM url WHERE estado <> 0'
									    )
								)
							)
			) 
		{
			echo '<?xml version="1.0" encoding="UTF-8"?>' . "\r\n";
			echo '<urlset xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance" xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd" xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">' . "\r\n";
			foreach($urls as $u){
				echo '<url>' . "\r\n";
				echo '	<loc>' . Yii::app()->request->hostInfo . bu($u->slug) . '</loc>' . "\r\n";
				echo '</url>' . "\r\n";
			}
			echo '</urlset>';
			$this->endCache(); 
		}
	}

	/*public function actionThumbs(){
		$fotos = Foto::model()->findAll();
		foreach($fotos as $foto){
			$thumb = $foto->thumb;
			$ext = substr($thumb, -4);
			$nombre = substr($thumb, 0, strlen($thumb)-4 );
			$nuevo_nombre = $nombre.'_thumb'.$ext;

			$foto->thumb = $nuevo_nombre;
			$foto->save();
		}
	}
	public function actionRutas(){
		$fotos = Micrositio::model()->findAll(array('limit' => 100));
		foreach($fotos as $foto){
			$background = $foto->background;
			if(substr($background, 0, 8) == '/images/')
				$foto->background = substr($background, 8);
			/*
			$thumb = $foto->thumb;
			if(substr($thumb, 0, 16) == '/images/')
				$foto->thumb = substr($thumb, 16);
			$foto->save();
		}
	}*/

	// Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}