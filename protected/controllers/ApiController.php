<?php

class ApiController extends Controller
{
	public function actionFotoAlbum()
	{
		if(!$_GET['micrositio_id']) throw new CHttpException(404, 'No se encontró la página solicitada');
		$micrositio_id = $_GET['micrositio_id'];
		$af = AlbumFoto::model()->findAllByAttributes( array('micrositio_id' => $micrositio_id) );
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '';
		$json .= '[';
			foreach($af as $album):
			$json .= '{';
				$json .= '"id":"'.CHtml::encode($album->id).'",';
				$json .= '"micrositio":"'.CHtml::encode($album->micrositio_id).'",';
				$json .= '"nombre":"'.CHtml::encode($album->nombre).'",';
				$json .= '"url":"'.$album->url->slug.'",';
				$json .= '"thumb":"'.bu('images/galeria/' . $album->fotos[0]->thumb).'"';
			$json .= '},';
			endforeach;
			$json = substr($json, 0, -1);
		$json .= ']';
		echo $json;
		Yii::app()->end();
	}

	public function actionFoto()
	{
		if(!$_GET['nombre']) throw new CHttpException(404, 'No se encontró la página solicitada');
		if(!$_GET['micrositio']) throw new CHttpException(404, 'No se encontró la página solicitada');
		$nombre = $_GET['nombre'];
		$micrositio = $_GET['micrositio'];
		$af = AlbumFoto::model()->findByAttributes( array('nombre' => $nombre, 'micrositio_id' => $micrositio)  );
		if(!$af) throw new CHttpException(404, 'No se encontró la página solicitada');
		$f = Foto::model()->findAllByAttributes( array('album_foto_id' => $af->id) );
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '';
		$json .= '[';
			foreach($f as $foto):
			$json .= '{';
				$json .= '"id":"'.CHtml::encode($foto->id).'",';
				$json .= '"album_foto":"'.CHtml::encode($foto->albumFoto->nombre).'",';
				$json .= '"url":"'.CHtml::encode($foto->url->slug).'",';
				$json .= '"nombre":"'.CHtml::encode($foto->nombre).'",';
				$json .= '"src":"'.bu('images/galeria/' . $foto->src).'",';
				$json .= '"thumb":"'.bu('images/galeria/' . $foto->thumb).'",';
				$json .= '"ancho":"'.CHtml::encode($foto->ancho).'",';
				$json .= '"alto":"'.CHtml::encode($foto->alto).'"';
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
		$va = AlbumVideo::model()->with('url')->findAllByAttributes( array('micrositio_id' => $micrositio_id) );
		
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '';
		$json .= '[';
			foreach($va as $videoalbum):
			$json .= '{';
				$json .= '"id":"'.CHtml::encode($videoalbum->id).'",';
				$json .= '"micrositio":"'.CHtml::encode($videoalbum->micrositio_id).'",';
				$json .= '"nombre":"'.CHtml::encode($videoalbum->nombre).'",';
				$json .= '"url":"'.$videoalbum->url->slug.'"';
				//$json .= '"thumb":"'.bu('images/galeria/' . $videoalbum->fotos[0]->thumb).'"';
			$json .= '},';
			endforeach;
			$json = substr($json, 0, -1);
		$json .= ']';
		echo $json;
		Yii::app()->end();
	}
	
	public function actionVideo()
	{
		if(!$_GET['nombre']) throw new CHttpException(404, 'No se encontró la página solicitada');
		if(!$_GET['micrositio']) throw new CHttpException(404, 'No se encontró la página solicitada');
		$nombre = $_GET['nombre'];
		$micrositio = $_GET['micrositio'];
		$va = AlbumVideo::model()->with('url')->findByAttributes( array('nombre' => $nombre, 'micrositio_id' => $micrositio)  );
		if(!$va) throw new CHttpException(404, 'No se encontró la página solicitada');
		$v = Video::model()->findAllByAttributes( array('album_video_id' => $va->id) );
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '';
		$json .= '[';
			foreach($v as $video):
			$json .= '{';
				$json .= '"id":"'.CHtml::encode($video->id).'",';
				$json .= '"album_video":"'.CHtml::encode($video->albumVideo->nombre).'",';
				$json .= '"proveedor_video":"'.CHtml::encode($video->proveedorVideo->nombre).'",';
				$json .= '"nombre":"'.CHtml::encode($video->nombre).'",';
				$json .= '"url":"'.$video->url.'",';
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
		$micrositio = Micrositio::model()->findByPk( $micrositio_id );
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '{';
		$json .= '"id":"'.CHtml::encode($micrositio->id).'",';
		$json .= '"nombre":"'.CHtml::encode($micrositio->nombre).'"';
		$json .= '}';
		echo $json;
		Yii::app()->end();
	}
}