<?php

/**
 * @uses      Initialize application framework
 * @category  Core
 * @package   Core\Application
 * @author    Ramiro Gonzalez
 * @version   1.0
 * @copyright dev@devartdesign.com
 *****************************************************/

namespace Core;
// Esto seria un Facade de la aplicacion?.. ponele..
class Application
{
	protected $_front;

    public function __construct(){}
	
	public function init()
	{
		$this->_front  = \Core\Front::getInstance();
		return $this;
	}

    // aca esta el tema del loadConfig..
    // Que se lo puede pasar al front, no?.. q se io..

    public function setConfig()
    {
    }

    public function getConfig()
    {
    }
	
	public function start()
	{
		$this->_front->setRouter( new \Core\Route($_SERVER) )
			         ->execute();
	}

}
