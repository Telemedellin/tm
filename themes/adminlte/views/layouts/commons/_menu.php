<ul class="sidebar-menu">
	<li class="active">
        <a href="<?php echo $this->createUrl('/administrador/admin') ?>">
            <i class="fa fa-dashboard"></i> <span>Panel de control</span>
        </a>
    </li>
    <?php if(Yii::app()->user->checkAccess('ver_novedades')): ?>
    <li>
        <a href="<?php echo $this->createUrl('/administrador/novedades') ?>">
            <i class="fa fa-bullhorn"></i> <span>Novedades</span>
        </a>
    </li>
    <?php endif ?>
    <?php if(Yii::app()->user->checkAccess('ver_banners')): ?>
    <li>
        <a href="<?php echo $this->createUrl('/administrador/novedades/banners') ?>">
            <i class="fa fa-picture-o"></i> <span>Banners</span>
        </a>
    </li>
    <?php endif ?>
    <?php if(Yii::app()->user->checkAccess('ver_guinos')): ?>
    <li>
        <a href="<?php echo $this->createUrl('/administrador/guino') ?>">
            <i class="fa fa-bell"></i> <span>Guiños</span>
        </a>
    </li>
    <?php endif ?>
    <?php if(Yii::app()->user->checkAccess('ver_concursos')): ?>
    <li>
        <a href="<?php echo $this->createUrl('/administrador/concursos') ?>">
            <i class="fa fa-trophy"></i> <span>Concursos</span>
        </a>
    </li>
    <?php endif ?>
    <?php if(Yii::app()->user->checkAccess('ver_programacion')): ?>
    <li>
        <a href="<?php echo $this->createUrl('/administrador/programacion') ?>">
            <i class="fa fa-calendar"></i> <span>Parrilla</span>
        </a>
    </li>
    <?php endif ?>
    <?php if(Yii::app()->user->checkAccess('ver_especiales')): ?>
    <li>
        <a href="<?php echo $this->createUrl('/administrador/especiales') ?>">
            <i class="fa fa-star"></i> <span>Especiales</span>
        </a>
    </li>
    <?php endif ?>
    <?php if(Yii::app()->user->checkAccess('ver_programas')): ?>
    <li>
        <a href="<?php echo $this->createUrl('/administrador/programas') ?>">
            <i class="fa fa-video-camera"></i> <span>Programas</span>
        </a>
    </li>
    <?php endif ?>
    <?php if(Yii::app()->user->checkAccess('ver_documentales')): ?>
    <li>
        <a href="<?php echo $this->createUrl('/administrador/documentales') ?>">
            <i class="fa fa-film"></i> <span>Documentales</span>
        </a>
    </li>
    <?php endif ?>
    <?php if(Yii::app()->user->checkAccess('ver_telemedellin')): ?>
    <li>
        <a href="<?php echo $this->createUrl('/administrador/telemedellin') ?>">
            <i class="fa fa-suitcase"></i> <span>Telemedellín</span>
        </a>
    </li>
    <?php endif ?>
    <?php if(Yii::app()->user->checkAccess('ver_trivia')): ?>
    <li>
    	<a href="<?php echo $this->createUrl('/trivia/administracion') ?>">
            <i class="fa fa-star-o"></i> <span>Trivia</span>
        </a>
    </li>
    <?php endif ?>
    <?php if( Yii::app()->user->isSuperAdmin ): ?>
    <li>
        <a href="<?php echo Yii::app()->user->ui->userManagementAdminUrl ?>">
            <i class="fa fa-users"></i> <span>Usuarios</span>
        </a>
    </li>
    <?php endif ?>
</ul>