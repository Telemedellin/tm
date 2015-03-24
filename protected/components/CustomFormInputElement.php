<?php
class CustomFormInputElement extends CFormInputElement
{
	
	public function render()
	{
	    if($this->type==='hidden')
	        return $this->renderInput();

	    //Envuelvo el elemento en el div controls como lo indica bootstrap 3
	    $pre = '<div class="controls';
	    if($this->getRequired()) $pre .= ' required'; //Agrego la clase required para aplicar estilos
	    if($this->getParent()->showErrors && $this->renderError())
	    	$pre .= ' error'; //Agrego la clase error para aplicar estilos
	    $pre .= '">';

	    $post = '</div>' ;

	    $output=array(
	        '{label}'=>$this->renderLabel(),
	        '{input}'=>$pre.$this->renderInput(),
	        '{hint}'=>$this->renderHint(),
	        '{error}'=>(!$this->getParent()->showErrors ? '' : $this->renderError()).$post,
	    );
	    return strtr($this->layout,$output);
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