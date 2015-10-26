<?php
namespace Frontend\Controller;

class Index extends \Core\ControllerAction
{
	
	public function indexAction($args)
	{
		$this->_view->a = 'pepe';

        $database = $this->_front->getBootstrap()->getResource('database');

        $albums = $database->query("select aC.*, c.* from catalogo c, albumCatalogo aC WHERE c.id_catalogo = aC.id_catalogo");

    echo "<pre>";
        var_dump($albums->fetch());
    exit;


        $ultimosProductos = $database->query('SELECT * FROM productos');


	}
	
}
