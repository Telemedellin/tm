<?php
class Utilities extends CBehavior
{
	public function slugger($title)
	{
		$characters = array(
			"Á" => "A", "Ç" => "c", "É" => "e", "Í" => "i", "Ñ" => "n", "Ó" => "o", "Ú" => "u", 
			"á" => "a", "ç" => "c", "é" => "e", "í" => "i", "ñ" => "n", "ó" => "o", "ú" => "u",
			"à" => "a", "è" => "e", "ì" => "i", "ò" => "o", "ù" => "u"
		);
		
		$string = strtr($title, $characters); 
		$string = strtolower(trim($string));
		$string = preg_replace("/[^a-z0-9-]/", "-", $string);
		$string = preg_replace("/-+/", "-", $string);
		
		if(substr($string, strlen($string) - 1, strlen($string)) === "-") {
			$string = substr($string, 0, strlen($string) - 1);
		}
		
		return $string;
	}
	public function verificarSlug($slug, $baseUrl = '')
	{
		$slug = trim($slug);
		$c = Url::model()->findByAttributes(array('slug' => $baseUrl.$slug));
		if($c)
        {
        	$lc = substr($slug, -1);
        	if(is_numeric($lc))
        	{
        		$slug = substr($slug, 0, -1) . ( ((int) $lc)+1);	
        	}else
        	{
        		$slug = $slug.'-1';
        	}
        	$slug = $this->verificarSlug($slug);
        }
        return $slug;
	}

	public function imageField($form, $model, $name, $id, $uname = '', $size = 150)
	{
		$html  = '';
		$html .= $form->label($model, $name/*, array('class' => 'col-sm-2 control-label')/**/);
        //$html .= '<div class="col-sm-10">'.PHP_EOL;
		$html .= $form->hiddenField($model, $name, array('id' => $id.'H') );
		$html .= '	<div class="controls imagen">'.PHP_EOL;
		$html .= '		<div id="'.$name.$uname.'">'.PHP_EOL;
		$html .= '		<!-- Mensaje cuando el Javascript se encuentra deshabilitado -->'.PHP_EOL;
		$html .= '		<noscript>Debes tener habilitado Javascript en tu navegador</noscript>'.PHP_EOL;
		$html .= '		<!-- The fileupload-buttonbar contains buttons to add/delete files and start/cancel the upload -->'.PHP_EOL;
		$html .= '		<div class="row fileupload-buttonbar">'.PHP_EOL;
		$html .= '			<div class="col-sm-4">'.PHP_EOL;
		$html .= '			<!-- The fileinput-button span is used to style the file input field as button -->'.PHP_EOL;
		$html .= '				<span class="btn btn-success fileinput-button">'.PHP_EOL;
		$html .= '					<span>Añadir archivo</span> '.PHP_EOL;
		$html .= '					<i class="fa fa-plus"></i>'.PHP_EOL;
		$html .= '					<input id="'.$id.'" type="file" name="'.$id.'[]">'.PHP_EOL;
		$html .= '				</span>              '.PHP_EOL;
		$html .= '				<span class="fileupload-loading"></span>'.PHP_EOL;
		$html .= '			</div>'.PHP_EOL;
		if($model->$name != '')
		{
			$html .= '			<div class="col-sm-8 actual">'.PHP_EOL;
			$html .= '				<blockquote><span>Actual</span>'.PHP_EOL;
			$html .= '				<span><img src="'.bu('images/'.$model->$name).'" width="'.$size.'" /></span></blockquote>'.PHP_EOL;
			$html .= '			</div>'.PHP_EOL;
		}
		$html .= '			<!-- The global progress information -->'.PHP_EOL;
		$html .= '			<div class="col-sm-12 fileupload-progress fade">'.PHP_EOL;
		$html .= '				<!-- The global progress bar -->'.PHP_EOL;
		$html .= '				<div class="progress progress-success progress-striped active" role="progressbar" aria-valuemin="0" aria-valuemax="100">'.PHP_EOL;
		$html .= '				<div class="bar" style="width:0%;"></div>'.PHP_EOL;
		$html .= '			</div>'.PHP_EOL;
		$html .= '			<!-- The extended global progress information -->'.PHP_EOL;
		$html .= '			<div class="progress-extended">&nbsp;</div>'.PHP_EOL;
		$html .= '		</div>'.PHP_EOL;
		$html .= '	</div>'.PHP_EOL;
		$html .= '	<!-- The table listing the files available for upload/download -->'.PHP_EOL;
		$html .= '	<table role="presentation" class="table table-striped">'.PHP_EOL;
		$html .= '		<tbody class="files" data-toggle="modal-gallery" data-target="#modal-gallery"></tbody>'.PHP_EOL;
		$html .= '	</table>'.PHP_EOL;
		$html .= '	</div>'.PHP_EOL;
		//$html .= '	</div>'.PHP_EOL;
		$html .= '</div>'.PHP_EOL;
		return $html;
	}
}