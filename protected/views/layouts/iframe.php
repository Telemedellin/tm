<script id="albumListViewTemplate" type="text/template">
	<h1>Álbumes de <%= nombre %></h1>
	<ul class="albumes"></ul>
</script>
<script id="albumListItemViewTemplate" type="text/template">
<a href="<%= url %>" class="in_fancy" data-id="<%= id %>">
	<img src="<%= thumb %>" width="105" height="77" />
	<h2><%= nombre %></h2>
</a>
</script>
<script id="fotoListViewTemplate" type="text/template">
	<a href="#" class="back">Volver</a>
	<h1><%= nombre %></h1>
</script>
<script id="fotoListItemViewTemplate" type="text/template">
<li class="foto">
	<a href="<%= src %>" data-id="<%= id %>">
		<img src="<%= thumb %>" width="105" height="77" />
		<h2><%= nombre %></h2>
	</a>
</li>
</script>
<script id="fotoListViewTemplate" type="text/template">
	<h1><%= nombre %></h1>
</script>
</script>
<div id="icontainer">
	<?php echo $content; ?>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/iframe/underscore-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/iframe/backbone-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/iframe.app-dev.js"></script>