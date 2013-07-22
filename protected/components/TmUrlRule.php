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
        if ( preg_match('%^([\w-]+)(/([\w-]+))?(/([\w-]+))?%', $pathInfo, $matches) )
        {
            $seccion = strtolower($matches[1]); //Asumo inicialmente que es una sección
            $results = $this->buscar_seccion($seccion); //Verifico en la base de datos si la sección existe
            
            if( $results ) //Si encuentra la sección
            {
                $_GET['tm']['seccion'] = $results; //Asigno la variable sección con el slug
                array_shift($matches); //Elimino los dos primeros índices para verificar si la url tiene más elementos
                array_shift($matches);
            }
            else //Si no encuentra la sección, se asume que es un micrositio de la sección "telemedellin (por defecto)"
            {
                $seccion = 'telemedellin';
                $_GET['tm']['seccion'] = array('slug' => 'telemedellin','nombre' => 'Telemedellín', 'id' => 1);
            }

            if( count($matches) > 1 ) //Si hay más partes es porque viene un micrositio
            {
                $micrositio = strtolower($matches[1]);
                $resultm = $this->buscar_micrositio($micrositio, $seccion); //Verifico en la base de datos si el micrositio existe

                if( $resultm ) //Si encuentra el micrositio
                {
                    $_GET['tm']['micrositio'] = $resultm; //Asigno el micrositio encontrado
                    array_shift($matches); //Elimino los dos primeros índices para verificar si la url tiene más elementos
                    array_shift($matches);
                }
                else
                {
                    return false;
                }
            }
            
            if( count($matches) > 1 ) //Si hay más partes es porque viene una página
            {
                $pagina = $_GET['tm']['pagina'] = strtolower($matches[1]);
            }


            return 'telemedellin/cargar';
        }
        return false;  // this rule does not apply
    }

    public function buscar_seccion($seccion)
    {
        $secciones = array( 
                            array('slug' => 'telemedellin','nombre' => 'Telemedellín', 'id' => 1),
                            array('slug' => 'programas'   ,'nombre' => 'Programas'   , 'id' => 2),
                            array('slug' => 'especiales'  ,'nombre' => 'Especiales'  , 'id' => 3),
                            array('slug' => 'documentales','nombre' => 'Documentales', 'id' => 4),
                            array('slug' => 'institucional','nombre' => 'Institucional', 'id' => 5),
                            array('slug' => 'noticias'    ,'nombre' => 'Noticias'    , 'id' => 6),
                        );
        //$result = ( in_array($seccion, $secciones) ) ? true : false;
        //$existe = array_search($seccion, $secciones);
        $existe = false;

        foreach($secciones as $key => $value) { 
            if( stristr($seccion, $value['slug']) )
            {
                $existe = $key;
                continue;
            } 
        } 
        if(!$existe) return false;
        else return $secciones[$existe];
    }

    public function buscar_micrositio($micrositio, $seccion)
    {
        $command = Yii::app()->db->createCommand();
        $result  = $command->select('micrositio.*')
                            ->from('micrositio')
                            ->join('seccion', 'seccion.id = micrositio.seccion_id')
                            ->where('micrositio.slug=:slug AND seccion.slug=:seccion', 
                                    array(':slug'    => $micrositio,
                                          ':seccion' => $seccion, )
                            )
                            ->queryRow();
        if( count($result) ) //Si encuentra el micrositio
            return $result; 
        else
            return false;
    }
}