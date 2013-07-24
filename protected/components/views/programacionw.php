<?php $programas = $this->getProgramas()?>
<div id="programacion">
    <a class="programacion" href="<?php echo bu('/programacion')?>">Ver toda la programación</a>
    <!--El hover abre el tooltip, el clic señal en vivo -->
    <a class="al-aire" href="<?php echo bu(); ?>">
      <span class="estado">Al aire</span> 
      <span class="programa"><?php echo $programas['actual']->micrositio->nombre ?></span>
    </a>
    <!--El hover abre el tooltip, el clic al programa-->
    <a class="a-continuacion" href="#">
      <span class="estado">A continuación</span> 
      <span class="programa"><?php echo $programas['siguiente']->micrositio->nombre ?></span>
    </a>
    <a class="senal-en-vivo" href="#">
      Disfrutá Telemedellín <span>en vivo</span>
    </a>
  </div>