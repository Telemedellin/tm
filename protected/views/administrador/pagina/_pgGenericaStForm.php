	<div class="form-group">
		<?php echo $form->hiddenField($contenido, 'id'); ?>
		<?php echo $form->label($contenido,'texto', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
            <?php //echo $form->textArea($contenido, 'texto'); ?>
        <?php $this->widget('ext.editMe.widgets.ExtEditMe', array(
            'model'=>$contenido,
            'attribute'=>'texto',
            'toolbar' => array(
                            array(
                                'Bold', 'Italic', 'Underline', 'Strike', 'Subscript', 'Superscript', '-', 'RemoveFormat',
                            ),
                             array(
                                'TextColor', 'BGColor',
                            ),
                            array(
                                'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv', '-', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock', '-', 'BidiLtr', 'BidiRtl',
                            ),
                            array(
                                'Link', 'Unlink', 'Anchor',
                            ),
                            '/',
                            array(
                                'Source', '-', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo', 
                            ),
                            array(
                                'Find', 'Replace', '-', 'SelectAll', '-', 'Scayt'
                            ),
                            array(
                                /*'Image', */'Table', 'HorizontalRule', 'SpecialChar', 'PageBreak', 'Iframe'
                            ),
                            
                        ),
            //'optionName'=>'optionValue',
        ));?>
		</div>
        <?php echo $form->error($contenido,'texto'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($contenido,'imagen', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
            <?php echo $form->hiddenField($contenido, 'imagen', array('id' => 'archivoImagenPaH') ); ?>
        <div class="controls">
            <div id="imagen_pagina">
                <!-- Mensaje cuando el Javascript se encuentra deshabilitado -->
                <noscript>Debes tener habilitado Javascript en tu navegador</noscript>
                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <div class="row fileupload-buttonbar">
                    <div class="span8">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-default fileinput-button">
                            <span>Añadir archivo</span>
                            <i class="icon-plus icon-white"></i>
                            <?php //echo $form->fileField($model, 'imagen', array('id' => 'archivoImagenPa', 'name' => 'archivoImagen[]')); ?>
                            <input id="archivoImagenPa" type="file" name="archivoImagenPa[]">
                        </span>              
                        <span class="fileupload-loading"></span>
                    </div>
                    <!-- The global progress information -->
                    <div class="span5 fileupload-progress fade">
                        <!-- The global progress bar -->
                        <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <div class="bar" style="width:0%;"></div>
                        </div>
                        <!-- The extended global progress information -->
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped">
                	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
                </table>
            </div>
        </div>
        </div>
		<?php echo $form->error($contenido,'imagen'); ?>
	</div>
	<div class="form-group">
		<?php echo $form->label($contenido,'miniatura', array('class' => 'col-sm-2 control-label')); ?>
		<div class="col-sm-10">
            <?php echo $form->hiddenField($contenido, 'miniatura', array('id' => 'archivoMiniaturaPaH') ); ?>
        <div class="controls">
            <div id="miniatura_pagina">
                <!-- Mensaje cuando el Javascript se encuentra deshabilitado -->
                <noscript>Debes tener habilitado Javascript en tu navegador</noscript>
                <!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
                <div class="row fileupload-buttonbar">
                    <div class="span8">
                        <!-- The fileinput-button span is used to style the file input field as button -->
                        <span class="btn btn-default fileinput-button">
                            <span>Añadir archivo</span>
                            <i class="icon-plus icon-white"></i>
                            <?php //echo $form->fileField($model, 'imagen', array('id' => 'archivoImagenPa', 'name' => 'archivoImagen[]')); ?>
                            <input id="archivoMiniaturaPa" type="file" name="archivoMiniaturaPa[]">
                        </span>              
                        <span class="fileupload-loading"></span>
                    </div>
                    <!-- The global progress information -->
                    <div class="span5 fileupload-progress fade">
                        <!-- The global progress bar -->
                        <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">
                            <div class="bar" style="width:0%;"></div>
                        </div>
                        <!-- The extended global progress information -->
                        <div class="progress-extended">&nbsp;</div>
                    </div>
                </div>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped">
                	<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
                </table>
            </div>
        </div>
        </div>
		<?php echo $form->error($contenido,'miniatura'); ?>
	</div>
	<input type="hidden" value="<?php echo Yii::app()->request->baseUrl ?>" id="PUBLIC_PATH"/>
	<script id="template-upload" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
	    <tr class="template-upload fade">
	        <td>
	            <span class="preview"></span>
	        </td>
	        <td>
	            <p class="name">{%=file.name%}</p>
	            {% if (file.error) { %}
	                <div><span class="label label-important">Error</span> {%=file.error%}</div>
	            {% } %}
	        </td>
	        <td>
	            <p class="size">{%=o.formatFileSize(file.size)%}</p>
	            {% if (!o.files.error) { %}
	                <div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100" aria-valuenow="0"><div class="bar" style="width:0%;"></div></div>
	            {% } %}
	        </td>
	        <td>
	            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
	                <button class="btn btn-success start">
	                    <i class="icon-upload icon-white"></i>
	                    <span>Cargar</span>
	                </button>
	            {% } %}
	            {% if (!i) { %}
	                <button class="btn btn-warning cancel">
	                    <i class="icon-ban-circle icon-white"></i>
	                    <span>Cancelar</span>
	                </button>
	            {% } %}
	        </td>
	    </tr>
	{% } %}
	</script>
	<!-- The template to display files available for download -->
	<script id="template-download" type="text/x-tmpl">
	{% for (var i=0, file; file=o.files[i]; i++) { %}
	    <tr class="template-download fade">
	        <td>
	            <span class="preview">
	                {% if (file.thumbnail_url) { %}
	                    <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="gallery" download="{%=file.name%}"><img src="{%=file.thumbnail_url%}"></a>
	                {% } %}
	            </span>
	        </td>
	        <td>
	            <p class="name">
	                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
	            </p>
	            {% if (file.error) { %}
	                <div><span class="label label-important">Error</span> {%=file.error%}</div>
	            {% } %}
	        </td>
	        <td>
	            <span class="size">{%=o.formatFileSize(file.size)%}</span>
	        </td>
	        <td>
	            <button class="btn btn-danger delete" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
	                <i class="icon-trash icon-white"></i>
	                <span>Borrar</span>
	            </button>
	        </td>
	    </tr>
	{% } %}
	</script>