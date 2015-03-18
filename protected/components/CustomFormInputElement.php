<?php
class CustomFormInputElement extends CFormInputElement
{
	
	public function renderInput()
	{
	    //Envuelvo el elemento en el div controls como lo indica bootstrap 3
	    $output = '<div class="controls';
	    if($this->getRequired()) $output .= ' required'; //Agrego la clase required para aplicar estilos
	    if($this->getParent()->showErrors && $this->renderError())
	    	$output .= ' error'; //Agrego la clase error para aplicar estilos
	    $output .= '">';
	    if(isset(self::$coreTypes[$this->type]))
	    {
	        $method=self::$coreTypes[$this->type];
	        if(strpos($method,'List')!==false)
	            $output .= CHtml::$method($this->getParent()->getModel(), $this->name, $this->items, $this->attributes);
	        else
	            $output .= CHtml::$method($this->getParent()->getModel(), $this->name, $this->attributes);
	    }
	    else
	    {
	        $attributes=$this->attributes;
	        $attributes['model']=$this->getParent()->getModel();
	        $attributes['attribute']=$this->name;
	        ob_start();
	        $this->getParent()->getOwner()->widget($this->type, $attributes);
	        $output .= ob_get_clean();
	    }
	    $output .= '</div>';
	    return $output;
	}

	public function renderLabel()
	{
	    $options = array(
	        'label'=>$this->getLabel(),
	        //required'=>$this->getRequired(), Elimino la opción required para que no aparezca el asterisco
	        'class'=> 'control-label' //Agrego la clase control-label de bootstrap 3
	    );
	    if($this->getRequired()) $options['class'] .= ' required'; //Agrego la clase required al label

	    if(!empty($this->attributes['id']))
	        $options['for']=$this->attributes['id'];

	    return CHtml::activeLabel($this->getParent()->getModel(), $this->name, $options);
	}
}