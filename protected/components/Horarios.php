<?php
class Horarios{

	public static function horario_programa( $horarios )	
	{
		$dias_semana = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
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
		usort($datos, "Horarios::cmp");

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
			$html .= $dias_semana[ $dato['dia_semana'] - 1 ] . ' ';
			$html .= ' a las ' . Horarios::hora( $dato['hora_inicio'] ) . ' ';
		}
		
		return $html;
	}

	public static function horario_parser( $horarios )	
	{
		$dias_semana = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
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
		usort($datos, "Horarios::cmp");

		for($i = 0; $i < count($datos) ; $i++){

			switch ($datos[$i]['tipo_emision_id']) {
				case 1:
					$en_vivo[] = $datos[$i];
					$horario_en_vivo = $datos[$i]['hora_inicio'];
					break;
				case 2:
					$diferido[] = $datos[$i];
					$horario_en_diferido = $datos[$i]['hora_inicio'];
					break;
				case 3:
					$reemision[] = $datos[$i];
					$horario_en_reemision = $datos[$i]['hora_inicio'];
					break;
			}
		}
		if(isset($en_vivo)){
			$html .= "En vivo ";			
			foreach ($en_vivo as $ev) {							
				//Inicial
				if ($ev === reset($en_vivo)){
					$html .= $dias_semana[ $ev['dia_semana'] - 1 ] . ' ';
				}

				//Final
				if ($ev === end($en_vivo) && count($en_vivo) > 1){
					$html .= " a ";
					$html .= $dias_semana[ $ev['dia_semana'] - 1 ] . ' ';
				}
			}
			$html .= ' a las ' . Horarios::hora( $horario_en_vivo ) . ' ';			
		}

		if(isset($diferido)){
			
			foreach ($diferido as $df) {
							
				if ($df === reset($diferido)){
					$html .= $dias_semana[ $df['dia_semana'] - 1 ] . ' ';
				}				
				if(count($diferido) > 1){
					if ($df === end($diferido)){
						$html .= " a ";
						$html .= $dias_semana[ $df['dia_semana'] - 1 ] . ' ';
					}						
				}
			}
			$html .= ' a las ' . Horarios::hora( $horario_en_diferido ) . ' ';			
		}	

		if(isset($reemision)){
			$html .= "Reemisión ";
			foreach ($reemision as $rem) {
							
				if ($rem === reset($reemision)){
					$html .= $dias_semana[ $rem['dia_semana'] - 1 ] . ' ';
				}
				if(count($reemision) > 1){
					if ($rem === end($reemision)){
						$html .= " a ";
						$html .= $dias_semana[ $rem['dia_semana'] - 1 ] . ' ';
					}						
				}
			}
			$html .= ' a las ' . Horarios::hora( $horario_en_reemision ) . ' ';			
		}			
		
		return $html;
	}

	public static function fecha_especial( $fechas )	
	{
		date_default_timezone_set('America/Bogota');
		setlocale(LC_ALL, 'es_ES.UTF-8');
		$dias_semana = array('Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo');
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
				$html .= ' de ' . Horarios::hora( $dato['hora_inicio'] );
				$html .= ' a ' . Horarios::hora( $dato['hora_fin'] );
				break;
			}
			if($flag){				
				$html .= ucfirst ( strftime('%A', $f) ) .' ' . date('d', $f) . ' de ' . ucfirst ( strftime('%B', $f) );
				if($f !== $fant){
					$html .= ' de ' . Horarios::hora( $dato['hora_inicio'] );
					$html .= ' a ' . Horarios::hora( $dato['hora_fin'] );					
				}
			}
			if($dp != $dan){
				if($f !== $fant){
					$html .= " al ";
					$html .= ucfirst ( strftime('%A', $fant) ) . ' ' . date('d', $fant) . ' de ' . ucfirst ( strftime('%B', $fant) );
					$html .= ' de ' . Horarios::hora( $dato['hora_inicio'] );
					$html .= ' a ' . Horarios::hora( $dato['hora_fin'] );	
					$html .= "<br/><br/>";
					$html .= ucfirst ( strftime('%A', $f) ) . ' ' . date('d', $f) . ' de ' . ucfirst ( strftime('%B', $f) );
				}
			}	
			if($dato === end($datos)){
				if($f !== $fant){
					$html .= " al ";
					$html .= ucfirst ( strftime('%A', $f) ) . ' ' . date('d', $f) . ' de ' . ucfirst ( strftime('%B', $f) );
					$html .= ' de ' . Horarios::hora( $dato['hora_inicio'] );
					$html .= ' a ' . Horarios::hora( $dato['hora_fin'] );	
				}
				else{
					$html .= " y ";
					$html .= ' de ' . Horarios::hora( $dato['hora_inicio'] );
					$html .= ' a ' . Horarios::hora( $dato['hora_fin'] );						
				}
			}
			$previous = $dato;
		}
		//$html = substr($html, 0, -2);
		
		return $html;
	}

	public static function hora( $tiempo )
	{		
		if( strlen((string)$tiempo) == 4){
			$hora 	= substr($tiempo, 0, 2);
			$minuto = substr($tiempo, 2);			
		}
		elseif($tiempo == 0){
			$hora = 24;
		}
		else{
			$hora 	= substr($tiempo, 0, 1);
			$minuto = substr($tiempo, 1);
		}
		$ampm = 'am';		
		if( $hora > 12)
		{
			if($hora == 24){
				$hora -= 12;
				$ampm = 'am';							
			}
			else{
				$hora -= 12;
				$ampm = 'pm';
			}
		}
		$html = '';
		$html .= $hora;
		if($minuto != 00) $html .= ':' . $minuto;
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

	public static function cmp($a, $b)
	{
	    if ($a['tipo_emision_id'] == $b['tipo_emision_id']) {
	    	if($a['dia_semana'] == $b['dia_semana'])
	        	return 0;
	        else
	        	return ($a['dia_semana'] < $b['dia_semana']) ? -1 : 1;
	    }
	    return ($a['tipo_emision_id'] < $b['tipo_emision_id']) ? -1 : 1;
	}
}
?>