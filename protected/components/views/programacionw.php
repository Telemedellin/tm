<?php $programas = $this->getProgramas()?>
<div id="programacion">
    <a class="programacion" href="<?php echo bu('/programacion')?>" title="Ver toda la programación de Telemedellín">Toda la programación</a>
    <a class="al-aire" href="<?php echo bu('senal-en-vivo'); ?>" title="Ver este programa en la señal en vivo de Telemedellín">
      <span class="estado">Al aire</span> 
      <span class="programa"><?php if($programas['actual']) echo $programas['actual']->micrositio->nombre ?></span>
    </a>
    <a class="a-continuacion" href="<?php if($programas['siguiente']) echo bu($programas['siguiente']->micrositio->url->slug)?>" title="Ir al micrositio de este programa">
      <span class="estado">A continuación</span> 
      <span class="programa"><?php if($programas['siguiente']) echo $programas['siguiente']->micrositio->nombre ?></span>
    </a>
    <a class="senal-en-vivo" href="<?php echo bu('senal-en-vivo'); ?>" title="Ver la señal en vivo de Telemedellín"><span>Señal en vivo</span></a>
</div>