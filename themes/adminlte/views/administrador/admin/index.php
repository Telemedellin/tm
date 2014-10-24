<?php 
$this->pageTitle = 'Escritorio ' . Yii::app()->name; 
$bc = array();
//$bc[] = 'Escritorio';
$this->breadcrumbs = $bc;
?>
<!-- Left col -->
<section class="col-lg-7 connectedSortable">
	<?php if(Yii::app()->user->checkAccess('ver_novedades')): ?>
	<div class="box box-primary">
	<!-- Novedades -->
	<div class="box-header">
        <i class="fa fa-bullhorn"></i>
        <h3 class="box-title">Novedades en el home</h3>
        <div class="box-tools pull-right">
        <?php echo (Yii::app()->user->checkAccess('crear_novedades')) ? l( '<i class="fa fa-plus"></i>', $this->createUrl('novedades/crear'), array('class' => 'btn btn-default pull-right', 'title' => 'Agregar novedad') ):''; ?>
        </div>
    </div><!-- /.box-header -->
	<!-- START CUSTOM TABS -->
    <!-- Custom Tabs -->
    <div class="nav-tabs-custom">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#tab_1" data-toggle="tab">Imágenes</a></li>
            <li><a href="#tab_2" data-toggle="tab">Tabla</a></li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane active" id="tab_1">
                <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
	                <ol class="carousel-indicators">
	                	<?php 
	                	$n = array();
	                	foreach($novedades->search()->getData() as $novedad): 
	                	?>
	                	<li data-target="#carousel-example-generic" data-slide-to="<?php echo count($n)?>" <?php echo ($novedad === reset($novedades->search()->getData()))?'class="active"':'' ?>></li>
	                	<?php 
	                	$n[] = array(
	                			'id' => $novedad->id,
	                			'nombre' => $novedad->nombre,
	                			'imagen' => $novedad->pgArticuloBlogs->imagen,
	                			'destacado' => $novedad->destacado,
	                		);
	                	endforeach /**/
	                	?>
	                </ol>
	                <div class="carousel-inner">
	                	<?php $i=0;foreach($n as $nn): ?>
	                    <div class="item <?php echo ($nn === reset($n))?'active':'' ?>">
	                        <img src="<?php echo bu('images/'.$nn['imagen'])?>" alt="<?php echo $nn['nombre']?>">
	                        <div class="carousel-caption">
	                            <p>
	                            	<?php echo $nn['nombre']?> 
	                            	<small><?php echo ($nn['destacado'])?'<i class="fa fa-star"></i>':''?></small>
	                            </p>
                            	<p>
                            		<a href="<?php echo $this->createUrl("novedades/view", array("id"=>$nn['id']))?>">
                            		<i class="fa fa-search"></i> Ver
                            		</a>
                            		 - 
                            		<?php if(Yii::app()->user->checkAccess("editar_novedades")):?>
                            		<a href="<?php echo $this->createUrl("novedades/update", array("id"=>$nn['id'])) ?>"><i class="fa fa-pencil"></i> Editar</a>
                            		<?php endif ?>
                            	</p>
	                        </div>
	                    </div>
	                    <?php endforeach ?>
	                </div>
	                <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
	                    <span class="glyphicon glyphicon-chevron-left"></span>
	                </a>
	                <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
	                    <span class="glyphicon glyphicon-chevron-right"></span>
	                </a>
	            </div>
        	</div><!-- /.tab-pane -->
            <div class="tab-pane" id="tab_2">
                <?php $this->widget('zii.widgets.grid.CGridView', array(
					'dataProvider'=>$novedades->search(),
					'enablePagination' => false,
					'summaryText'=>'',  
				    //'rowCssClassExpression' => '($data->destacado=="1")?"alert-success":(($data->estado=="2")?"alert-primary":(($data->estado=="1")?"alert-warning":"alert-danger"))',
					'columns'=>array(
				        'nombre', 
				        array(
				            'name'=>'destacado',
				            'filter'=>array('1'=>'Si','0'=>'No'),
				            'value'=>'($data->destacado=="1")?("Si"):("No")'
				        ),
				        array(
				            'class'=>'CButtonColumn',
				            'template' => '{view} | {update}',
				            'viewButtonUrl' => 'Yii::app()->createUrl("novedades/view", array("id"=>$data->id))',
				            'buttons' => array(
				            	'view' => array(
				                    'imageUrl' => false,
				                    'label'    => '<i class="fa fa-search"></i>', 
                        			'options'  => array('title' => 'Ver detalles'),
				                ),
				                'update' => array(
				                    'url' => 'Yii::app()->createUrl("novedades/update", array("id"=>$data->id))', 
				            		'visible' => '(Yii::app()->user->checkAccess("editar_novedades"))?true:false', 
				                    'imageUrl' => false,
				                    'label'    => '<i class="fa fa-pencil"></i>', 
                        			'options'  => array('title' => 'Editar'),
				                ),
				            ),
				        ),
				    )
				)); ?>
            </div><!-- /.tab-pane -->
        </div><!-- /.tab-content -->
    </div><!-- nav-tabs-custom -->
    
	</div>
	<?php endif; ?>
	<?php if(Yii::app()->user->checkAccess('ver_concursos')): ?>
	<!-- Concursos -->
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-trophy"></i>
            <h3 class="box-title">Concursos</h3>
            <div class="box-tools pull-right">
            <?php echo (Yii::app()->user->checkAccess('crear_concursos')) ? l( '<i class="fa fa-plus"></i>', $this->createUrl('concursos/crear'), array('class' => 'btn btn-default pull-right', 'title' => 'Agregar novedad') ):''; ?>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
			'dataProvider'=>$concursos->search(),
			'enablePagination' => false,
			'summaryText'=>'',  
			'columns'=>array(
		        'nombre',
		        array(
		            'class'=>'CButtonColumn',
		            'template' => '{view} | {update}',
		            'viewButtonUrl' => 'Yii::app()->createUrl("concursos/view", array("id"=>$data->id))',
		            'buttons' => array(
		            	'view' => array(
		                    'imageUrl' => false,
		                    'label'    => '<i class="fa fa-search"></i>', 
                        	'options'  => array('title' => 'Ver detalles'),
		                ),
		                'update' => array(
		                    'url' => 'Yii::app()->createUrl("concursos/update", array("id"=>$data->id))', 
		            		'visible' => '(Yii::app()->user->checkAccess("editar_concursos"))?true:false', 
		                    'imageUrl' => false,
		                    'label'    => '<i class="fa fa-pencil"></i>', 
                        	'options'  => array('title' => 'Editar'),
		                ),
		            ),
		        ),
		    )
		)); ?>
        </div><!-- /.box-body -->
    </div><!-- /.box -->
    <?php endif; ?>
	</section><!-- /.Left col -->
	<!-- right col (We are only adding the ID to make the widgets sortable)-->
<section class="col-lg-5 connectedSortable">
	<?php if(Yii::app()->user->checkAccess('ver_programacion')): ?>
	<!-- Parrilla -->
    <div class="box box-primary">
        <div class="box-header">
            <i class="fa fa-calendar"></i>
            <h3 class="box-title">Parrilla</h3>
            <div class="box-tools pull-right">
                <?php echo (Yii::app()->user->checkAccess('crear_programacion')) ? l( '<i class="fa fa-plus"></i>', $this->createUrl('programacion/crear'), array('class' => 'btn btn-default pull-right', 'title' => 'Agregar a la parrilla') ):''; ?>
            </div>
        </div><!-- /.box-header -->
        <div class="box-body">
            <?php $this->widget('zii.widgets.grid.CGridView', array(
				'dataProvider'=>$programacion,
				'summaryText'=>'',  
				'columns'=>array(
			        'micrositio.nombre',
			         array(
			            'header' => 'Empieza',
			            'name'=>'hora_inicio',
			            'value'=>'date("H:i", $data->hora_inicio)',
			        ),
			        array(
			            'header' => 'Termina',
			            'name'=>'hora_fin',
			            'value'=>'date("H:i", $data->hora_fin)',
			        ),
			        array(
			            'class'=>'CButtonColumn',
			            'template' => '{view} | {update}',
			            'viewButtonUrl' => 'Yii::app()->createUrl("programacion/view", array("id"=>$data->id))',
			            'buttons' => array(
			            	'view' => array(
			                    'imageUrl' => false,
			                    'label'    => '<i class="fa fa-search"></i>', 
                        		'options'  => array('title' => 'Ver detalles'),
			                ),
			            	'update' => array(
			            		'url' => 'Yii::app()->createUrl("programacion/update", array("id"=>$data->id))', 
			            		'visible' => '(Yii::app()->user->checkAccess("editar_programacion"))?true:false', 
			            		'imageUrl' => false,
		                    	'label'    => '<i class="fa fa-pencil"></i>', 
                        		'options'  => array('title' => 'Editar'), 
			            	),
			            ),
			        ),
			    )
			)); ?>
        </div><!-- /.box-body -->
        <div class="box-footer clearfix no-border">
        </div>
    </div><!-- /.box -->
	<?php endif ?>
</section><!-- right col -->