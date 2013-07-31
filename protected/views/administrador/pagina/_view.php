<?php
/* @var $this PaginaController */
/* @var $data Pagina */
?>

<div class="view">

	<b><?php echo CHtml::encode($data->getAttributeLabel('id')); ?>:</b>
	<?php echo CHtml::link(CHtml::encode($data->id), array('view', 'id'=>$data->id)); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('revision_id')); ?>:</b>
	<?php echo CHtml::encode($data->revision_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('usuario_id')); ?>:</b>
	<?php echo CHtml::encode($data->usuario_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('micrositio_id')); ?>:</b>
	<?php echo CHtml::encode($data->micrositio_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('tipo_pagina_id')); ?>:</b>
	<?php echo CHtml::encode($data->tipo_pagina_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('url_id')); ?>:</b>
	<?php echo CHtml::encode($data->url_id); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('nombre')); ?>:</b>
	<?php echo CHtml::encode($data->nombre); ?>
	<br />

	<?php /*
	<b><?php echo CHtml::encode($data->getAttributeLabel('creado')); ?>:</b>
	<?php echo CHtml::encode($data->creado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('modificado')); ?>:</b>
	<?php echo CHtml::encode($data->modificado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('estado')); ?>:</b>
	<?php echo CHtml::encode($data->estado); ?>
	<br />

	<b><?php echo CHtml::encode($data->getAttributeLabel('destacado')); ?>:</b>
	<?php echo CHtml::encode($data->destacado); ?>
	<br />

	*/ ?>

</div>