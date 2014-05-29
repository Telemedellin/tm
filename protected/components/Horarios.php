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
		//$dias_semana = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
		$datos = array();
		$html = '';
		foreach( $horarios as $horario ):
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

		$te = 0;
		foreach( $datos as $dato )
		{
			if( $dato['tipo_emision_id'] != $te )
			{
				if( $dato['tipo_emision_id'] == 3 )
					$html .= $dato['tipo_emision'] . ' ';
				$te = $dato['tipo_emision_id'];
			}
			$html .= Horarios::getDiaSemana($dato['dia_semana']) . ' ';
			$html .= ' a las ' . Horarios::hora( $dato['hora_inicio'] ) . ' ';
		}
		$html = ucfirst(strtolower($html));
		
		return $html;
	}

	public static function horario_parser( $horarios )	
	{
		if( is_null($horarios) ) return false;
		//$dias_semana = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
		$datos = array();
		$html = '';
		foreach( $horarios as $horario ):
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
		if(isset($en_vivo)){
			$html .= "En vivo ";			
			$html .= Horarios::html_emision($en_vivo);
		}

		if(isset($diferido)){
			$html .= Horarios::html_emision($diferido);
		}	
		
		if(isset($reemision)){
			$html .= "Reemisión ";
			$html .= Horarios::html_emision($reemision);
		}
		$html = substr($html, 0, -2) . '.';
		$html = ucfirst( strtolower($html) );
		return $html;
	}

	public static function html_emision($emision)
	{
		$subitem = null;
		$html = '';
		//Ordeno por hora de inicio
		usort($emision, "Horarios::ob_hora_inicio");
		//Agrupo por horas diferentes
		$array_final = array();
		foreach ($emision as $e) {
			$hora = $e['hora_inicio'];
			$array_final[$hora][] = $e;
		}

		foreach($array_final as $item){
			
			foreach ($item as $subitem) {
							
				if ($subitem === reset($item)){
					$html .= Horarios::getDiaSemana($subitem['dia_semana']) . ' ';
				}

				if ($subitem !== reset($item) && count($item) == 2){
					if($subitem === end($item))
							$html .= ' y ' . Horarios::getDiaSemana($subitem['dia_semana']) . ' ';
				}
				if($subitem !== reset($item) && count($item) > 2){
					$prev = prev($item);
					if($subitem['dia_semana'] === $prev['dia_semana']+1 )
						$html .= ', ' . Horarios::getDiaSemana($subitem['dia_semana']) . ' ';
					else
						if($subitem === end($item))
							$html .= ' a ' . Horarios::getDiaSemana($subitem['dia_semana']) . ' ';					
				}
			}

			$html .= ' a la';
			if($subitem['hora_inicio'] >= 1300 && $subitem['hora_inicio'] < 1400)
				$html .= ' ';
			else
				$html .= 's ';
			$html .= '<time>' . Horarios::hora( $subitem['hora_inicio'] ) . '</time>';

			if(next($array_final) !== end($array_final) && next($array_final) !== null)
				$html .=  ' y ';
			elseif($item !== end($array_final) && count($array_final) > 0)
				$html .=  ', ';
		}
		$html = substr($html, 0, -3) . ', ';
		return $html;
	}

	public static function fecha_especial( $fechas )	
	{
		date_default_timezone_set('America/Bogota');
		setlocale(LC_ALL, 'es_ES.UTF-8');
		//$dias_semana = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
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