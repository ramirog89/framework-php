<?php
namespace Frontend\Controller;

class Index extends \Core\ControllerAction
{
	
	public function indexAction($args)
	{
		// Load database Object
        $database = $this->_front
        				 ->getBootstrap()
        				 ->getResource('sqlite');

        // Execute query
        $rs = $database->query("SELECT * FROM productoAlbum");

        // Fetch data and injected on the view
        $this->_view->_ultimos = $rs->fetchAll();
	}
	
}
