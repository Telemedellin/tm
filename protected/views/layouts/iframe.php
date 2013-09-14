<script id="albumListItemViewTemplate" type="text/template">
<a href="<%= url %>" class="in_fancy" data-id="<%= id %>">
	<img src="<%= thumb %>" width="105" height="77" />
	<h2><%= nombre %></h2>
</a>
</script>
<script id="albumViewTemplate" type="text/template">
	<p>Tal</p>
</script>
<div id="icontainer">
	<?php echo $content; ?>
</div>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/iframe/underscore-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/libs/iframe/backbone-min.js"></script>
<script src="<?php echo Yii::app()->request->baseUrl; ?>/js/iframe.app-dev.js"></script>