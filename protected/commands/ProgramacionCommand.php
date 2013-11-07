<?php
class ProgramacionCommand extends CConsoleCommand {
    public function run() 
    {
		$horarios = Horario::model()->with('pgPrograma')->findAll( 
			array('order' => 'dia_semana ASC, hora_inicio ASC', 'condition' => 'pgPrograma.estado = 2') 
		);
		
		foreach($horarios as $horario)
		{
			$pagina = Pagina::model()->findByPk($horario->pgPrograma->pagina_id);
			$micrositio_id = $pagina->micrositio_id;
			$tipo_emision_id = $horario->tipo_emision_id;
			$dia_semana = $horario->dia_semana;
			$hora_inicio = $horario->hora_inicio;
			$hora_fin = $horario->hora_fin;
			$estado = 1;

			date_default_timezone_set('America/Bogota');
			setlocale(LC_ALL, 'es_ES.UTF-8');

			$sts = mktime(0, 0, 0, date('m'), date('d'), date('Y'));
			$tts = mktime(0, 0, 0, date('m'), date('d'), date('Y'));

			// set current date
			// parse about any English textual datetime description into a Unix timestamp
			$ts 		= $sts;
			// calculate the number of days since Monday
			$dow 		= date('w', $ts);
			$offset 	= $dow - 1;
			if ($offset < 0) $offset = 6;
			// calculate timestamp for the Monday
			$ts 		= $ts - $offset * 86400;
			$semana 	= array();

			// loop from Monday till Sunday
			for ($i = 0; $i < 7; $i++, $ts += 86400){
			    $semana[] = $ts;
			}

			$hora_inicio = $semana[$dia_semana - 1] + (Horarios::hora_a_timestamp($hora_inicio));
			$hora_fin = $semana[$dia_semana - 1] + (Horarios::hora_a_timestamp($hora_fin));
			$p = new Programacion;
			if( !$p->exists(array('condition' => 'hora_inicio='.$hora_inicio.' AND hora_fin='.$hora_fin.' AND estado=1')) )
			{
				$p->micrositio_id = $micrositio_id;
				$p->hora_inicio = $hora_inicio;
				$p->hora_fin = $hora_fin;
				$p->tipo_emision_id = $tipo_emision_id;
				$p->estado = $estado;
				$p->save();
				if($p) echo '+ Guardado ' . $pagina->nombre . ' ' . $hora_inicio . '<br />';
			}else
			{
				echo '- Existía ' . $pagina->nombre . '<br />';
			}
			
		}
		return 0;
	}
}
?>