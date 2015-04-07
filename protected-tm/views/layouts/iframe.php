<script id="albumListViewTemplate" type="text/template">
	<?php if($this->theme != 'pc'): ?>
		<a href="" class="back">Volver</a>
	<?php endif; ?>
	<h1>Álbumes de fotos <%= nombre %></h1>
	<ul class="albumes"></ul>
</script>
<script id="albumListItemViewTemplate" type="text/template">
<a href="<%= url %>" class="in_fancy" data-id="<%= id %>">
	<figure><img src="<%= thumb %>" /></figure>
	<h2><%= nombre %></h2>
</a>
</script>
<script id="fotoListViewTemplate" type="text/template">
	<a href="#imagenes" class="back">Volver</a>
	<h1><%= nombre %></h1>
	<div class="full"></div>
	<ul class="fotos"></ul>
</script>
<script id="fotoListItemViewTemplate" type="text/template">
	<a href="<%= <?php echo ($this->theme == 'pc')? 'url':'src'?> %>" class="<%= id %> <?php echo ($this->theme == 'pc')? '':'swb'?>" data-id="<%= id %>" data-src="<%= src %>" data-url="<%= url %>" data-nombre="<%= nombre %>" <?php echo ($this->theme == 'pc')? '':'rel="galeria"'?> title="<%= nombre %>">
		<figure><img src="<%= thumb %>" width="150" height="60" /></figure>
		<?php if($this->theme != 'pc'):?><p><%= nombre %></p><?php endif; ?>
	</a>
</script>
<script id="videoalbumListViewTemplate" type="text/template">
	<?php if($this->theme != 'pc'): ?>
		<a href="" class="back">Volver</a>
	<?php endif; ?>
	<h1>Álbumes de video de <%= nombre %></h1>
	<ul class="videoalbumes"></ul>
</script>
<script id="videoalbumListItemViewTemplate" type="text/template">
<a href="<%= url %>" class="in_fancy" data-id="<%= id %>">
	<figure><img src="<%= thumb %>" /></figure>
	<h2><%= nombre %></h2>
</a>
</script>
<script id="videoListViewTemplate" type="text/template">
	<a href="#videos" class="back">Volver</a>
	<h1><%= nombre %></h1>
	<div class="full"></div>
	<ul class="ivideos"></ul>
</script>
<script id="videoListItemViewTemplate" type="text/template">
	<a style="display:block;" href="<%= url %>" class="<%= id %>" data-id="<%= id %>" data-id_video="<%= id_video %>" data-nombre="<%= nombre %>" data-pv="<%= proveedor_video %>">
		<figure>
			<img src="<%= thumbnail %>" />
			<h2><%= nombre %></h2>
		</figure>
		<% if (descripcion) { %>
		<div class="infoVideo">
			<%= descripcion %>
		</div>
		<% }  %>
	</a>
</script>
<div id="icontainer"<?php echo ($this->theme != 'pc')?' class="mobile"':'' ?>>
	<?php echo $content; ?>
</div>
<script src="<?php echo bu('/js/libs/iframe/underscore-min.js') ?>"></script>
<script src="<?php echo bu('/js/libs/iframe/backbone-min.js') ?>"></script>
<?php if($this->theme != 'pc'): ?>
<script src="<?php echo bu('/js/libs/mobile/jquery.swipebox.js') ?>"></script>
<?php else: ?>
<script src="<?php echo bu('/js/libs/iframe/screenfull.js') ?>"></script>
<?php endif; ?>
<script src="<?php echo bu('/js/iframe.app.min.js') ?>"></script>