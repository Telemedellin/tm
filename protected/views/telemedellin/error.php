<?php
/* @var $this TelemedellinController */

$this->breadcrumbs=array(
	'Error'
);
?>
<div id="micrositio">
	<div class="mCustomScrollBox">
	<h1>Error 404</h1>
	<p>¿No encontraste lo que buscabas?</p>
	<p>Si querés pegate una pasada por nuestros <?php echo l('programas', CHtml::normalizeUrl('programas')) ?> o nuestra <?php echo l('parrilla de programación', CHtml::normalizeUrl('programacion')) ?>.</p>
	<p>Si todavía no encontrás lo que buscas, podés preguntarnos en nuestras redes sociales:</p>
	<ul>
		<li><?php echo l('Twitter', CHtml::normalizeUrl('http://twitter.com/telemedellin')) ?></li>
		<li><?php echo l('Facebook', CHtml::normalizeUrl('http://facebook.com/telemedellintv')) ?></li>
	</ul>
	<p>O también podés <?php echo l('escribirnos', CHtml::normalizeUrl('escribenos')) ?></p>
	</div>
</div>