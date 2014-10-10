<?php 
if($this->layout == 'pc')
	$logo_url = bu('images/static/logo.png');
else
	$logo_url = bu('images/static/logo-mobile.png');
$nombre = "Telemedellín, aquí te ves";
$title = "Ir a la página de inicio de Telemedellín";

if($guino = $this->getGuino()):
	$logo_url = bu('images/');
	$logo_url .= ($this->layout == 'pc')?$guino->guino:$guino->guino_mobile;
	$nombre = $guino->nombre;
	$title = $guino->nombre;
endif; 
?>
<img src="<?php echo $logo_url ?>" alt="<?php echo $nombre ?>" title="<?php echo $title ?>" />