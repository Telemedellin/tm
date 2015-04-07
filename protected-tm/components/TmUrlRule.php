<?php
class TmUrlRule extends CBaseUrlRule
{
    public $connectionID = 'db';
    public $redirecciones = 
        array(
            'default'               => '',
            'inicio'                => '',
            'emisora'               => 'radio', 
            'senalenvivo'           => 'senal-en-vivo', 
            'programacion'          => 'programacion', 
            'nuestros-programas'    => 'programas', 
            'especial'              => 'especiales', 
            'concurso'              => 'concursos', 
            'pagina_nueva'          => 'senal-en-vivo', 
            'mapa-sitio'            => 'mapa-del-sitio', 
            'suso-show'             => 'programas/the-suso-s-show',
            'laviejoteca'           => 'programas/la-viejoteca',
            'taxi'                  => 'programas/taxi-historias-sin-fronteras',
            'clima247'              => 'programas/clima-247', 
            'copatelemedellinrugby' => 'programas/copa-telemedellin-de-rugby-15-s', 
            'capicua'               => 'programas/ciudad-escuela', 
            'institucional'         => 'telemedellin/institucional',
            'canal-parque'          => 'telemedellin/quienes-somos/canal-parque',
            'contactenos'           => 'telemedellin/utilidades/escribenos', 
            'terminos-condiciones'  => 'telemedellin/utilidades/terminos-y-condiciones-de-uso', 
            'valiente'              => 'documentales/valiente-valentina', 
            'elhacedor'             => 'documentales/el-hacedor-de-imanes', 
            'sistemainformativotelemedellin' => 'programas/noticias-telemedellin', 
        );

    public function createUrl($manager, $route, $params, $ampersand)
    {
        return false;  // this rule does not apply
    }
 
    public function parseUrl($manager, $request, $pathInfo, $rawPathInfo)
    {
        if ( preg_match('%^([\w-]+)(/([\w-]+))?(/([\w-]+))?%', $pathInfo, $pedazos) )
        {
            $slug = $this->verificar_slug($pathInfo);
            if( !$slug )
            {
                if( !$this->completar_slug($pathInfo) ) 
                    if( !$this->crear_slug($pedazos) ) 
                        return false;
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

    private function verificar_slug($slug)
    {
        if( $slug == 'radio/emisora')
            Yii::app()->request->redirect( 'http://radio.telemedellin.tv', true, 301 );
        return Url::model()->findByAttributes( array('slug' => $slug) );        
    }

    private function crear_slug($pedazos)
    {
        $raiz = $pedazos[1];
        if($raiz != 'Paginas')
        {
            $this->corregir_url($raiz);
            return $this->completar_slug($raiz);
        }
        //Detecto si viene para alguna página suelta
        else if($raiz == 'Paginas' && count($pedazos > 3))
        {
            $s = $pedazos[3];
            $this->corregir_url($s);
            $this->corregir_url($s, true);
            return $this->completar_slug($s);
        }//if($pedazos[1]...
    }

    private function corregir_url( $old_url, $fragment = false)
    {
        foreach($this->redirecciones as $old => $new)
        {
            $condicion = ( $fragment )? ( strpos($old_url, $old) !== false ): $old_url == $old;
            if( $condicion ) Yii::app()->request->redirect(bu($new), true, 301);
        }
        return false;
    }

    private function completar_slug($pathInfo)
    {
        $slugs = array( 'programas/' . $pathInfo,
                        'especiales/' . $pathInfo,
                        'concursos/' . $pathInfo,
                        'documentales/' . $pathInfo,
                        'telemedellin/' . $pathInfo,
                        'recorrido-canal-parque/' . $pathInfo, 
                        '15-años-con-vos/' . $pathInfo,
                    );
        foreach($slugs as $slug)
            if($this->verificar_slug($slug)) Yii::app()->request->redirect(bu($slug), true, 301);
        return false;
    }
}