	<?php echo $form->hiddenField($contenido, 'id'); ?>
    <div class="form-group">
        <?php echo $form->label($contenido,'ver_fechas'); ?>
        <div class="input-group">
            <span class="input-group-addon"><i class="fa fa-eye"></i></span>
            <?php echo $form->dropDownList($contenido, 'ver_fechas', array('0' => 'No', '1' => 'Sí' ), array('class' => 'form-control')); ?>
        </div>
        <?php echo $form->error($contenido,'ver_fechas'); ?>
    </div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>