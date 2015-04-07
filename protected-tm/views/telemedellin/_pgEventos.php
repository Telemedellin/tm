<?php 
$this->pageDesc = ($contenido['pagina']->meta_descripcion != '')? $contenido['pagina']->meta_descripcion : '';
$fechas = $contenido['contenido']->fechas;
setlocale(LC_ALL, 'es_ES.UTF-8');
?>
<?php if(!empty($contenido['contenido']->eventos) && $eventos = $contenido['contenido']->eventos): ?>
<div>
	<?php echo $contenido['contenido']->descripcion ?>
	<select name="fecha_programacion" id="fecha_programacion">
	<?php foreach($fechas as $fecha): ?>
		<option 
			value="<?php echo $fecha->fecha ?>" 
			<?php echo ( ($fecha->fecha - strtotime('today')) <= 43200 && ($fecha->fecha - strtotime('today')) >= -43200 )?'selected="selected"':''?>
		>
			<?php echo strftime('%d de %B de %G', $fecha->fecha) ?>
		</option>
	<?php endforeach; ?>
	</select>
	<table id="table_programacion">
		<thead>
			<tr>
				<th>Hora</th>
				<th>Evento, programa o actividad</th>
			</tr>
		</thead>
		<tbody>
		<?php foreach( $eventos as $evento ):?>
			<tr class="<?php echo $evento->fecha ?>">
				<td><?php echo date('g:i a', $evento->hora) ?></td>
				<td><?php echo str_replace('"', "'", $evento->nombre) ?></td>
			</tr>
		<?php endforeach ?>
		</tbody>
	</table>
</div>
<?php endif; ?>