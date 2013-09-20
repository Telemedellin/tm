<?php //header('Content-Type: application/json; charset="UTF-8"'); ?>
<?php 
$json = '';
$json .= '{';
	if(isset($seccion))	$json .= '"seccion":"'.$seccion->nombre.'",';
	if(isset($seccion))	$json .= '"url":"'.bu($seccion->url->slug).'",';
	if(isset($micrositios)) $json .= '"micrositios":';
	$json .= '[';
		foreach($micrositios as $micrositio):
		$json .= '{';
			$json .= '"nombre":"'.CHtml::encode($micrositio->nombre).'",';
			$json .= '"url":"'.bu($micrositio->url->slug).'",';
			$json .= '"paginas":[';
			foreach($micrositio->paginas as $pagina):
				$json .= '{';
				$json .= '"nombre":"'.CHtml::encode($pagina->nombre).'"';
				$json .= '},';
			endforeach;
			$json = substr($json, 0, -1);
			$json .= ']';
		$json .= '},';
		endforeach;
		$json = substr($json, 0, -1);
	$json .= ']';
$json .= '}';
echo $json;
?>
<?php //Yii::app()->end();?>