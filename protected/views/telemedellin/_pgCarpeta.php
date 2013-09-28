<script id="carpetaListViewTemplate" type="text/template">
	<ul class="carpetas"></ul>
</script>
<script id="carpetaListItemViewTemplate" type="text/template">
<a href="<%= url %>" data-id="<%= id %>">
	<%= carpeta %>
</a>
</script>
<script id="archivoListViewTemplate" type="text/template">
	<a href="" class="back">Volver</a>
	<ul class="archivos"></ul>
</script>
<script id="archivoListItemViewTemplate" type="text/template">
	<a href="<%= url %>" class="<%= id %>" data-id="<%= id %>" data-nombre="<%= nombre %>">
		<%= nombre %>
	</a>
</script>
<div id="ccontainer"></div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/iframe/underscore-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/iframe/backbone-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/file.app-dev.js"></script>