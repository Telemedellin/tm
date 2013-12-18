<?php
/**
 * Controller is the customized base controller class.
 * All controller classes for this application should extend from this base class.
 */
class Controller extends CController
{
	/**
	 * @var string the default layout for the controller view. Defaults to '//layouts/column1',
	 * meaning using a single column layout. See 'protected/views/layouts/column1.php'.
	 */
	public $layout='//layouts/telemedellin';
	/**
	 * @var array context menu items. This property will be assigned to {@link CMenu::items}.
	 */
	public $menu=array();
	/**
	 * @var array the breadcrumbs of the current page. The value of this property will
	 * be assigned to {@link CBreadcrumbs::links}. Please refer to {@link CBreadcrumbs::links}
	 * for more details on how to specify this property.
	 */
	public $breadcrumbs=array();
	/**
	 * SEO
	 */
	public $pageTitle = '';
    public $pageDesc = 'Canal público cultural de la ciudad de Medellín.';
    public $pageRobotsIndex = true;

    public function display_seo()
	{
	    // STANDARD TAGS
	    // -------------------------
	    // Title/Desc
	    echo "\t".''.PHP_EOL;
	    echo "\t".'<meta name="description" content="', h(substr(strip_tags($this->pageDesc), 0, 155)),'">'.PHP_EOL;

	    // Option for NoIndex
	    if ( $this->pageRobotsIndex == false ) {
	        echo '<meta name="robots" content="noindex">'.PHP_EOL;
	    }
	    echo '<meta property="og:title" content="' . CHtml::encode($this->pageTitle).'" />'.PHP_EOL;
	    echo '<meta property="og:type" content="website" />'.PHP_EOL;
	    echo '<meta property="og:url" content="'. Yii::app()->getBaseUrl(true) . Yii::app()->request->requestUri .'" />'.PHP_EOL;
		//echo '<meta property="og:image" content="'. Yii::app()->request->baseUrl.'/images/static/fb-img.jpg" />'.PHP_EOL;
	}
}