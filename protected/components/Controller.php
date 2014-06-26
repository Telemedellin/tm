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

	public $theme = 'pc';
	/**
	 * SEO
	 */
	public $pageTitle = '';
    public $pageDesc = 'Canal público cultural de la ciudad de Medellín. Programación, noticias, horarios.';
    public $pageRobotsIndex = true;

    public function display_seo($title = '')
	{
	    $ru = Yii::app()->request->requestUri;
	    $titulo = ($title != '')? h($title) . ' - ':'';
	    $titulo .= 'Telemedellín, aquí te ves';
	    echo '<meta charset="utf-8">'.PHP_EOL;
	    //Pilas con el icono para Apple y esos metas
		echo "\t".'<meta name="viewport" content="width=device-width, initial-scale=1">'.PHP_EOL;
		echo "\t".'<link rel="canonical" href="http://telemedellin.tv' . $ru . '" />'.PHP_EOL;
		echo "\t".'<link rel="shortcut icon" href="' . bu('/favicon.ico') . '" />'.PHP_EOL;
		if ( $this->pageRobotsIndex == false ) {// Option for NoIndex
	        echo "\t".'<meta name="robots" content="noindex">'.PHP_EOL;
	    }
	    echo "\t".'<title>' . $titulo . '</title>'.PHP_EOL;
	    echo "\t".'<meta name="description" content="', h(substr(strip_tags($this->pageDesc), 0, 160)),'">'.PHP_EOL;
	    echo "\t".'<meta property="og:title" content="' . $titulo . '" />'.PHP_EOL;
	    echo "\t".'<meta property="og:type" content="website" />'.PHP_EOL;
	    echo "\t".'<meta property="og:url" content="http://telemedellin.tv' . $ru .'" />'.PHP_EOL;
		//echo '<meta property="og:image" content="'. Yii::app()->request->baseUrl.'/images/static/fb-img.jpg" />'.PHP_EOL;
	}

	public function init() 
	{
		parent::init();

		cs()->coreScriptPosition 		= CClientScript::POS_END;
		cs()->defaultScriptFilePosition = CClientScript::POS_END;
		
		$this->theme = 'movil';

		$useragent = $_SERVER['HTTP_USER_AGENT'];
		/*if (strpos($useragent, 'Android') || strpos($useragent, 'iPad') || strpos($useragent, 'iPhone') || strpos($useragent, 'PlayBook') || strpos($useragent, 'BB10') || strpos($useragent, 'BlackBerry') || strpos($useragent, 'Opera Mini') || strpos($useragent, 'IEMobile') || strpos($useragent, 'webOS') || strpos($useragent, 'MeeGo'))
		    $this->theme = 'movil';
		else
		   $this->theme =  'pc';/**/

	    if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od|ad)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)))
	    {
	   		$this->theme = 'movil';
	    }else
	    {
	   		$this->theme =  'pc';
	    }/**/
	    
		Yii::app()->setTheme($this->theme);
		return true;
	}
}