<?php
cs()->registerCoreScript('jquery');
$dependencia = "SELECT GREATEST(MAX(creado), MAX(modificado)) FROM pagina WHERE micrositio_id = 2 AND estado = 2";
if($this->beginCache(
    'novedades_pc', 
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
    $paginador = ''; 
    $i         = 0;
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
  ?>
    <li class="novedad">
      <img src="<?php echo bu('/images/' . $novedad->pgArticuloBlogs->imagen); ?>" alt="<?php echo str_replace('"', "'", $novedad->nombre); ?>" />
      <div class="dots"></div>
      <div class="container <?php echo ($novedad->pgArticuloBlogs->posicion==1)?'ntop':'nbottom'; ?>">
        <h2><?php echo $novedad->nombre; ?></h2>
        <?php echo $novedad->pgArticuloBlogs->entradilla; ?>
        <a href="<?php echo $enlace['enlace'] ?>" class="ver-mas" <?php if( $enlace['tipo'] == 'externo' ) echo 'rel="nofollow"'?> title="Ver más información sobre <?php echo str_replace('"', "'", lcfirst($novedad->nombre)) ?>">+ Ver más</a>
      </div>
    </li>
    <?php 
    $paginador .= '<a class="'.$i.'" href="#'.($i+1).'" title="Ver la novedad ' . str_replace('"', "'", lcfirst($novedad->nombre)) . '"><img src="'. bu('/images/' . $novedad->pgArticuloBlogs->miniatura) . '" alt="'. str_replace('"', "'", $novedad->nombre).'" /></a>' . "\r\n";
    $i++;
    endforeach;
    endif;
    ?>
  </ul>
  <nav class="slides-pagination">
    <?php echo $paginador; ?>
  </nav>
</div>
<?php $this->endCache(); endif; ?>