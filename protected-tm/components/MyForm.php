<?php
class MyForm extends CForm
{
    
    public $inputElementClass = 'CustomFormInputElement';

    public function renderElement($element)
	{
	    if(is_string($element))
	    {
	        if(($e=$this[$element])===null && ($e=$this->getButtons()->itemAt($element))===null)
	            return $element;
	        else
	            $element=$e;
	    }
	    if($element->getVisible())
	    {
	        if($element instanceof CFormInputElement)
	        {
	            if($element->type==='hidden')
	                return "<div style=\"visibility:hidden\">\n".$element->render()."</div>\n";
	            else
	                return "<div class=\"control-group field_{$element->name}\">\n".$element->render()."</div>\n";
	            	//Envuelvo el elemento en un div y agrego la clase control-group de bootstrap 3
	        }
	        elseif($element instanceof CFormButtonElement)
	            return $element->render()."\n";
	        else
	            return $element->render();
	    }
	    return '';
	}

}