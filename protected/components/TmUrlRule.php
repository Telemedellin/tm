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
        if ( preg_match('%^([\w-]+)(/([\w-]+))?(/([\w-]+))?%', $pathInfo, $pedazos) )
        {
            $slug = $this->verificar_slug($pathInfo);
            if( !$slug )
            {
                //if( !$this->crear_slug($pedazos) ) return false;
                $slug = $this->crear_slug($pedazos);
                if(!$slug) return false;
            }
            $_GET['tm'] = $slug;
            switch ( $slug->tipo_id ) {
                case 1:
                    return 'telemedellin/cargarSeccion';
                case 2:
                    switch( $slug->slug ){
                        case 'novedades':
                            return 'telemedellin';
                        case 'programacion':
                            return 'telemedellin/cargarProgramacion';
                        default:
                            return 'telemedellin/cargarMicrositio';
                    }
                case 3:
                    $_GET['slug_id'] = $slug->id;
                    return 'telemedellin/cargarMicrositio';
                default:
                    return 'telemedellin';
            }
        }
        return false;  // this rule does not apply
    }

    private function verificar_slug($slug, $parcial = false)
    {
        $dependencia = new CDbCacheDependency("SELECT GREATEST(MAX(url.creado), MAX(url.modificado)) FROM url WHERE url.estado <> 0");
        if(!$parcial)
            return Url::model()->cache(86400, $dependencia)->findByAttributes( array('slug' => $slug) );
        else
        {
            return Url::model()->cache(86400, $dependencia)->find( 'slug LIKE "%'.$slug.'%"' );
        }
    }

    private function crear_slug($pedazos)
    {
        $raiz = $pedazos[1];
        if($raiz != 'Paginas')
        {
            $p = 'programas/' . $raiz;
            $e = 'especiales/' . $raiz;
            $c = 'concursos/' . $raiz;
            $d = 'documentales/' . $raiz;
            if($raiz == 'institucional') Yii::app()->request->redirect(bu('telemedellin/institucional'), true, 301);
            else if($raiz == 'canal-parque') Yii::app()->request->redirect(bu('telemedellin/quienes-somos/canal-parque'), true, 301);
            else if($raiz == 'suso-show') Yii::app()->request->redirect(bu('programas/the-suso-s-show'), true, 301);
            else if($raiz == 'laviejoteca') Yii::app()->request->redirect(bu('programas/la-viejoteca'), true, 301);
            else if($raiz == 'taxi') Yii::app()->request->redirect(bu('programas/taxi-historias-sin-fronteras'), true, 301);
            else if($raiz == 'clima247') Yii::app()->request->redirect(bu('programas/clima-247'), true, 301);
            else if($raiz == 'copatelemedellinrugby') Yii::app()->request->redirect(bu('programas/copa-telemedellin-de-rugby-15-s'), true, 301);
            else if($raiz == 'capicua') Yii::app()->request->redirect(bu('programas/ciudad-escuela'), true, 301);
            else if($raiz == 'pagina_nueva') Yii::app()->request->redirect(bu('senal-en-vivo'), true, 301);
            else if($this->verificar_slug($p)) Yii::app()->request->redirect(bu($p), true, 301);
            else if($this->verificar_slug($e)) Yii::app()->request->redirect(bu($e), true, 301);
            else if($this->verificar_slug($c)) Yii::app()->request->redirect(bu($c), true, 301);
            else if($this->verificar_slug($d)) Yii::app()->request->redirect(bu($d), true, 301);
            //else return $this->verificar_slug($raiz, true);
            //else return false;
        }
        //Detecto si viene para alguna página suelta
        else if($raiz == 'Paginas' && count($pedazos > 3))
        {
            $s = $pedazos[3];
            $e = 'especiales/' . $s;
            $c = 'concursos/' . $s;
            $d = 'documentales/' . $s;
            //Si la página es el home antiguo /Paginas/default.aspx
            if($s == 'default') Yii::app()->request->redirect(bu('telemedellin'), true, 301);
            else if($s == 'senalenvivo') Yii::app()->request->redirect(bu('senal-en-vivo'), true, 301);
            else if($s == 'programacion') Yii::app()->request->redirect(bu('programacion'), true, 301);
            else if($s == 'nuestros-programas') Yii::app()->request->redirect(bu('programas'), true, 301);
            else if($s == 'contactenos') Yii::app()->request->redirect(bu('telemedellin/utilidades/escribenos'), true, 301);
            else if($s == 'terminos-condiciones') Yii::app()->request->redirect(bu('telemedellin/utilidades/terminos-y-condiciones-de-uso'), true, 301);
            else if($s == 'mapa-sitio') Yii::app()->request->redirect(bu('mapa-del-sitio'), true, 301);
            else if(strpos($s, "concurso") !== false) Yii::app()->request->redirect(bu('concursos'), true, 301);
            else if($s == 'sistemainformativotelemedellin') Yii::app()->request->redirect(bu('programas/noticias-telemedellin'), true, 301);
            else if(strpos($s, "valiente") !== false) Yii::app()->request->redirect(bu('documentales/valiente-valentina'), true, 301);
            else if(strpos($s, "elhacedor") !== false) Yii::app()->request->redirect(bu('documentales/el-hacedor-de-imanes'), true, 301);
            else if(strpos($s, "especial") !== false) Yii::app()->request->redirect(bu('especiales'), true, 301);
            else if($this->verificar_slug($s)) Yii::app()->request->redirect(bu($s), true, 301);
            else if($this->verificar_slug($e)) Yii::app()->request->redirect(bu($e), true, 301);
            else if($this->verificar_slug($c)) Yii::app()->request->redirect(bu($c), true, 301);
            else if($this->verificar_slug($d)) Yii::app()->request->redirect(bu($d), true, 301);
            //else return $this->verificar_slug($s, true);
            //else return false;
        }//if($pedazos[1]...
    }
}