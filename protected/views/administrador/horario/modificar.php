<h1>Modificar horario <?php echo Horarios::getDiaSemana($model->dia_semana) . ' ' . Horarios::hora($model->hora_inicio). ' a ' . Horarios::hora($model->hora_fin); ?></h1>

<?php echo $this->renderPartial('_form', array('model'=>$model)); ?>