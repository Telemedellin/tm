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
			switch ( count($_GET['tm']) ) {
				case 1:
					$this->cargar_seccion();
					break;
				case 2 || 3:
					if( $_GET['tm']['micrositio']['slug'] == 'novedades' && !isset( $_GET['tm']['pagina'] ) )
						$this->cargar_novedades();
					else if( $_GET['tm']['micrositio']['slug'] == 'programacion' && !isset( $_GET['tm']['pagina'] ) )
						$this->cargar_programacion();
					else
						$this->cargar_micrositio();
					break;
				case 3:
					echo 'página ' . $_GET['tm']['pagina'];
					break;
				default:
					# code...
					break;
			}
		}
		//print_r($_GET);
	}

	private function cargar_seccion()
	{
		$seccion 	= $_GET['tm']['seccion'];
		$la_seccion = Seccion::model()->findByPk( $seccion['id'], 't.estado <> 0' );
		if( !$la_seccion ) throw new CHttpException(404, 'Invalid request');
		$micrositios= Micrositio::model()->findAllByAttributes( array('seccion_id' => $seccion['id']), 't.estado <> 0' );
		if( !$micrositios ) throw new CHttpException(404, 'Invalid request');
		$this->render( 'seccion', array('seccion' => $la_seccion, 'micrositios' => $micrositios) );
	}

	private function cargar_micrositio()
	{
		$seccion  	= $_GET['tm']['seccion'];
		$micrositio = $_GET['tm']['micrositio'];

		if( !is_null($micrositio['menu_id']) )
		{
			$menu = $micrositio['menu_id'];
		}
		else
		{
			$menu = false;
		}

		$pagina_slug  = ( isset($_GET['tm']['pagina']) ) ? $_GET['tm']['pagina'] : 'default';

		$pagina  = Pagina::model()->cargarPagina($micrositio['id'], $pagina_slug);

		if( !$pagina ) throw new CHttpException(404, 'No se encontró la página solicitada');

		$contenido = $this->renderPartial('_'.$pagina['partial'], array('contenido' => $pagina), true);

		$this->render( 
			'micrositio', 
			array(	'seccion' 	=> $seccion, 
					'micrositio'=> $micrositio, 
					'menu'		=> $menu,
					'pagina' 	=> $pagina['pagina'], 
					'contenido' => $contenido, 
				) 
		);
	}

	private function cargar_novedades()
	{
		$seccion  	= $_GET['tm']['seccion'];
		$micrositio = $_GET['tm']['micrositio'];

		$novedades = Pagina::model()->listarPaginas( $micrositio['id'] );
		//$novedades = Pagina::model()->with('pgArticuloBlogs')->findAllByAttributes( array('micrositio_id' => $micrositio['id']), array('order' => 'creado DESC') );

		$pagina = new stdClass();
		$pagina->id   = NULL;

		$contenido = $this->renderPartial('_novedades', array('novedades' => $novedades), true);

		$this->render( 
			'micrositio', 
			array(	'seccion' 	=> $seccion, 
					'micrositio'=> $micrositio, 
					'pagina' 	=> $pagina, 
					'contenido' => $contenido, 
				) 
		);
	}

	private function cargar_programacion()
	{
		$seccion  	= $_GET['tm']['seccion'];
		$micrositio = $_GET['tm']['micrositio'];

		//$programacion = Pagina::model()->listarPaginas( $micrositio['id'] );

		$pagina = new stdClass();
		$pagina->id   = NULL;

		//$contenido = $this->renderPartial('_novedades', array('novedades' => $novedades), true);

		//$this->widget('ext.programacion.ProgramacionWidget');
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
		    //echo $ts . ' ' . $sts . '<br />';
		    //if($ts === $sts) echo strftime("%A %d", $ts). '<br />';
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
			array(	'seccion' 	=> $seccion, 
					'micrositio'=> $micrositio, 
					'pagina' 	=> $pagina, 
					'hoy' 		=> $tts, 
					'contenido' => $contenido, 
				) 
		);
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