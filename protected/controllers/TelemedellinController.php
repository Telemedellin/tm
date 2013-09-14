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
		$micrositios= Micrositio::model()->listarPorSeccion( $seccion->id );
		if( !$micrositios ) throw new CHttpException(404, 'Invalid request');
		
		if( Yii::app()->request->isAjaxRequest )
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
		$micrositios= Micrositio::model()->listarPorSeccion( $seccion->id );
		if( !$micrositios ) throw new CHttpException(404, 'Invalid request');
		
		if( Yii::app()->request->isAjaxRequest )
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

		if( Yii::app()->request->isAjaxRequest )
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
		$c->limit = 7;
		$c->order = 'pg_documental.anio DESC';
		$recientes= Micrositio::model()->findAll( $c );

		if( !$recientes ) throw new CHttpException(404, 'Invalid request');
		$micrositios= Micrositio::model()->listarPorSeccion( $seccion->id );
		if( !$micrositios ) throw new CHttpException(404, 'Invalid request');

		if( Yii::app()->request->isAjaxRequest )
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
		$c->limit = 7;
		//$c->order = 'pg_especial.anio DESC';
		$recientes = Micrositio::model()->findAll( $c );

		if( !$recientes ) throw new CHttpException(404, 'Invalid request');
		$micrositios = Micrositio::model()->listarPorSeccion( $seccion->id );
		if( !$micrositios ) throw new CHttpException(404, 'Invalid request');

		if( Yii::app()->request->isAjaxRequest )
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
			$this->render('index');
		}
	}

	private function cargarConcursos()
	{
		$url_id = $_GET['tm']->id;
		$seccion = Seccion::model()->cargarPorUrl( $url_id );
		if( !$seccion ) throw new CHttpException(404, 'Invalid request');
		$micrositios= Micrositio::model()->listarPorSeccion( $seccion->id );
		if( !$micrositios ) throw new CHttpException(404, 'Invalid request');
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

		/*if( !is_null($micrositio->formulario_id) )
		{
			
		}
		else
			$formulario = false;
		*/
		if(!is_null($micrositio->albumFotos) )
		{
			$galeria = true;
		}
		else
			$galeria = false;

		if( !is_null($micrositio->albumVideos) )
		{
			$videos = true;
		}
		else
			$videos = false;

		if( !$pagina ) throw new CHttpException(404, 'No se encontró la página solicitada');

		$contenido = $this->renderPartial('_' . lcfirst($pagina['partial']), array('contenido' => $pagina), true);

		$this->render( 
			'micrositio', 
			array(	'seccion' 	=> $micrositio->seccion, 
					'micrositio'=> $micrositio, 
					'menu'		=> $menu,
					//'formulario'=> $formulario,
					'galeria'	=> $galeria,
					'video'		=> $videos,
					'pagina' 	=> $pagina['pagina'], 
					'contenido' => $contenido, 
				) 
		);
	}

	public function actionCargarImagenes()
	{
		$url = $_GET['tm'];

		if(isset($_GET['ajax'])) 
		{
			unset($_GET['ajax']);
			if( isset($_GET['m']) ){
				$m_id = $_GET['m'];
				$albumes = AlbumFoto::model()->findAllByAttributes( array('micrositio_id' => $m_id) );
				$micrositio = $albumes[0]->micrositio;
				$this->layout = '//layouts/iframe';
				$this->renderText('');
			}
		}
		else
		{
			cs()->registerScript( 'ajax', 
				'abrir_multimedia("imagenes");',
				CClientScript::POS_READY
			);
			$m = Micrositio::model()->findByPk( (int) $_GET['m'] );
			$this->actionCargarMicrositio($m->url->id);
		}
		
	}

	public function actionCargarAlbumImagenes()
	{
		$url_id = $_GET['tm']->id;
		$af = AlbumFoto::model()->findByAttributes( array('url_id' => $url_id) );
		$micrositio = Micrositio::model()->cargarMicrositio( $af->micrositio_id );
		$this->renderPartial( '_album', array('micrositio' => $micrositio, 'album' => $af ) );
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
		setlocale(LC_ALL, 'es-ES');
		
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
		//Horario::model()->
	}

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