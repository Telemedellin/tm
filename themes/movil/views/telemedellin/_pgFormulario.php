<?php
Yii::app()->clientScript->registerScript('uploader', 
    '// Initialize the jQuery File Upload widget:
    $("#video").fileupload({        
        // Uncomment the following to send cross-domain cookies:
        //xhrFields: {withCredentials: true},
        url: "'.Yii::app()->request->baseUrl.'/ajax/video",
        maxNumberOfFiles: 1,
        previewMaxWidth: 200,
        previewMaxHeight: 200,
        imageCrop: true,     
        acceptFileTypes: /(\.|\/)(mov|mp?eg?4|mp4|avi|wmv|3gpp|webm)$/i,
        paramName: "archivoVideo", 
        maxFileSize: 100000000, 
        messages: {
            maxNumberOfFiles: "Solo se permite un video",
            acceptFileTypes: "No se acepta este tipo de archivo",
            maxFileSize: "El archivo es muy pesado, debe pesar menos de 100MB",
            minFileSize: "El archivo no tiene peso suficiente"
        },
    }).bind("fileuploaddone", function(e, data){
    	$.each(data.result.archivoVideo, function (index, file) {
    		if (file.url) {
                var link = $("<a>")
                    .attr("target", "_blank")
                    .prop("href", file.url);
                $(data.context.children()[index])
                    .wrap(link).append($("<span/>").text(file.name));
            } else if (file.error) {
                var error = $("<span class=\"text-danger\"/>").text(file.error);
                $(data.context.children()[index])
                    .append("<br>")
                    .append(error);
            }
        });
    	$("#archivoVideoH").attr("value", data.result.archivoVideo[0].name);
        console.log("done");
    }).bind("fileuploadadded", function (e, data) {
        $(".fileinput-button").hide();
        $(".fileupload-progress").hide();
        $(".fileupload-buttonbar").show();
        console.log("added");
    }).bind("fileuploadstarted", function (e) {
        $(".fileupload-progress").show();
    }).bind("fileuploadfailed", function (e, data) {
        $(".fileupload-buttonbar").hide();
        $(".fileupload-progress").hide();
        $(".fileinput-button").show();
    }).bind("fileuploaddestroyed", function (e, data) {
        $("#archivoVideoH").attr("value", "");
        $(".fileupload-buttonbar").hide();
        $(".fileupload-progress").hide();
        $(".fileinput-button").show();
        console.log("destroyed");
    });
    // Enable iframe cross-domain access via redirect option:
    $("#video").fileupload(
        "option",
        "redirect",
        window.location.href.replace(
            /\/[^\/]*$/,
            "/cors/result.html?%s"
        )
    );
    $(".fileupload-buttonbar").hide();

    // Load existing files:
    //$("#video").addClass("fileupload-processing");', 
    CClientScript::POS_READY);
?>
<?php 
$model = new Saludo; 
//print_r($_POST);
if(isset($_POST['Saludo']))
{
	$model->attributes = $_POST['Saludo'];
	$model->video = 'uploads/' . date('Y') . '/' . date('m') . '/' . date('d') . '/' . $_POST['Saludo']['video'];
	if( $model->save() )
	{
		$saved = true;
        Yii::app()->crugemailer->notificar_video($model);
	}
}
?>
<?php echo $contenido['contenido']->texto; ?>
<?php if(isset($saved) && $saved):?>
<p style="text-align: center;"><strong>Hemos recibido tu video correctamente</strong></p>
<p style="text-align: center;">Muchas gracias por participar</p>
<p style="text-align: center;">¡Felices Fiestas!</p>
<?php else:?>
<?php $form = $this->beginWidget('CActiveForm', array(
	'id'=>'custom-form',
	'enableAjaxValidation'=>false,
	//'action' => $contenido['contenido']->accion, 
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data', 
        'role' => 'form',
        'class' => 'form-horizontal'
    )
)); ?>
<div id="video">
    <h3 style="border-bottom: thin solid #FFF;">Sube tu video</h3>
    <div class="form-group">
    	<?php echo $form->label($model,'nombre', array('class' => 'col-sm-2 control-label')); ?>
    	<div class="col-sm-10">
    		<?php echo $form->textField($model, 'nombre', array('size'=>60, 'class' => 'form-control', 'maxlength'=>100, 'required' => true)); ?>
    	</div>
    	<?php echo $form->error($model,'nombre'); ?>
    </div>
    <div class="form-group">
    	<?php echo $form->label($model,'email', array('class' => 'col-sm-2 control-label')); ?>
    	<div class="col-sm-10">
    		<?php echo $form->emailField($model, 'email', array('size'=>60, 'class' => 'form-control', 'maxlength'=>100, 'required' => true)); ?>
    	</div>
    	<?php echo $form->error($model,'email'); ?>
    </div>
    <div class="form-group">
    	<?php echo $form->label($model,'twitter', array('class' => 'col-sm-2 control-label')); ?>
    	<div class="col-sm-10">
    		<?php echo $form->textField($model, 'twitter', array('size'=>60, 'class' => 'form-control', 'maxlength'=>15)); ?>
    	</div>
    	<?php echo $form->error($model,'twitter'); ?>
    </div>
    <div class="form-group">
    	<?php echo $form->hiddenField($model, 'video', array('id' => 'archivoVideoH', 'required' => true) ); ?>
    	<div class="col-sm-10">
			<!-- Mensaje cuando el Javascript se encuentra deshabilitado -->
			<noscript>Debes tener habilitado Javascript en tu navegador</noscript>
            <!-- The fileinput-button span is used to style the file input field as button -->
            <span class="btn btn-primary fileinput-button">
                <span>SELECCIONAR VIDEO</span>
                <input id="archivoVideo" type="file" name="archivoVideo[]">
            </span>
			<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->
			<div class="row fileupload-buttonbar">
                <h4 style="margin-top: 0; padding-left:10px;"><strong>Información del video</strong></h4>
                <!-- The table listing the files available for upload/download -->
                <table role="presentation" class="table table-striped">
                    <tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>
                </table>
				
			</div>
    	</div>
    </div>
</div>
<?php $this->endWidget(); ?>
<script id="template-upload" type="text/x-tmpl">
{% for (var i=0, file; file=o.files[i]; i++) { %}
    <tr class="template-upload fade">
        <td>
            <span class="preview"></span>
            <p class="name">{%=file.name%}</p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
            <p class="size">{%=o.formatFileSize(file.size)%}</p>
            {% if (!o.files.error) { %}
                <!-- The global progress information -->
                <div class="col-sm-8 fileupload-progress fade">
                <!-- The global progress bar -->
                    <div class="progress">
                        <div class="progress-bar progress-bar-success progress-bar-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                    <!-- The extended global progress information -->
                    <div class="progress-extended">&nbsp;</div>
                </div>
            {% } %}
            <p>
            {% if (!i) { %}
                <button class="btn btn-default cancel col-xs-4">
                    <span>CANCELAR</span>
                </button>
            {% } %}
            {% if (!o.files.error && !i && !o.options.autoUpload) { %}
                <button class="btn btn-primary start  col-xs-7 col-xs-offset-1">
                    <span>CARGAR VIDEO</span>
                </button>
            {% } %}
            </p>
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
            <p class="name">
                <a href="{%=file.url%}" title="{%=file.name%}" data-gallery="{%=file.thumbnail_url&&'gallery'%}" download="{%=file.name%}">{%=file.name%}</a>
            </p>
            <p class="size">{%=o.formatFileSize(file.size)%}</p>
            {% if (file.error) { %}
                <div><span class="label label-important">Error</span> {%=file.error%}</div>
            {% } %}
            {% if (!file.error) { %}
                <div>Video cargado correctamente</div>
            {% } %}
            <button class="btn btn-default delete col-xs-4" data-type="{%=file.delete_type%}" data-url="{%=file.delete_url%}"{% if (file.delete_with_credentials) { %} data-xhr-fields='{"withCredentials":true}'{% } %}>
                <i class="icon-trash icon-white"></i>
                <span>CANCELAR</span>
            </button>
            <?php echo CHtml::submitButton('ENVIAR SALUDO', array('id'=> 'btn-submit', 'class' => 'btn btn-primary  col-xs-7 col-xs-offset-1')); ?>
        </td>
    </tr>
{% } %}
</script>
<?php endif; ?>