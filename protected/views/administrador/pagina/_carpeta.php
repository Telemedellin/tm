<p class="pull-right">
    <?php echo l('Crear carpeta', bu('administrador/carpeta/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'role' => 'button'))?>
    <?php //echo l('Añadir archivo', bu('administrador/archivo/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'role' => 'button'))?>
</p>
<div id="carpetas">
<ul>
	<?php foreach($carpeta as $c): ?>
	<li data-jstree='{"icon":"glyphicon glyphicon-folder-open"}'><?php echo $c->carpeta; ?>
		<?php if($c->carpetas || $c->archivos):?>
		<ul>
			<?php if($c->carpetas):?>
			<?php foreach($c->carpetas as $carpetas):?>
			<li data-jstree='{"icon":"glyphicon glyphicon-folder-open"}'>
				<?php echo $carpetas->carpeta; ?>
				<?php if($carpetas->archivos): ?>
				<ul>
				<?php foreach($carpetas->archivos as $a):?>
					<li data-jstree='{"icon":"glyphicon glyphicon-file"}'><a href="<?php echo bu('archivos/' . $a->carpeta->ruta . '/' . $a->archivo)?>"><?php echo $a->nombre ?></a></li>
				<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
			<?php endif;?>
			<?php if($c->archivos): ?>
			<?php foreach($c->archivos as $archivo):?>
			<li data-jstree='{"icon":"glyphicon glyphicon-file"}'><a href="<?php echo bu('archivos/' . $archivo->carpeta->ruta . '/' . $archivo->archivo)?>"><?php echo $archivo->nombre ?></a></li>
			<?php endforeach; ?>
			<?php endif; ?>
		</ul>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>
</div>
<?php
/*foreach($carpeta->archivos as $archivo)
{
	echo $archivo->archivo . '<br />';
}*/
//print_r($contenido['contenido']);
/*$this->widget('zii.widgets.grid.CGridView', array(
	'dataProvider'=> new CActiveDataProvider($contenido['contenido'], array('criteria' => array('condition'=>'item_id = 0') )),
	'enableSorting' => true,
	'columns'=>array(
        'id',
        array(
            'name'=>'url.slug',
            'value'=>'l($data->url->slug, bu("'.$contenido['pagina']->micrositio->url->slug.'". $data->url->slug) )',
            'type'=>'raw'
        ),
        'carpeta',
        'ruta',
        'estado',
        /*array(
            'class'=>'CButtonColumn',
        ),
    )
));*/
/*$this->widget('zii.widgets.CDetailView', array(
	'data'=>$contenido['contenido'],
	'attributes'=>array(
		'id',
		array(
			'name' => 'url.slug', 
			'type' => 'raw', 
			'value' => l($contenido['contenido']->url->slug, bu($contenido['pagina']->micrositio->url->slug . $contenido['contenido']->url->slug), array('target' => '_blank')),
		),
		'carpeta',
		'ruta',
		array(
			'name' => 'estado',
			'value' => ($contenido['contenido']->estado==1)?'Si':'No',
		)
	),
)); */?>