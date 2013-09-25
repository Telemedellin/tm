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
				$json .= '"url":"'.$videoalbum->url->slug.'",';
				$json .= '"thumb":"'.$videoalbum->thumb.'"';
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
		$v = Video::model()->findAllByAttributes( array('album_video_id' => $va->id) );
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
					$thumbnail = '<img src=\"http://img.youtube.com/vi/'.$id_video.'/2.jpg\" width=\"120\" height=\"90\" />';
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

				    $thumbnail = '<img src=\"'.$return->thumbnail_url.'\" width=\"120\" height=\"90\" />';
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