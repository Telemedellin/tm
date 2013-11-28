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
		$c = Url::model()->findByAttributes(array('slug' => $baseUrl.$slug));
		if($c)
        {
        	$lc = substr($slug, -1);
        	if(is_numeric($lc))
        	{
        		$slug = substr($slug, 0, -1) . ($lc+1);	
        	}else
        	{
        		$slug = $slug.'-1';
        	}
        	$slug = $this->verificarSlug($slug);
        }
        return $slug;
	}
}