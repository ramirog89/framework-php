<?php
namespace Core;

class Bootstrap
{

	protected $_configPath = APPLICATION_PATH . 'config/';

    protected $_path       = LIBRARY_PATH . 'Core/Resources/';
	
	protected $_resources  = array();

	public function __construct()
	{
		$this->_init();
	}

	public function addResource($resource)
	{
		array_push($resource, $this->_resources);
	}

	public function getResource($resource)
	{
		return $this->_resources[$resource];
	}

	protected function _init()
	{
		$resources = $this->_loadConfig();

		if (!empty($resources)) {
			foreach ($resources as $resource => $params) {
                $absResourcePath = $this->_path
                                 . ucfirst($resource) 
                                 . '.php';

                $newResource     = include_once($absResourcePath); 

                // Tengo que configurar los Adaptadores..
                // Para el database y el cache
                $reflection = new \ReflectionClass($resource);
				$this->_resources[$resource] = $reflection->newInstanceArgs($params);
			}
		}
	}

	protected function _loadConfig()
	{
		$settingsFile = $this->_configPath . 'settings.php';
		if (file_exists($settingsFile))
			return include_once($settingsFile);
		else
			die('No existe el archivo settings.php');
	}

}
