<?php
class UrlTest extends CDbTestCase
{
	public $fixtures = array(
        //'urls' => 'Url',
    );

    public function testAgregar()
    {
    	$url = new Url;
	    $url->setAttributes(
	    	array(
		        'slug' 		=> 'programas/cualquier-otra-prueba',
		        'tipo_id' 	=> 2,
	    	), false);
	    $this->assertTrue($url->save(false));
	 
	    $v = $url->findByPk($url->id);
	   
	    $this->assertTrue($v instanceof Url);
	    $this->assertEquals(date('Y-m-d H:i:s'), $v->creado);
	    $this->assertTrue($url->delete());
    }
}