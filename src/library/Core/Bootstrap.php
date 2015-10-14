<?php
namespace Core;

class Bootstrap
{
	
	protected $_resources = array();

	public function __construct(Array $resources = array())
	{
		$this->_initialize($resources);
	}

	public function addResource($resource)
	{
		array_push($resource, $this->_resources);
	}

	public function getResource($resource)
	{
		return $this->_resources[$resource];
	}

	protected function _initialize($resources)
	{
		if (!empty($resources)) {
			foreach ($resources as $resource) {
				$this->_resources[$resource] = new $resource();
			}
		}
	}

}
