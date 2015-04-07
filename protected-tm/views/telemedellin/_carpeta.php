<?php cs()->registerScriptFile(bu('/js/libs/iframe/underscore-min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(bu('/js/libs/iframe/backbone-min.js'), CClientScript::POS_END);?>
<?php cs()->registerScriptFile(bu('/js/file.app.min.js'), CClientScript::POS_END);?>
<script id="carpetaListViewTemplate" type="text/template">
	<ul class="carpetas"></ul>
</script>
<script id="carpetaListItemViewTemplate" type="text/template">
<a href="<%= url %>" data-id="<%= id %>">
	<%= carpeta %>
</a>
</script>
<script id="archivoListViewTemplate" type="text/template">
	<ul class="archivos"></ul>
</script>
<script id="archivoListItemViewTemplate" type="text/template">
	<a href="<%= url %>" data-id="<%= id %>" data-nombre="<%= nombre %>" data-archivo="<%= archivo %>" data-carpeta="<%= carpeta.ruta %>">
		<%= nombre %>
	</a>
</script>
<script id="archivoItemViewTemplate" type="text/template">
	<p>Detalles del archivo <%= nombre %> <%= tipo_archivo %></p>
</script>
<div id="ccontainer"></div>