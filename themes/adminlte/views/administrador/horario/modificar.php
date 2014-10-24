<?php 
$this->pageTitle = 'Modificar horario ' . Horarios::getDiaSemana($model->dia_semana) . ' ' . Horarios::hora($model->hora_inicio);
$bc = array();
$bc['Padre'] = $this->createUrl('programas/view', array('id' => $model->pgPrograma->pagina->micrositio->id));
$bc[] = 'Editar';
$this->breadcrumbs = $bc;
?>
<div class="col-sm-12">
<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>
</div>