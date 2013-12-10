<ul>
	<?php foreach($carpeta as $c): ?>
	<li><?php echo $c->carpeta; ?>
		<?php if($c->carpetas || $c->archivos):?>
		<span class="caret"></span><ul class="collapse">
		<?php if($c->carpetas):?>
		<?php foreach($c->carpetas as $carpetas):?>
			<li>
				<?php echo $carpetas->carpeta; ?>
				<?php if($carpetas->archivos): ?>
				<span class="caret"></span><ul class="collapse">
				<?php foreach($carpetas->archivos as $a):?>
					<li><?php echo $a->nombre ?></li>
				<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</li>
		<?php endforeach; ?>
		<?php endif;?>
		<?php if($c->archivos): ?>
		<?php foreach($c->archivos as $archivo):?>
			<li><?php echo $archivo->nombre ?></li>
		<?php endforeach; ?>
		<?php endif; ?>
		</ul>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>
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