<?php
namespace Core;

class Bootstrap
{

	protected $_configPath = APPLICATION_PATH . 'config/';
	
	protected $_resources = array();

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
			foreach ($resources as $resource) {
				$this->_resources[$resource] = new $resource();
			}
		}
	}

	protected function _loadConfig()
	{
		$settingsFile = $this->_configPath . 'settings.php';
		if (file_exists($settingsFile))
			return file_get_contents($settingsFile);
		else
			die('No existe el archivo settings.php');
	}

}
