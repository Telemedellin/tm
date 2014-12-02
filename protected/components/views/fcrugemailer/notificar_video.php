<p>Nombre: <?php echo $datos->nombre ?></p>
<p>Correo: <?php echo $datos->email ?></p>
<?php if($datos->twitter): ?>
<p>Twitter: <a href="http://twitter.com/<?php echo $datos->twitter?>">@<?php echo $datos->twitter?></a></p>
<?php endif ?>
<p>Video: <a href="http://telemedellin.tv<?php echo bu($datos->video) ?>">http://telemedellin.tv<?php echo bu($datos->video) ?></a></p>