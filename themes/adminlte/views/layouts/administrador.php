<?php /* @var $this Controller */ ?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="language" content="es" />
	<meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
	<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
	<link href="//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/datatables/dataTables.bootstrap.css" rel="stylesheet" type="text/css" />
    <!--<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/datepicker/datepicker3.css" rel="stylesheet" type="text/css" />-->
    <!-- Daterange picker -->
    <!--<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/daterangepicker/daterangepicker-bs3.css" rel="stylesheet" type="text/css" />-->
    <!--<link href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/AdminLTE.css" rel="stylesheet" type="text/css" />-->

	<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->theme->baseUrl; ?>/assets/css/styles.admin.min.css" />
	<!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
	<link rel="shortcut icon" href="<?php echo bu('/favicon.ico')?>" />
	<title><?php echo h($this->pageTitle); ?> - Telemedellín</title>
</head>
<body class="skin-tm">
	<!-- header logo -->
	<header class="header">
        <a href="<?php echo $this->createUrl('/administrador/admin/index') ?>" class="logo">
           <span class="glyphicon glyphicon-home"></span> Telemedellín
        </a>
        <!-- Header Navbar -->
        <nav class="navbar navbar-static-top" role="navigation">
        	<?php if(!Yii::app()->user->isGuest): ?>
        	<!-- Sidebar toggle button-->
        	<a href="#" class="navbar-btn sidebar-toggle" data-toggle="offcanvas" role="button">
                <span class="sr-only">Mostrar/ocultar navegación</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </a>
            <div class="navbar-right">
                <ul class="nav navbar-nav">
                	<?php /*
                	<li class="dropdown messages-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-envelope"></i>
                            <span class="label label-success">1</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Tiene 1 mensaje nuevo</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- start message -->
                                        <a href="#">
                                            <div class="pull-left">
                                                <img src="<?php Yii::app()->theme->baseUrl.'/assets/img/static/'?>avatar5.png" class="img-circle" alt="User Image"/>
                                            </div>
                                            <h4>
                                                Equipo de desarrollo
                                                <small><i class="fa fa-clock-o"></i> Hoy</small>
                                            </h4>
                                            <p>Mejorando el sistema</p>
                                        </a>
                                    </li><!-- end message -->
                                </ul>
                            </li>
                            <li class="footer"><a href="#">Ver todos los mensajes</a></li>
                        </ul>
                    </li>
                    <!-- Notifications -->
                    <li class="dropdown notifications-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-warning"></i>
                            <span class="label label-warning">1</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Tienes 1 notificación</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li>
                                        <a href="#">
                                            <i class="ion ion-ios7-people info"></i> Mejorada la interfaz de administración
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="footer"><a href="#">Ver todas</a></li>
                        </ul>
                    </li>
                    <!-- Tasks: -->
                    <li class="dropdown tasks-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="fa fa-tasks"></i>
                            <span class="label label-danger">1</span>
                        </a>
                        <ul class="dropdown-menu">
                            <li class="header">Tienes 1 tarea</li>
                            <li>
                                <!-- inner menu: contains the actual data -->
                                <ul class="menu">
                                    <li><!-- Task item -->
                                        <a href="#">
                                            <h3>
                                                Reportar los fallos de la plataforma
                                                <small class="pull-right">0%</small>
                                            </h3>
                                            <div class="progress xs">
                                                <div class="progress-bar progress-bar-aqua" style="width: 20%" role="progressbar" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">
                                                    <span class="sr-only">0% Completado</span>
                                                </div>
                                            </div>
                                        </a>
                                    </li><!-- end task item -->
                                </ul>
                            </li>
                            <li class="footer">
                                <a href="#">Ver todas las tareas</a>
                            </li>
                        </ul>
                    </li>
                    /**/?>
                    <!-- User Account: -->
                    <li class="dropdown user user-menu">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                            <i class="glyphicon glyphicon-user"></i>
                            <span><?php echo Yii::app()->user->email; ?> <i class="caret"></i></span>
                        </a>
                        <ul class="dropdown-menu">
                            <!-- User image -->
                            <li class="user-header bg-light-blue">
                                <img src="<?php Yii::app()->theme->baseUrl.'/assets/img/static/'?>avatar5.png" class="img-circle" alt="User Image" />
                                <p>
                                    <?php echo Yii::app()->user->email; ?>
                                    <small></small>
                                </p>
                            </li>
                            <!-- Menu Body -->
                            <li class="user-body">
                                <!--<div class="col-xs-4 text-center">
                                    <a href="#">Seguidores</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Ventas</a>
                                </div>
                                <div class="col-xs-4 text-center">
                                    <a href="#">Amigos</a>
                                </div>-->
                            </li>
                            <!-- Menu Footer-->
                            <li class="user-footer">
                                <div class="pull-left">
                                    <a href="<?php echo $this->createUrl('/cruge/ui/editprofile') ?>" class="btn btn-default btn-flat">Perfil</a>
                                </div>
                                <div class="pull-right">
                                    <a href="<?php echo $this->createUrl('/administrador/admin/salir')?>" class="btn btn-default btn-flat">Salir</a>
                                </div>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
            <?php endif; ?>
        </nav>
    </header>
    <div class="wrapper row-offcanvas row-offcanvas-left">
    	<?php if(!Yii::app()->user->isGuest): ?>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="left-side sidebar-offcanvas">
        	
            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">
                <!-- Sidebar user panel -->
                <!--<div class="user-panel">
                    <div class="pull-left image">
                        <img src="<?php Yii::app()->theme->baseUrl.'/assets/img/static/'?>avatar5.png" class="img-circle" alt="User Image" />
                    </div>
                    <div class="pull-left info">
                        <p><?php //echo Yii::app()->user->email; ?></p>

                        <a href="#"><i class="fa fa-circle text-success"></i> En línea</a>
                    </div>
                </div>-->
                <!-- search form --
                <form action="#" method="get" class="sidebar-form">
                    <div class="input-group">
                        <input type="text" name="q" class="form-control" placeholder="Search..."/>
                        <span class="input-group-btn">
                            <button type='submit' name='seach' id='search-btn' class="btn btn-flat"><i class="fa fa-search"></i></button>
                        </span>
                    </div>
                </form>
                <!-- /.search form -->
                <!-- sidebar menu: -->
                <?php $this->renderPartial('//layouts/commons/_menu') ?>
            </section>
            <!-- /.sidebar -->
        </aside>
        <?php endif ?>
        <!-- Right side column. Contains the navbar and content of the page -->
        <aside class="right-side <?php echo (Yii::app()->user->isGuest)?'strech':''; ?>">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                <h1>
                    <?php echo $this->pageTitle; ?>
                    <small></small>
                </h1>
                <?php if( count($this->breadcrumbs) ): ?>
                <?php 
				$this->widget( 'zii.widgets.CBreadcrumbs', 
				  array(
				    'homeLink' => CHtml::link( '<i class="fa fa-dashboard"></i> Panel de control', $this->createUrl('/administrador/admin/index'), array('class' => 'home') ),
				    'separator'=> ' > ',
				    'links'    => $this->breadcrumbs,
				    'inactiveLinkTemplate' => '{label}',
				    'activeLinkTemplate' => '<a href="{url}">{label}</a>',
				    'htmlOptions' => array('class' => 'breadcrumb'),
				    'tagName' => 'ol'
				  )
				); 
				?>
				<?php endif ?>
                <!--<ol class="breadcrumb">
                    <li><a href="<?php echo $this->createUrl('administrador') ?>"><i class="fa fa-dashboard"></i> Panel de control</a></li>
                    <li class="active">Escritorio</li>
                </ol>-->
            </section>
            <!-- Main content -->
            <section class="content">
            	<!-- Main row -->
            	<div class="row">
            	<?php echo $content; ?>
            	</div><!-- /.row (main row) -->
            </section><!-- /.content -->
        </aside><!-- /.right-side -->
    </div><!-- ./wrapper -->
<?php 
cs()->coreScriptPosition = CClientScript::POS_END;
cs()->registerCoreScript('jquery');
?>
<?php cs()->registerScriptFile('http://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js', CClientScript::POS_END) ?>
<?php //cs()->registerScriptFile('http://code.jquery.com/ui/1.11.1/jquery-ui.min.js', CClientScript::POS_END) ?>
<?php //cs()->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/js/plugins/daterangepicker/daterangepicker.js', CClientScript::POS_END) ?>
<?php //cs()->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/js/plugins/datepicker/bootstrap-datepicker.js', CClientScript::POS_END) ?>
<?php cs()->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/js/plugins/iCheck/icheck.min.js', CClientScript::POS_END) ?>
<?php cs()->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/js/AdminLTE/app.js', CClientScript::POS_END) ?>
<?php cs()->registerScriptFile(Yii::app()->theme->baseUrl.'/assets/js/admin.libs.min.js', CClientScript::POS_END); ?>
<?php cs()->registerScriptFile(bu('/js/admin-dev.js'), CClientScript::POS_END); ?>
<?php echo Yii::app()->user->ui->displayErrorConsole(); ?>
</body>
</html>
