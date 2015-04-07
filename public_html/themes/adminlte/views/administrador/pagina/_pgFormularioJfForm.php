	<div class="form-group">
		<?php echo $form->hiddenField($contenido, 'id'); ?>
		<?php echo $form->label($contenido,'formulario_id'); ?>
		<?php echo $form->textField($contenido, 'formulario_id', array('class' => 'form-control')); ?>
        <?php echo $form->error($contenido,'formulario_id'); ?>
	</div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>