	<?php echo $form->hiddenField($contenido, 'id'); ?>
	<div class="form-group">
        <?php echo $this->imageField($form, $contenido, 'imagen', 'archivoImagen', '_pagina'); ?>
	</div>
    <div class="form-group">
        <?php echo $this->imageField($form, $contenido, 'imagen_mobile', 'archivoImagenMobile', '_pagina'); ?>
    </div>
	<div class="form-group">
        <?php echo $this->imageField($form, $contenido, 'miniatura', 'archivoMiniatura', '_pagina'); ?>
	</div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
	<?php echo $this->renderPartial('//layouts/commons/_file_upload_tmpl') ?>