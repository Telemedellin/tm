<?php

class ApiController extends Controller
{
	public function actionFotoAlbum()
	{
		$af = AlbumFoto::model()->findAll();
		header('Content-Type: application/json; charset="UTF-8"');
		$json = '';
		$json .= '[';
			foreach($af as $album):
			$json .= '{';
				$json .= '"id":"'.CHtml::encode($album->id).'",';
				$json .= '"micrositio":"'.CHtml::encode($album->micrositio_id).'",';
				$json .= '"nombre":"'.CHtml::encode($album->nombre).'",';
				$json .= '"url":"'.bu($album->url->slug).'",';
				$json .= '"thumb":"'.bu('images/galeria/' . $album->fotos[0]->thumb).'"';
			$json .= '},';
			endforeach;
			$json = substr($json, 0, -1);
		$json .= ']';
		echo $json;
		Yii::app()->end();
	}
}