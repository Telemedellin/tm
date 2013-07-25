<?php
class TmUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
 
    public function createUrl($manager, $route, $params, $ampersand)
    {
        /*if ($route==='car/index')
        {
            if (isset($params['manufacturer'], $params['model']))
                return $params['manufacturer'] . '/' . $params['model'];
            else if (isset($params['manufacturer']))
                return $params['manufacturer'];
        }*/
        return false;  // this rule does not apply
    }

    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        
        if ( preg_match('%^([\w-]+)(/([\w-]+))?(/([\w-]+))?%', $pathInfo) )
        {
            $slug = Url::model()->findByAttributes( array('slug' => $pathInfo) );
            if( !$slug ) return false;

            $_GET['tm'] = $slug;
            return 'telemedellin/cargar';

        }

        return false;  // this rule does not apply
    }
}