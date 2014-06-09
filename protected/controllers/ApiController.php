<?php

class ApiController extends Controller
{
	public function actionFotoAlbum()
	{
		if(!$_GET['micrositio_id']) throw new CHttpException(404, 'No se encontró la página solicitada');
		$micrositio_id = $_GET['micrositio_id'];
		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM album_foto WHERE micrositio_id = $micrositio_id AND estado <> 0");
		$af = AlbumFoto::model()->cache(86400, $dependencia)->findAllByAttributes( array('micrositio_id' => $micrositio_id), array('order' => 'destacado DESC, modificado DESC, creado DESC') );
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '';
		$json .= '[';
			foreach($af as $album):
			$json .= '{';
				$json .= '"id":"'.$album->id.'",';
				$json .= '"micrositio":"'.$album->micrositio_id.'",';
				$json .= '"nombre":"'.$album->nombre.'",';
				$json .= '"url":"'.$album->url->slug.'",';
				$json .= '"thumb":"'.bu('images/galeria/' . $album->directorio . $album->fotos[0]->src).'"';
			$json .= '},';
			endforeach;
			$json = substr($json, 0, -1);
		$json .= ']';
		echo $json;
		Yii::app()->end();
	}

	public function actionFoto()
	{
		if(!$_GET['hash']) throw new CHttpException(404, 'No se encontró la página solicitada');
		if(!$_GET['micrositio']) throw new CHttpException(404, 'No se encontró la página solicitada');
		$hash = $_GET['hash'];
		$micrositio = $_GET['micrositio'];
		$url = Url::model()->findByAttributes( array('slug' => $hash) );
		if($url->tipo_id == 5){
			$url_id = $url->id;
			$af = AlbumFoto::model()->findByAttributes( array('url_id' => $url_id, 'micrositio_id' => $micrositio)  );
		}
		else if($url->tipo_id == 6)
		{
			$foto = Foto::model()->findByAttributes( array('url_id' => $url->id) );
			$af = AlbumFoto::model()->findByPk( $foto->album_foto_id );
		}
			
		
		if(!$af) throw new CHttpException(404, 'No se encontró la página solicitada');

		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM foto WHERE album_foto_id = $af->id AND estado <> 0");
		$f = Foto::model()->cache(86400, $dependencia)->findAllByAttributes( array('album_foto_id' => $af->id), array('order' => 'destacado DESC, modificado DESC, creado DESC') );
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '';
		$json .= '[';
			foreach($f as $foto):
			$json .= '{';
				$json .= '"id":"'.$foto->id.'",';
				$json .= '"album_foto":"'.$foto->albumFoto->nombre.'",';
				$json .= '"url":"'.$foto->url->slug.'",';
				$json .= '"nombre":"'.$foto->nombre.'",';
				$json .= '"src":"'.bu('images/galeria/' . $foto->albumFoto->directorio . $foto->src).'",';
				$json .= '"thumb":"'.bu('images/galeria/' . $foto->albumFoto->directorio . $foto->thumb).'",';
				$json .= '"ancho":"'.$foto->ancho.'",';
				$json .= '"alto":"'.$foto->alto.'"';
			$json .= '},';
			endforeach;
			$json = substr($json, 0, -1);
		$json .= ']';
		echo $json;
		Yii::app()->end();
	}

	public function actionVideoAlbum()
	{
		if(!$_GET['micrositio_id']) throw new CHttpException(404, 'No se encontró la página solicitada');
		$micrositio_id = $_GET['micrositio_id'];
		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM album_video WHERE micrositio_id = $micrositio_id AND estado <> 0");
		$va = AlbumVideo::model()->cache(86400, $dependencia)->with('url')->findAllByAttributes( array('micrositio_id' => $micrositio_id), array('order' => 't.destacado DESC, t.modificado DESC, t.creado DESC') );
		
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '';
		$json .= '[';
			foreach($va as $videoalbum):
			$json .= '{';
				$json .= '"id":"'.CHtml::encode($videoalbum->id).'",';
				$json .= '"micrositio":"'.CHtml::encode($videoalbum->micrositio_id).'",';
				$json .= '"nombre":"'.CHtml::encode($videoalbum->nombre).'",';
				$json .= '"url":"'.$videoalbum->url->slug.'",';
				$json .= '"thumb":"'.bu('images/'.$videoalbum->thumb).'"';
			$json .= '},';
			endforeach;
			$json = substr($json, 0, -1);
		$json .= ']';
		echo $json;
		Yii::app()->end();
	}
	
	public function actionVideo()
	{
		if(!$_GET['hash']) throw new CHttpException(404, 'No se encontró la página solicitada');
		if(!$_GET['micrositio']) throw new CHttpException(404, 'No se encontró la página solicitada');
		$hash = $_GET['hash'];
		$micrositio = $_GET['micrositio'];

		$url = Url::model()->findByAttributes( array('slug' => $hash) );
		if($url->tipo_id == 8){
			$url_id = $url->id;
			$va = AlbumVideo::model()->findByAttributes( array('url_id' => $url_id, 'micrositio_id' => $micrositio)  );
		}
		else if($url->tipo_id == 9)
		{
			$video = Video::model()->findByAttributes( array('url_id' => $url->id) );
			$va = AlbumVideo::model()->findByPk( $video->album_video_id );
		}

		if(!$va) throw new CHttpException(404, 'No se encontró la página solicitada');
		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM video WHERE album_video_id = $va->id AND estado <> 0");
		$v = Video::model()->cache(86400, $dependencia)->findAllByAttributes( array('album_video_id' => $va->id), array('order' => 'destacado DESC, modificado DESC, creado DESC') );
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '';
		$json .= '[';
			foreach($v as $video):
			$json .= '{';
				$json .= '"id":"'.CHtml::encode($video->id).'",';
				$json .= '"album_video":"'.CHtml::encode($video->albumVideo->nombre).'",';
				$json .= '"proveedor_video":"'.CHtml::encode($video->proveedorVideo->nombre).'",';
				$json .= '"url":"'.CHtml::encode($video->url->slug).'",';
				$json .= '"nombre":"'.CHtml::encode($video->nombre).'",';
				$json .= '"descripcion":'.json_encode($video->descripcion).',';
				$json .= '"url_video":"'.$video->url_video.'",';
				if($video->proveedor_video_id == 1){
					preg_match("/^(?:http(?:s)?:\/\/)?(?:www\.)?(?:youtu\.be\/|youtube\.com\/(?:(?:watch)?\?(?:.*&)?v(?:i)?=|(?:embed|v|vi|user)\/))([^\?&\"'>]+)/", $video->url_video, $matches);
					if(isset($matches[1])){
						$id_video = $matches[1];
					}else{
						$id_video = 0;
					}
					$thumbnail = 'http://img.youtube.com/vi/'.$id_video.'/0.jpg';
				}else if($video->proveedor_video_id == 2){
					$url = 'http://vimeo.com/api/oembed.json?url='.rawurlencode($video->url_video);
					$curl = curl_init($url);
				    curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
				    curl_setopt($curl, CURLOPT_TIMEOUT, 30);
				    curl_setopt($curl, CURLOPT_FOLLOWLOCATION, 1);
				    $return = curl_exec($curl);
				    curl_close($curl);
				    $return = json_decode($return);
				    $id_video = $return->video_id;

				    $thumbnail = $return->thumbnail_url;
				}else{
					$id_video = 0;
				}
				$json .= '"id_video":"'.$id_video.'",';
				$json .= '"thumbnail":"'.$thumbnail.'",';
				$json .= '"duracion":"'.$video->duracion.'"';
			$json .= '},';
			endforeach;
			$json = substr($json, 0, -1);
		$json .= ']';
		echo $json;
		Yii::app()->end();
	}

	public function actionMicrositio(){
		if(!$_GET['id']) throw new CHttpException(404, 'No se encontró la página solicitada');
		$micrositio_id = $_GET['id'];
		$micrositio = Micrositio::model()->findByPk( $micrositio_id, array('order' => 'nombre ASC') );
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '{';
		$json .= '"id":"'.CHtml::encode($micrositio->id).'",';
		$json .= '"nombre":"'.CHtml::encode($micrositio->nombre).'"';
		$json .= '}';
		echo $json;
		Yii::app()->end();
	}

	public function actionPagina(){
		if(!$_GET['id']) throw new CHttpException(404, 'No se encontró la página solicitada');
		$pagina_id = $_GET['id'];
		$pagina = Pagina::model()->findByPk( $pagina_id, array('order' => 'nombre ASC') );
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '{';
		$json .= '"id":"'.CHtml::encode($pagina->id).'",';
		$json .= '"nombre":"'.CHtml::encode($pagina->nombre).'"';
		$json .= '}';
		echo $json;
		Yii::app()->end();
	}

	public function actionCarpeta()
	{
		$params = array();
		$w = '';

		if( isset($_GET['pagina_id']) ){
			$pagina_id = $_GET['pagina_id'];
			$params['pagina_id'] = $pagina_id;
			$params['item_id'] = 0;
			$w = ' pagina_id = ' . $pagina_id . ' AND item_id = 0 AND ';
		}
		if( isset($_GET['hash']) ){
			$hash = $_GET['hash'];
			$url = Url::model()->findByAttributes( array('slug' => $hash) );
			$ca = Carpeta::model()->findByAttributes( array('url_id' => $url->id) );
			if($ca){
				$params['item_id'] = $ca->id;
				$w = ' item_id = ' . $ca->id . ' AND ';
			}
		}

		header('Content-Type: application/json; charset="UTF-8"');
		$json = '';

		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM carpeta WHERE estado <> 0");
		$c = Carpeta::model()/*->cache(86400, $dependencia)/**/->findAllByAttributes( $params );	
		
		if($c)
		{
			$json .= '[';
				foreach($c as $carpeta):
				$json .= '{';
					$json .= '"id":"'.CHtml::encode($carpeta->id).'",';
					$json .= '"pagina":"'.CHtml::encode($carpeta->pagina_id).'",';
					$json .= '"carpeta":"'.CHtml::encode($carpeta->carpeta).'",';
					$json .= '"url":"'.$carpeta->url->slug.'",';
					$json .= '"ruta":"'.$carpeta->ruta.'",';
					$json .= '"hijos":"'.$carpeta->hijos.'"';
				$json .= '},';
				endforeach;
				$json = substr($json, 0, -1);
			$json .= ']';
		}
		
		echo $json;
		Yii::app()->end();
	}

	public function actionArchivo()
	{
		if(!$_GET['hash']) throw new CHttpException(404, 'No se encontró la página solicitada');
		$hash = $_GET['hash'];
		$url = Url::model()->findByAttributes( array('slug' => $hash) );
		$params = array();
		if($url->tipo_id == 10){
			$c = Carpeta::model()->findByAttributes( array('url_id' => $url->id) );	
			if($c){
				$params['carpeta_id'] = $c->id;
				$w = ' carpeta_id = ' . $c->id . ' AND ';
			} 
		}else if($url->tipo_id == 11){
			$params['url_id'] = $url->id;
			$w = ' url_id = ' . $url->id . ' AND ';
		}
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '';
		
		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM archivo WHERE estado <> 0");
		$a = Archivo::model()/*->cache(86400, $dependencia)/**/->findAllByAttributes( $params, array('order' => 'nombre ASC') );
		
		if($a)
		{
			$json .= '[';
				foreach($a as $archivo):
				$json .= '{';
					$json .= '"id":"'.CHtml::encode($archivo->id).'",';
					$json .= '"url":"'.CHtml::encode($archivo->url->slug).'",';
					$json .= '"tipo_archivo":"'.$archivo->tipoArchivo->nombre.'",';
					//$json .= '"carpeta":"'.CHtml::encode($archivo->carpeta->ruta).'",';
					$json .= '"carpeta":';
						$json .= '{';
						$json .= '"ruta":"'.CHtml::encode($archivo->carpeta->ruta).'",';
						$json .= '"url":"'.CHtml::encode($archivo->carpeta->url->slug).'"';
						$json .= '},';
					$json .= '"nombre":"'.CHtml::encode($archivo->nombre).'",';
					$json .= '"archivo":"'.$archivo->archivo.'"';
				$json .= '},';
				endforeach;
				$json = substr($json, 0, -1);
			$json .= ']';
		}
		
		echo $json;
		Yii::app()->end();
	}

	public function actionMicrositios($term = '')
	{
		$dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(creado), MAX(modificado)) FROM micrositio WHERE (seccion_id = 2 OR seccion_id = 3 OR seccion_id = 4) AND estado <> 0");
		$micrositios = Micrositio::model()->cache(86400, $dependencia)->with('seccion')->findAll('(seccion_id = 2 OR seccion_id = 3 OR seccion_id = 4) AND t.nombre LIKE "%'.$term.'%"');
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '[';
		foreach($micrositios as $micrositio):
			$json .= '{';
			$json .= '"label":"'.$micrositio->nombre.'",';
			$json .= '"value":"'.$micrositio->nombre.'",';
			$json .= '"id":"'.$micrositio->id.'"';
			$json .= '},';
		endforeach;
		$json = substr($json, 0, -1);
		$json .= ']';
		echo $json;
		Yii::app()->end();
	}

}