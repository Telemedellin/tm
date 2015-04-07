<?php
class MyTabView extends CTabView
{
    public $htmlOptions = array(
        'class' => 'nav-tabs-custom'//nav nav-tabs
    );
    public $cssFile = false;

    public function init()
    {
        /*if($this->cssFile===null)
        {
            $file=dirname(__FILE__).DIRECTORY_SEPARATOR.'tabview.css';
            $this->cssFile=Yii::app()->getAssetManager()->publish($file);
        }/**/
        parent::init();
    }

    public function registerClientScript()
	{
	    $cs=Yii::app()->getClientScript();
	    $cs->registerScript(
	    	'tab',
	    	'
	    	$(".nav-tabs a").click(function (e) {
			  e.preventDefault()
			  $(this).tab("show")
			})
	    ',
	    CClientScript::POS_READY
	    );
	    //$cs->registerCoreScript('yiitab');
	    $id=$this->getId();
	    //$cs->registerScript('Yii.CTabView#'.$id,"jQuery(\"#{$id}\").yiitab();");

	    if($this->cssFile!==false)
	        self::registerCssFile($this->cssFile);
	}

    protected function renderHeader()
	{
	    echo "<ul class=\"nav nav-tabs\">\n";
	    foreach($this->tabs as $id=>$tab)
	    {
	        $title=isset($tab['title'])?$tab['title']:'undefined';
	        $active=$id===$this->activeTab?' class="active"' : '';
	        $url=isset($tab['url'])?$tab['url']:"#{$id}";
	        echo "<li{$active}><a href=\"{$url}\">{$title}</a></li>\n";
	    }
	    echo "</ul>\n";
	}

	protected function renderBody()
	{
	    echo '<div class="tab-content">';
	    foreach($this->tabs as $id=>$tab)
	    {
	        $active=$id===$this->activeTab?' active' : '';
	        echo "<div class=\"tab-pane{$active}\" id=\"{$id}\">\n";
	        if(isset($tab['content']))
	            echo $tab['content'];
	        elseif(isset($tab['view']))
	        {
	            if(isset($tab['data']))
	            {
	                if(is_array($this->viewData))
	                    $data=array_merge($this->viewData, $tab['data']);
	                else
	                    $data=$tab['data'];
	            }
	            else
	                $data=$this->viewData;
	            $this->getController()->renderPartial($tab['view'], $data);
	        }
	        echo "</div><!-- {$id} -->\n";
	    }
	    echo "</div>";
	}
}