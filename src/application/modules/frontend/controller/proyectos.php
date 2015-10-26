<?php
namespace Frontend\Controller;

class Proyectos extends \Core\ControllerAction
{

    const FOLDER_CONTENT = 'proyectos';
	
	public function indexAction($args)
	{
        $this->_view->imagesDirectory = self::FOLDER_CONTENT;
	}
}
