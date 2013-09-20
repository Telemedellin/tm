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

	public static function fecha_especial( $fechas )	
	{
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
		foreach( $datos as $dato )
		{
			$html .= date('l', $dato['fecha']) . ' ' . date('d', $dato['fecha']) . ' de ' . date('F', $dato['fecha']);
			$html .= ' de ' . Horarios::hora( $dato['hora_inicio'] );
			$html .= ' a ' . Horarios::hora( $dato['hora_fin'] ) . ', ';
		}
		$html = substr($html, 0, -2);
		
		return $html;
	}

	public static function hora( $tiempo )
	{
		$hora 	= substr($tiempo, 0, 2);
		$minuto = substr($tiempo, 2);
		$ampm = 'am';
		if( $hora > 12)
		{
			$hora -= 12;
			$ampm = 'pm';
		}
		$html = '';
		$html .= $hora;
		if($minuto != 00) $html .= ':' . $minuto;
		$html .= ' ' . $ampm;
		return $html;
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