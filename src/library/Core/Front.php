<?php
namespace Core;

// Esto es el front controller para un MVC para API REST:. mio obvio
class Front
{
	protected static $_instance = null;

	protected $_route;

	static protected $_bootstrap;

	/** Aca deberia ir el controller, action y params **/
	
	private function __construct() 
	{
		self::$_bootstrap = new \Core\Bootstrap(); // aca va elconfig?
	}
	
	private function __clone(){}
	
	public static function getInstance()
	{
		if (!self::$_instance instanceof Front) {
			self::$_instance = new Front;
		}
		return self::$_instance;	
	}

    // Tiene que haber un SetPaths.. algo asi del Core..
	
    // El router, routea.. no hace lo del params,action,controller.. solo routea
	public function setRouter(Route $router)
	{
		$this->_route = $router;
		return $this;
	}
	
	public function getRouter()
	{
		return $this->_route;
	}

    static public function getBootstrap()
    {
        return self::$_bootstrap;
    }

    static public function getStaticBootstrap()
    {
        return $this->_bootstrap;
    }

    // aca lo que debe ejecutarse es el route... que rutea.. kuak
    // con la data del front 
	public function execute()
	{
		// Defino si es modulo frontend o backend(admin)
		$defaultModule = 'modules/' . $this->_route->getModule() . '/';

		// Busco e instancio el controller
        // Tengo que llamarlo con el autoload amgueo..
        $controllerName   = strtolower($this->_route->getController());
		$controllerNSPath = $this->_route->getNamespace() . '\controller\\' . $controllerName;
        $controllerPath   = FRONTEND_PATH . 'controller/' . $controllerName . '.php';

        if (!file_exists($controllerPath)) {
            die('No existe este archivo');
        }
        
        include_once(FRONTEND_PATH . 'controller/' . $controllerName . '.php');

        if (!class_exists(ucfirst($controllerNSPath)))  {
            die('Existe el archivo pero la clase no corresponde');
        }

        // Existe el controller entonces lo instanciamos
		$controller = new $controllerNSPath($this);

		// Defino el action
        $routeAction = strtolower($this->_route->getAction());
        $controllerAction = $routeAction . 'Action';

        // Defino el ViewController
		$pathToView = APPLICATION_PATH
					. $defaultModule
					. 'views'
					. DIRECTORY_SEPARATOR
					. $controllerName
					. DIRECTORY_SEPARATOR
					. $routeAction
					. '.phtml';

		$view = new \Core\View( $pathToView );
		
        // Instancio el Layout del Modulo e inyecto la vista pedida
		$layout = new \Core\Layout($defaultModule);
        $layout->setContent($view);

		if (in_array($controllerAction, get_class_methods($controller))) {
			$controller->setView($view);
			
			// El get params puede ser algo como Get y REquest.. ponele.. que extiende de API REST pero veremos.
			call_user_func_array(
				array($controller, $controllerAction),
				array($this->_route->getParams())
			);
			
			$layout->render();
		} else {
            // no existe el action pedido..
        }
	}

}
