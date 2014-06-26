	<?php echo $form->hiddenField($contenido, 'id'); ?>
    <div class="form-group">
        <?php echo $form->label($contenido,'ver_fechas', array('class' => 'col-sm-2 control-label')); ?>
        <div class="col-sm-3">
            <?php echo $form->dropDownList($contenido, 'ver_fechas', array('0' => 'No', '1' => 'Sí' ), array('class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($contenido,'ver_fechas'); ?>
    </div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>