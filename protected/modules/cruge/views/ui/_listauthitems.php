<?php 
$this->widget('zii.widgets.CListView', array(
	'id'=>'list-auth-items',
    'dataProvider'=>$dataProvider,
	'afterAjaxUpdate'=>'crugeListAuthItemFunctions',
    'itemView'=>'_authitem',
    'sortableAttributes'=>array(
        'name',
    ),
));	
	$url_updater = CHtml::normalizeUrl(array('/cruge/ui/ajaxrbacitemdescr'));
	$loading = Yii::app()->user->ui->getResource('loading.gif');
	$loading = "<img src=\'{$loading}\'>";
?>
<?php 
$script = "
	var crugeListAuthItemFunctions = function(){
	jQuery('#list-auth-items .referencias').each(function(){
		jQuery(this).click(function(){
			jQuery(this).parent().find('ul').toggle('slow');
		});
	});
	// actualizador de la descripcion del authitem en base a reglas de 
	// sintaxis.
	jQuery('#list-auth-items select').each(function(){
		jQuery(this).change(function(){
			var action = jQuery(this).val();
			var itemname = jQuery(this).attr('alt');
			if(action != ''){
				// hace la actualizacion via ajax y actualiza la descripcion
				// del item
				var url = '". $url_updater ."';
				var descrSpan = jQuery(this).parent().parent().find('span.description');
				descrSpan.html('".$loading."');
				jQuery.ajax({ url: url, cache: false, dataType: 'json', type: 'post', 
					data: { action: action, itemname: itemname },
					success: function(data){ descrSpan.html(data['description']); },
					error: function(e){ descrSpan.html(
						'error: '+e.responseText); }
				});
			}
		});
	}); }
	crugeListAuthItemFunctions();";
cs()->registerScript( 'crugeListAuthItemFunctions', $script );
?>
