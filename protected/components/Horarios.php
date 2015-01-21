<?php
class Horarios{

	public static function getDiaSemana($dia)
	{
		$dias_semana = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
		if(is_numeric($dia)){
			if($dia>0)	$dia -= 1;
			return $dias_semana[$dia];
		}else return false;
	}

	public static function horario_programa( $horarios )	
	{
		
		$datos = array();
		$html = '';
		foreach( $horarios as $horario ):
			//Obtengo los datos de cada horario de emisión y lo asigno en el array $datos
			$datos[] = array(
				'dia_semana' 		=> $horario->dia_semana,
				'tipo_emision_id'	=> $horario->tipoEmision->id,
				'tipo_emision' 		=> $horario->tipoEmision->nombre,
				'hora_inicio'		=> $horario->hora_inicio,
				'hora_fin'			=> $horario->hora_fin,
			);
		endforeach;
	
		//Agrupo los datos por tipo de emisión y día
		usort($datos, "Horarios::ob_tipo_emision_dia");

		$te = 0;
		foreach( $datos as $dato )
		{
			//Verifico si hay un cambio en el tipo de emisión
			//Por ejemplo si pasa de ser en vivo a diferido para hacer la aclaración
			if( $dato['tipo_emision_id'] != $te )
			{
				//Si es una reemisión la concateno al texto
				if( $dato['tipo_emision_id'] == 3 )
					$html .= $dato['tipo_emision'] . ' ';
				$te = $dato['tipo_emision_id'];
			}
			//Concateno el día de la semana
			$html .= Horarios::getDiaSemana($dato['dia_semana']) . ' ';
			//Concateno la hora
			$html .= ' a las ' . Horarios::hora( $dato['hora_inicio'] ) . ' ';
		}
		//Pongo todo el texto en minúsculas y dejo la primera letra de todo el texto en mayúscula
		$html = ucfirst(strtolower($html));
		
		return $html;
	}

	public static function horario_parser( $horarios )	
	{
		if( is_null($horarios) ) return false;
		
		$datos = array();
		$html = '';
		foreach( $horarios as $horario ):
			//Obtengo los datos de cada horario de emisión y lo asigno en el array $datos
			$datos[] = array(
				'dia_semana' 		=> $horario->dia_semana,
				'tipo_emision_id'	=> $horario->tipoEmision->id,
				'tipo_emision' 		=> $horario->tipoEmision->nombre,
				'hora_inicio'		=> $horario->hora_inicio,
				'hora_fin'			=> $horario->hora_fin,
			);
		endforeach;
	
		//Agrupo los datos por tipo de emisión y día
		usort($datos, "Horarios::ob_tipo_emision_dia");

		for($i = 0; $i < count($datos) ; $i++){
			//Separo los horarios según el tipo de emisión por arrays
			switch ($datos[$i]['tipo_emision_id']) {
				case 1:
					$en_vivo[] = $datos[$i];
					break;
				case 2:
					$diferido[] = $datos[$i];
					break;
				case 3:
					$reemision[] = $datos[$i];
					break;
			}
		}
		//Verifico si hay emisiones "en vivo" y genero el html antes que los demás
		if(isset($en_vivo)){
			$html .= "En vivo ";			
			$html .= Horarios::html_emision($en_vivo);
		}
		//Verifico si hay emisiones "en diferido" y genero el html después de "en vivo" y antes que la reemisión
		if(isset($diferido)){
			$html .= Horarios::html_emision($diferido);
		}	
		//Por último verifico las reemisiones y genero el html
		if(isset($reemision)){
			if( strlen($html) ) $html .= ', ';
			$html .= "Reemisión ";
			$html .= Horarios::html_emision($reemision);
		}
		 
		//Quito la coma (,) final que genera automáticamente Horarios::html_emision() y pongo el punto final
		//$html = substr($html, 0, -2) . '.';
		$html .= '.';
		//Pongo todo el texto en minúsculas y dejo la primera letra de todo el texto en mayúscula
		$html = ucfirst( strtolower($html) );
		//Retorno el html
		return $html;
	}

	public static function html_emision($emision)
	{
		$subitem = null;
		$html = '';
		$dias = '';
		//Ordeno por hora de inicio
		usort($emision, "Horarios::ob_hora_inicio");
		//Agrupo por horas
		$array_final = array();
		foreach ($emision as $e) {
			$hora = $e['hora_inicio'];
			$array_final[$hora][] = $e;
		}

		foreach($array_final as $item){

			//Este ciclo permite definir los días de la transmisión a una hora determinada
			foreach ($item as $subitem) {
							
				//Si es el primer día lo agrego limpio al html
				if ($subitem === reset($item)){
					$dias .= Horarios::getDiaSemana($subitem['dia_semana']) . ' ';
				}

				//Si es el segundo item y no hay más después, lo concateno con un "y" al inicio
				if ($subitem !== reset($item) && count($item) == 2){
					if($subitem === end($item))
							$dias .= ' y ' . Horarios::getDiaSemana($subitem['dia_semana']) . ' ';
				}
				//Si hay más de dos items
				if($subitem !== reset($item) && count($item) > 2){
					$prev = prev($item);
					//Si el item es contiguo lo concateno con una coma ", " (Por ejemplo, lunes, martes)
					if($subitem['dia_semana'] === $prev['dia_semana']+1 )
						$dias .= ', ' . Horarios::getDiaSemana($subitem['dia_semana']) . ' ';
					//Si el item no es contiguo lo separo con una "a" (Por ejemplo, lunes a viernes)
					else
						if($subitem === end($item))
							$dias .= ' a ' . Horarios::getDiaSemana($subitem['dia_semana']) . ' ';					
				}
			}

			//Si no es el primer item, y tampoco el último agrego una coma para separarlo del anterior
			if( $item !== reset($array_final) && $item !== end($array_final) )
				$html .=  ', ';
			//Si es el último ítem y no es el primero agrego un "y" para separarlo del anterior
			else if( $item === end($array_final) && $item !== reset($array_final)  )
				$html .=  ' y ';

			$html .= $dias;

			//Verifico si el patrón de los días de emisión se repite, (strpos)
			//por ejemplo lunes a viernes a las 4pm y lunes a viernes a las 8pm 
			//en este caso se obviaría el segundo quedando lunes a viernes a las 4pm y a las 8pm.
			if ($subitem !== reset($item))
			{
				$posicion_inicial = strpos($html, $dias);
				$posicion_final = strrpos($html, $dias);
				//Busco la primera y la última ocurrencia, si son diferentes es porque hay más de una
				//en cuyo caso obvio la segunda
				if( $posicion_inicial !== $posicion_final )
				{
					$html = substr_replace( $html, '', $posicion_final );
				}
				//También habría que mirar si son varios los que se repiten para poner el y o la coma (,)
			}
			$dias = ''; //Limpio el html de días

			//Después de definir los días de la transmisión se pone la hora
			$html .= ' a la';
			
			//Si es entre la 1 y las 2, queda en singular (A la 1:30 pm)
			if($subitem['hora_inicio'] >= 1300 && $subitem['hora_inicio'] < 1400)
				$html .= ' ';
			//Si no es entre la 1 y las 2, queda en plural (A las 2:30 pm)
			else
				$html .= 's ';
			//Concateno la hora de emisión formateada
			$html .= '<time>' . Horarios::hora( $subitem['hora_inicio'] ) . '</time>';

		}
		return $html;
	}

	public static function fecha_especial( $fechas )	
	{
		date_default_timezone_set('America/Bogota');
		setlocale(LC_ALL, 'es_ES.UTF-8');
		
		$datos = array();
		$html = '';
		foreach( $fechas as $fecha ):
			$datos[] = array(
				'fecha' 		=> $fecha->fecha,
				'hora_inicio'	=> $fecha->hora_inicio,
				'hora_fin'		=> $fecha->hora_fin,
			);
		endforeach;
	
		$te = 0;		
		$previous = null;
		$c = count($datos);

		foreach( $datos as $dato )
		{		
			$dant = $previous;
			
			$f = strtotime($dato['fecha']);
			$da = date('z', $f);
			
			$fant = strtotime($dant['fecha']);
			if(is_null($previous)){
				$flag = true;
				$dan = $da - 1;
			}
			else{
				$flag = false;
				$dan = date('z', $fant);	
			}
			$dp = $da-1;
			if($c == 1){
				$html .= ucfirst ( strftime('%A', $f) ) .' ' . date('d', $f) . ' de ' . ucfirst ( strftime('%B', $f) );
				$html .= ' de ' . '<time>' . Horarios::hora( $dato['hora_inicio'] ) . '</time>';
				$html .= ' a ' . '<time>' . Horarios::hora( $dato['hora_fin'] ) . '</time>';
				break;
			}
			if($flag){				
				$html .= ucfirst ( strftime('%A', $f) ) .' ' . date('d', $f) . ' de ' . ucfirst ( strftime('%B', $f) );
				if($f !== $fant){
					$html .= ' de ' . '<time>' . Horarios::hora( $dato['hora_inicio'] ) . '</time>';
					$html .= ' a ' . '<time>' . Horarios::hora( $dato['hora_fin'] ). '</time>';					
				}
			}
			if($dp != $dan){
				if($f !== $fant){
					$html .= " al ";
					$html .= ucfirst ( strftime('%A', $fant) ) . ' ' . date('d', $fant) . ' de ' . ucfirst ( strftime('%B', $fant) );
					$html .= ' de ' . '<time>' . Horarios::hora( $dato['hora_inicio'] ) . '</time>';
					$html .= ' a ' . '<time>' . Horarios::hora( $dato['hora_fin'] ) . '</time>';	
					$html .= "<br/><br/>";
					$html .= ucfirst ( strftime('%A', $f) ) . ' ' . date('d', $f) . ' de ' . ucfirst ( strftime('%B', $f) );
				}
			}	
			if($dato === end($datos)){
				if($f !== $fant){
					$html .= " al ";
					$html .= ucfirst ( strftime('%A', $f) ) . ' ' . date('d', $f) . ' de ' . ucfirst ( strftime('%B', $f) );
					$html .= ' de ' . '<time>' . Horarios::hora( $dato['hora_inicio'] ) . '</time>' ;
					$html .= ' a ' . '<time>' . Horarios::hora( $dato['hora_fin'] ) . '</time>';	
				}
				else{
					$html .= " y ";
					$html .= ' de ' . '<time>' . Horarios::hora( $dato['hora_inicio'] ) . '</time>';
					$html .= ' a ' . '<time>' . Horarios::hora( $dato['hora_fin'] ) . '</time>';						
				}
			}
			$previous = $dato;
		}
		//$html = substr($html, 0, -2);
		$html = ucfirst(strtolower($html));
		return $html;
	}

	public static function hora( $tiempo, $con_minutos = false )
	{		
		$len = strlen((string)$tiempo);
		if( $len == 4){
			$hora 	= substr($tiempo, 0, 2);
			$minuto = substr($tiempo, 2);			
		}
		elseif( $len == 3){
			$hora 	= substr($tiempo, 0, 1);
			$minuto = substr($tiempo, 1);		
		}
		elseif( $len == 2 || $len == 1){
			$hora 	= 0;
			$minuto = $tiempo;
		}
		else{
			$hora = 0;
		}
		$ampm = 'am';
		if( $hora > 12 )
		{
			$hora -= 12;
			$ampm = 'pm';
		}elseif($hora == 12)
		{
			$ampm = 'pm';
		}
		$html = '';
		$html .= $hora;
		if($minuto != 00 || $con_minutos != false) $html .= ':' . $minuto;
		$html .= ' ' . $ampm;
		return $html;
	}

	public static function hora_a_timestamp( $tiempo )
	{
		if( strlen((string)$tiempo) == 4){
			$hora 	= substr($tiempo, 0, 2);
			$minuto = substr($tiempo, 2);
		}else{
			$hora 	= substr($tiempo, 0, 1);
			$minuto = substr($tiempo, 1);
		}
		$timestamp = 0;
		$timestamp = (($hora * 60) *60);
		if($minuto != 00) $timestamp =  $timestamp + ($minuto*60);
		return $timestamp;
	}

	public static function ob_tipo_emision_dia($a, $b)
	{
	    if ($a['tipo_emision_id'] == $b['tipo_emision_id']) {
	    	if($a['dia_semana'] == $b['dia_semana'])
	        	return 0;
	        else
	        	return ($a['dia_semana'] < $b['dia_semana']) ? -1 : 1;
	    }
	    return ($a['tipo_emision_id'] < $b['tipo_emision_id']) ? -1 : 1;
	}

	public static function ob_hora_inicio($a, $b)
	{
	    if ($a['dia_semana'] == $b['dia_semana']) {
	    	if($a['hora_inicio'] == $b['hora_inicio'])
	        	return 0;
	        else
	        	return ($a['hora_inicio'] < $b['hora_inicio']) ? -1 : 1;
	    }
	    return ($a['dia_semana'] < $b['dia_semana']) ? -1 : 1;
	}
}
?>