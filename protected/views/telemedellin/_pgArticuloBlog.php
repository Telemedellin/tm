<?php
$this->pageDesc = ($contenido['pagina']->meta_descripcion != '')? $contenido['pagina']->meta_descripcion : $contenido['contenido']->entradilla;
if( !empty($contenido['contenido']->imagen) && !is_null($contenido['contenido']->imagen) )
{
	$bg = bu('/images/' . $contenido['contenido']->imagen);
	cs()->registerCss('background', 'body{background-image: url("' . $bg . '");}');	
	$this->pageImg = $bg;
}
echo $contenido['contenido']->texto;
?>
<?php if( $contenido['contenido']->comentarios ): ?>
<h3>Comentarios</h3>
<div class="fb-comments" data-href="<?php echo $this->createAbsoluteUrl($contenido['pagina']->url->slug)  ?>" data-numposts="5" data-colorscheme="dark" <?php if($this->theme != 'pc') echo 'data-mobile="true"' ?>></div>
<?php endif; ?>