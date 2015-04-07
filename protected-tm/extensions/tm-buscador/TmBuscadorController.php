<?php
Yii::import('ext.tm-buscador.*');
class TmBuscadorController extends CExtController
{
	public $layout='//layouts/telemedellin';
	public $breadcrumbs=array();
	/**
	 * SEO
	 */
	public $pageTitle = '';
    public $pageDesc = '';
    public $pageRobotsIndex = true;

	public function actionIndex()
	{
		$resultados = array();
		if( isset($_GET['termino']) )
		{
			
		}
		$this->render('tmResultados', array('termino' => $_GET['termino'], 'resultados' => $resultados) );
	}

	public function display_seo()
	{
	    // STANDARD TAGS
	    // -------------------------
	    // Title/Desc
	    echo "\t".''.PHP_EOL;
	    echo "\t".'<meta name="description" content="', h($this->pageDesc),'">'.PHP_EOL;

	    // Option for NoIndex
	    if ( $this->pageRobotsIndex == false ) {
	        echo '<meta name="robots" content="noindex">'.PHP_EOL;
	    }

	}
}
?>