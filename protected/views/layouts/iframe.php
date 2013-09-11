<?php /* @var $this Controller */ 
$ru = Yii::app()->request->requestUri;
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/libs/bootstrap.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/libs/bootstrap-responsive.min.css" />
	<link rel="stylesheet" type="text/css" href="<?php echo bu('css'); ?>/iframe.css" />
	<!--[if LTE IE 8]>
	  <link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/ie.css" />
	<![endif]-->
	<title><?php echo h($this->pageTitle); ?> - Telemedellín</title>
</head>

<body>
<div id="container">
	<?php echo $content; ?>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/iframe.libs.min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/iframe.app.min.js"></script>
</body>
</html>