<?php 
$destacados = '';
$json = '';
$json .= '{';
	if(isset($seccion))	$json .= '"seccion":"'.$seccion->nombre.'",';
	if(isset($seccion))	$json .= '"url":"'.bu($seccion->url->slug).'",';
	if(isset($micrositios)) $json .= '"micrositios":';
	$json .= '[';
		foreach($micrositios as $micrositio):
			if($micrositio->destacado):
				$destacados .= '{';
				$destacados .= '"nombre":"' . $micrositio->nombre . '",';
				$destacados .= '"url":"' . bu($micrositio->url->slug) . '",';
				$destacados .= '"miniatura":"' . bu($micrositio->miniatura) . '"';
				$destacados .= '},';
			endif;
		$json .= '{';
			$json .= '"nombre":"'.CHtml::encode($micrositio->nombre).'",';
			$json .= '"url":"'.bu($micrositio->url->slug).'"';
		$json .= '},';
		endforeach;
		$json = substr($json, 0, -1);
	$json .= '],';
	$json .= '"destacados":';
	$json .= '[';
	$json .= $destacados;
	$json = substr($json, 0, -1);
	$json .= ']';
$json .= '}';
echo $json;
?>