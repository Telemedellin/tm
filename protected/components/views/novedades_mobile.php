<?php
cs()->registerCoreScript('jquery');
$dependencia = "SELECT GREATEST(MAX(creado), MAX(modificado)) FROM pagina WHERE micrositio_id = 2 AND estado = 2";
if($this->beginCache(
    'novedades_mobile', 
    array('duration' => 21600,
          'dependency' => array(
            'class' => 'system.caching.dependencies.CDbCacheDependency',
            'sql' => $dependencia
          )
    )
  )
):
?>
<div id="novedades">
  <ul class="novedades slides-container">
    <?php 
    if($this->getNovedades()):
    foreach($this->getNovedades() as $novedad): 
      $ee = $novedad->pgArticuloBlogs->enlace;
      if( $ee == '' ){
        $enlace = array('tipo' => 'interno', 'enlace' => bu($novedad->url->slug));
      }else
      {
        if( stripos($ee, 'telemedellin.tv') )
          $enlace = array('tipo' => 'interno', 'enlace' => $ee);
        else
          $enlace = array('tipo' => 'externo', 'enlace' => $ee);
      }
      $background = ($novedad->pgArticuloBlogs->imagen_mobile != '')?$novedad->pgArticuloBlogs->imagen_mobile:$novedad->pgArticuloBlogs->imagen;
      $background = bu('/images/' . $background);
      $this->controller->pageImg = $background;
    ?>
    <li class="novedad">
      <img src="<?php echo $background ?>" alt="<?php echo str_replace('"', "'", $novedad->nombre); ?>" />
      <div class="container <?php echo ($novedad->pgArticuloBlogs->posicion==1)?'ntop':'nbottom'; ?>">
        <h2><?php echo $novedad->nombre; ?></h2>
        <?php echo $novedad->pgArticuloBlogs->entradilla; ?>
        <a href="<?php echo $enlace['enlace'] ?>" class="ver-mas" <?php if( $enlace['tipo'] == 'externo' ) echo 'rel="nofollow"'?> title="Ver más información sobre <?php echo str_replace('"', "'", lcfirst($novedad->nombre)) ?>">Ver más</a>
      </div>
    </li>
    <?php 
    endforeach;
    endif;
    ?>
  </ul>
  <nav class="slides-navigation">
    <a href="#" class="next">
      <i class="icon-chevron-right"></i>
      Siguiente
    </a>
    <a href="#" class="prev">
      <i class="icon-chevron-left"></i>
      Anterior
    </a>
  </nav>
</div>
<?php $this->endCache(); endif; ?>