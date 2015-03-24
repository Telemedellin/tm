<?php 
$r = Region::model()->findAll(array('order'=>'nombre ASC'));
$regiones = array();
foreach($r as $region)
{
	$regiones[] = $region->getAttributes();
}
$c = Ciudad::model()->findAll(array('order'=>'nombre ASC'));
$ciudades = array();
foreach($c as $ciudad)
{
	$ciudades[] = $ciudad->getAttributes();
}

cs()->registerScript( 
	'correo', 
	'
	$(".alert").alert();
	var regiones 		= '.json_encode($regiones).',
		ciudades 		= '.json_encode($ciudades).', 
		paises_select = $("#RegistroForm_pais_id"),
		regiones_select = $("#RegistroForm_region_id"),
		ciudades_select = $("#RegistroForm_ciudad_id"), 
		barrios_select  = $("#RegistroForm_barrio_id");
	
	paises_select.on("change", cargar_regiones);
	regiones_select.on("change", cargar_ciudades);
	ciudades_select.on("change", cargar_barrios);

	function cargar_regiones(event)
	{
		var ps = $(this).val();
		regiones_select.attr("disabled", false).html("<option value>Selecciona una región</option>");
		ciudades_select.attr("disabled", false).html("<option value>Selecciona una ciudad</option>");
		$(regiones).each(function (i) {
			if(regiones[i].pais_id == ps)
	        	regiones_select.append("<option value=\""+regiones[i].id+"\">"+regiones[i].nombre+"</option>");
	    });
	}
	function cargar_ciudades(event)
	{
		var rs = $(this).val();
		ciudades_select.attr("disabled", false).html("<option value>Selecciona una ciudad</option>");
		$(ciudades).each(function (i) {
			if(ciudades[i].region_id == rs)
	        	ciudades_select.append("<option value=\""+ciudades[i].id+"\">"+ciudades[i].nombre.charAt(0).toUpperCase() + ciudades[i].nombre.substring(1)+"</option>");
	    });
	}
	function cargar_barrios(event)
	{
		var cs = $(this).val();
		if(cs == 4080)
			barrios_select.attr("disabled", false);
		else
			barrios_select.attr("disabled", true);
	}
	'
);
?>
<?php foreach(Yii::app()->user->getFlashes() as $key => $message): ?>
	<div class="alert alert-block alert-<?php echo $key ?>"><?php echo $message ?></div>
<?php endforeach ?>
<?php
$form = $this->beginWidget('CActiveForm', array(
    'id'=>'correo',
    'action' => '#correo', 
    'enableAjaxValidation'=>true,
    'enableClientValidation'=>true,
    'errorMessageCssClass' => 'alert alert-error', 
    'htmlOptions' => array(
    	'style' => 'display:none;',
    	'class' => 'form-horizontal',
    ),
)); ?>
<p>Todos los campos marcados con este símbolo, son obligatorios: <img src="<?php echo bu('images/static/iconos/form-required.png');?>" alt="Símbolo obligatorio" /></p>
<fieldset>
	<legend>Información para inicio de sesión</legend>
	<div class="control-group">
		<?php echo $form->label( $model, 'correo', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('correo'))?'required':''?>">
			<?php echo $form->emailField($model, 'correo'); ?>
			<?php echo $form->error($model, 'correo'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'contrasena', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('contrasena'))?'required':''?>">
			<?php echo $form->passwordField($model, 'contrasena'); ?>
			<?php echo $form->error($model, 'contrasena'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'repetir_contrasena', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('repetir_contrasena'))?'required':''?>">
			<?php echo $form->passwordField($model, 'repetir_contrasena'); ?>
			<?php echo $form->error($model, 'repetir_contrasena'); ?>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Datos personales</legend>
	<div class="control-group">
		<?php echo CHtml::label('Nombre completo', 'nombres', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('nombres'))?'required':''?>">
			<?php echo $form->textField($model, 'nombres', array('placeholder' => 'Nombres')); ?> <?php echo $form->textField($model, 'apellidos', array('placeholder' => 'Apellidos') ); ?>
			<?php echo $form->error($model, 'nombres'); ?> <?php echo $form->error($model, 'apellidos'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'sexo', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('sexo'))?'required':''?>">
			<?php echo $form->radioButtonList(
					$model, 
					'sexo', 
					array(
						'M' => 'Masculino', 
						'F' => 'Femenino'
					), 
					array(
						'separator' => '',
						'labelOptions' => array('style' => 'display: inline;')
					) 
				); 
			?>
			<?php echo $form->error($model, 'sexo'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'tipo_documento', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('tipo_documento'))?'required':''?>">
			<?php echo $form->dropDownList( 
					$model, 
					'tipo_documento', 
					CHtml::listData(
						Meta::model()->findAllByAttributes( array('parent_id' => 1) ), 
						'id', 
						'nombre'
					),
					array('prompt'=>'Seleccione el tipo de documento')
				); 
			?>
			<?php echo $form->error($model, 'tipo_documento'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'documento', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('documento'))?'required':''?>">
			<?php echo $form->textField($model, 'documento', array('title' => $model->getTooltip('documento'))); ?>
			<?php echo $form->error($model, 'documento'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'nacimiento', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('nacimiento'))?'required':''?>">
			<?php echo $form->dropDownList( 
					$model, 
					'mes', 
					$model->getMeses(), 
					array('prompt'=>'Mes')
				); 
			?> 
			<?php echo $form->dropDownList( 
					$model, 
					'dia', 
					$model->getDias(),
					array('prompt'=>'Día')
				); 
			?> 
			<?php echo $form->dropDownList( 
					$model, 
					'anio', 
					$model->getAnios(),
					array('prompt'=>'Año')
				); 
			?> 
			<?php echo $form->error($model, 'mes'); ?>
			<?php echo $form->error($model, 'dia'); ?>
			<?php echo $form->error($model, 'anio'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'nivel_educacion_id', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('nivel_educacion_id'))?'required':''?>">
			<?php echo $form->dropDownList( 
					$model, 
					'nivel_educacion_id', 
					CHtml::listData(
						Meta::model()->findAllByAttributes( array('parent_id' => 2) ), 
						'id', 
						'nombre'
					), 
					array('prompt'=>'Seleccione el nivel de educación')
				); 
			?> 
			<?php echo $form->error($model, 'nivel_educacion_id'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'ocupacion_id', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('ocupacion_id'))?'required':''?>">
			<?php echo $form->dropDownList( 
					$model, 
					'ocupacion_id', 
					CHtml::listData(
						Meta::model()->findAllByAttributes( array('parent_id' => 3) ), 
						'id', 
						'nombre'
					), 
					array('prompt'=>'Seleccione una ocupación')
				); 
			?> 
			<?php echo $form->error($model, 'ocupacion_id'); ?>
		</div>
	</div>
</fieldset>
<fieldset>
	<legend>Información de contacto</legend>
	<div class="control-group">
		<?php echo $form->label( $model, 'telefono_fijo', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('telefono_fijo'))?'required':''?>">
			<?php echo $form->textField($model, 'telefono_fijo'); ?>
			<?php echo $form->error($model, 'telefono_fijo'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'celular', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('celular'))?'required':''?>">
			<?php echo $form->textField($model, 'celular'); ?>
			<?php echo $form->error($model, 'celular'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'pais_id', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('pais_id'))?'required':''?>">
			<?php echo $form->dropDownList( 
					$model, 
					'pais_id', 
					CHtml::listData(Pais::model()->findAll(array('order'=>'nombre ASC')), 'id', 'nombre'), 
					array('prompt'=>'Selecciona un país')
				); 
			?> 
			<?php echo $form->error($model, 'pais_id'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'region_id', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('region_id'))?'required':''?>">
			<?php echo $form->dropDownList( 
					$model, 
					'region_id', 
					CHtml::listData(Region::model()->findAllByAttributes(array('pais_id' => $model->pais_id), array('order'=>'nombre ASC')), 'id', 'nombre'), 
					array(
						'prompt'=>'Selecciona una región', 
						'disabled' => ( is_null($model->pais_id) )?true:false
					)
				); 
			?> 
			<?php echo $form->error($model, 'region_id'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'ciudad_id', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('ciudad_id'))?'required':''?>">
			<?php echo $form->dropDownList( 
					$model, 
					'ciudad_id', 
					CHtml::listData(Ciudad::model()->findAllByAttributes(array('region_id' => $model->region_id), array('order'=>'nombre ASC')), 'id', 'nombre'),  
					array(
						'prompt'=>'Selecciona una ciudad', 
						'disabled' => ( is_null($model->region_id) )?true:false
					)
				); 
			?> 
			<?php echo $form->error($model, 'ciudad_id'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'barrio_id', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('barrio_id'))?'required':''?>">
			<?php echo $form->dropDownList( 
					$model, 
					'barrio_id', 
					CHtml::listData(
						Meta::model()->findAllByAttributes( array('parent_id' => 85) ), 
						'id', 
						'nombre'
					),
					array(
						'prompt' => 'Selecciona un barrio de Medellín', 
						'disabled' => ($model->ciudad_id == 835)?false:true
					)
				); 
			?> 
			<?php echo $form->error($model, 'barrio_id'); ?>
		</div>
	</div>
	<div class="control-group">
		<?php echo $form->label( $model, 'cableoperador_id', array('class' => 'control-label') ); ?>
		<div class="controls <?php echo ($model->isAttributeRequired('cableoperador_id'))?'required':''?>">
			<?php echo $form->dropDownList( 
					$model, 
					'cableoperador_id', 
					CHtml::listData(Cableoperador::model()->findAll(/*array('order'=>'nombre ASC')/**/), 'id', 'nombre'), 
					array('prompt'=>'Selecciona un cableoperador')
				); 
			?> 
			<?php echo $form->error($model, 'cableoperador_id'); ?>
		</div>
	</div>
</fieldset>

<div class="control-group">
	<?php echo $form->checkBox($model, 'terminos'); ?> 
	<?php echo l('Reconozco que he leído y acepto los términos y condiciones', bu('telemedellin/utilidades/politicas-de-tratamiento-de-datos-personales'), array('target' => '_blank')); ?>
	<?php echo $form->error($model,'terminos'); ?>
</div>

<div class="control-group">
	<?php echo $form->label($model, 'verifyCode', array('class' => 'control-label')); ?>
	<div class="controls">
		<?php echo $form->textField($model,'verifyCode'); ?>
		<?php $this->widget('CCaptcha'); ?>
		<?php echo $form->error($model,'verifyCode'); ?>
	</div>
</div>

<div class="control-group buttons">
	<div class="controls">
	<?php echo CHtml::submitButton("Registrarse"); ?>
	</div>
</div>
<?php $this->endWidget(); ?>