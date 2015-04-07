<div id="buscador">
  <?php $form = $this->beginWidget('CActiveForm', array(
      'action' => CHtml::normalizeUrl( bu('buscar') ),
      'enableAjaxValidation'  =>true,
      'enableClientValidation'=>true,
      'id'                    =>'search-form',
      'method'                =>'get',          
  )); ?>
      <?php
      $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
          'name'         =>'termino',
          'sourceUrl'    =>CHtml::normalizeUrl( bu('buscar') ), 
          'options'      =>array(// additional javascript options for the autocomplete plugin
              'minLength'=> '2',
          ),
          'htmlOptions'  =>array(
              //'style'=>'height:20px;', 
    	       "placeholder"=>'¿Qué buscás?'
          ),
      ));
      /*Yii::app()->clientScript->registerScript(
        'autocompleteselect', 
        '$( "#termino" ).on( 
          "autocompleteselect", 
          function( event, ui ) {
            //console.log(ui.item);
            window.location = "' . Yii::app()->homeUrl . '" + ui.item.slug;
          } 
        );', 
        CClientScript::POS_READY
      );*/
      ?>
      <?php echo CHtml::submitButton('Buscar', array("class"=>"btn btn-large")) ?>
  <?php $this->endWidget(); ?>
</div>