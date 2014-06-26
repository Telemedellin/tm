<p class="pull-right">
    <?php echo l('Crear carpeta', bu('administrador/carpeta/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'role' => 'button', 'target' => '_blank'))?>
    <?php //echo l('Añadir archivo', bu('administrador/archivo/crear/' . $model->id), array('class' => 'btn btn-default btn-sm', 'role' => 'button'))?>
</p>
<?php 
/*
<div id="carpetas">
<ul>
	<?php foreach($carpeta as $c): ?>
	<li data-id='<?php echo $c->id; ?>' data-jstree='{"icon":"glyphicon glyphicon-folder-open"}'><?php echo $c->carpeta; ?>
		<?php if($c->carpetas || $c->archivos):?>
		<ul>
			<?php if($c->carpetas):?>
			<?php foreach($c->carpetas as $carpetas):?>
			<li data-id='<?php echo $carpetas->id; ?>' data-jstree='{"icon":"glyphicon glyphicon-folder-open"}'>
				<?php echo $carpetas->carpeta; ?>
				<?php if($carpetas->archivos): ?>
				<ul>
				<?php foreach($carpetas->archivos as $a):?>
					<li data-id='<?php echo $a->id; ?>' data-jstree='{"icon":"glyphicon glyphicon-file"}'><a href="<?php echo bu('archivos/' . $a->carpeta->ruta . '/' . $a->archivo)?>"><?php echo $a->nombre ?></a></li>
				<?php endforeach; ?>
				</ul>
				<?php endif; ?>
			</li>
			<?php endforeach; ?>
			<?php endif;?>
			<?php if($c->archivos): ?>
			<?php foreach($c->archivos as $archivo):?>
			<li data-id='<?php echo $archivo->id; ?>' data-jstree='{"icon":"glyphicon glyphicon-file"}'><a href="<?php echo bu('archivos/' . $archivo->carpeta->ruta . '/' . $archivo->archivo)?>"><?php echo $archivo->nombre ?></a></li>
			<?php endforeach; ?>
			<?php endif; ?>
		</ul>
		<?php endif; ?>
	</li>
	<?php endforeach; ?>
</ul>
</div>
/**/
?>
<div id="carpetas2">
	<?php
	cs()->registerScriptFile( Yii::app()->getBaseUrl() . '/857--edatm-ckfinder/ckfinder.js' );
	cs()->registerScript( 'ckfinder', 
		"		var finder = new CKFinder();

		CKFinder.addPlugin( 'myplugin', function( api ) {
			console.log('Plugin start'); 
			var orginalsendCommandPost  = api.connector.sendCommandPost;
			var ruta_base = '/tm/administrador/carpeta/';
		    console.log(orginalsendCommandPost);
		    api.connector.sendCommandPost = function() {
		      // call the original function
		      var result = orginalsendCommandPost.apply(this, arguments);
		      console.log('Plugin start'); 
		      // commandname as string: 'CreateFolder', 'MoveFiles', 'RenameFile', etc
		      console.log(arguments[0]); 
		      if(arguments[0] == 'RenameFile')
		      {
		      	$.post( ruta_base + 'renamearchivo', { name: arguments[1].fileName, new_name: arguments[1].newFileName }).done(function( data ) {
		            console.log( 'Data Loaded: ' + data );
		            if( data.error ) console.log('error');
		            else console.log('bien');
		        });
		      }
		      if(arguments[0] == 'RenameFolder')
		      {
		      	$.post( ruta_base + 'rename', { name: arguments[1].OldFolderName, new_name: arguments[1].NewFolderName }).done(function( data ) {
		            console.log( 'Data Loaded: ' + data );
		            if( data.error ) console.log('error');
		            else console.log('bien');
		        });
		      }
		      if(arguments[0] == 'CreateFolder')
		      {
		      	$.post( ruta_base + 'crear', { name: arguments[1].NewFolderName, parent_name: arguments[5].name }).done(function( data ) {
		            console.log( 'Data Loaded: ' + data );
		            if( data.error ) console.log('error');
		            else console.log('bien');
		        });
		      }
		      if(arguments[0] == 'UploadFile')
		      {
		      	console.log('Upload');
		      	/*
		      	$.post( ruta_base + 'crear', { name: arguments[1].NewFolderName, parent_name: arguments[5].name }).done(function( data ) {
		            console.log( 'Data Loaded: ' + data );
		            if( data.error ) console.log('error');
		            else console.log('bien');
		        });/**/
		      }
		      
		      // arguments as object
		      console.log(arguments);
		      console.log(JSON.stringify(arguments[1]));
		      console.log('Plugin end'); 
		      return result;
		    }
		} );
		CKFinder.customConfig = function( config )
		{
			// http://docs.cksource.com/ckfinder_2.x_api/symbols/CKFinder.config.html
			config.removePlugins = 'basket';
			
		};

		finder.extraPlugins = 'myplugin';		
		finder.basePath = './';
		finder.height = 600;
		//finder.customConfig = '". Yii::app()->getBaseUrl() . "/857--edatm-ckfinder/config.js';
		//finder.selectActionFunction = showFileInfo;
		finder.appendTo('carpetas2');"
	);	
	?>
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