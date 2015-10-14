<?php 
namespace Core;

class Route
{

	const DEFAULT_MODULE = "frontend";

	protected $_namespace;

	protected $_module;

	protected $_controller;
	
	protected $_action;
	
	protected $_params = array();

    // Ver en donde tendria que estar el tema del Access List
	public function __construct(array $SERVER)
	{        
        $uri = $SERVER['REQUEST_URI'];
        $module = self::DEFAULT_MODULE;
        $namespace = 'Frontend';

        if ($uri == '/') {
            $controller = 'Index';
            $action     = 'index';
            $params     = array();
        } else {
            $argv = explode('/', $SERVER['REQUEST_URI']);

            $actionIndex = 2;
            $controller = $argv[1];

            if ($controller == 'admin') {
            	$module 	 = 'backend';
	            $controller  = (isset($argv[$actionIndex])) ? $argv[$actionIndex] : 'index';
            	$namespace   = 'Backend';
            	$actionIndex = 3;
            }

            $action     = (isset($argv[$actionIndex])) ? $argv[$actionIndex] : 'index';
            $controller = str_replace("-", "", $controller);

            unset($argv[0], $argv[1], $argv[2]);
            unset($argv[$actionIndex]);
            $params     = $argv;
        }

        $this->setNamespace($namespace);
        $this->setModule($module);
        $this->setController($controller);
        $this->setAction($action);
        $this->setParams($params);

		return $this;
	}
	
	public function setParams(array $params)
	{	
		$this->_params = $params;
	}
	
	public function getParams()
	{
		return $this->_params;
	}
	
	public function getParam($param)
	{
		return (isset($this->_params[$param])) ?: null;
	}
	
	public function setController($controller)
	{
		$this->_controller = $controller;
	}

	public function setAction($action)
	{
		$this->_action = $action;
	}
	
	public function getController()
	{
		return $this->_controller;
	}

	public function getAction()
	{
		return $this->_action;
	}

	public function setModule($path)
	{
		$this->_module = $path;
	}

	public function getModule()
	{
		return $this->_module;
	}

	public function setNamespace($namespace)
	{	
		$this->_namespace = $namespace;
	}
	
	public function getNamespace()
	{
		return $this->_namespace;
	}

}
