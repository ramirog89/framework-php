<?php
namespace Backend\Controller;

class Colecciones extends \Core\ControllerAction
{

	public function indexAction()
	{
		// Load database Object
        $database = $this->_front
        				 ->getBootstrap()
        				 ->getResource('sqlite');

        // Execute query
        $rs = $database->query("
        	SELECT aC.* FROM catalogo c, albumCatalogo aC
        	WHERE c.id_catalogo = aC.id_catalogo
        	AND c.catalogo = :catalogo",
        	array(':catalogo' => 'colecciones')
        );

        // Fetch data and inject it on the view
        $this->_view->albums = $rs->fetchAll();
    }

}
