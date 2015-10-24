<?php
namespace Core;

// Aca esta todo el tema del view helper, en el abstract
class View extends ViewAbstract
{

	protected $_path;

	protected $_body;

	protected $_vars = array();

    protected $_stylesheets = array();

    protected $_javascripts = array();

    protected $_helpers = array();
	
	public function __construct($path)
	{
        try {
            $this->_setFile($path);
        } catch (\Exception $e) {
            die($e->getMessage());
        }
	}
	
	public function __set($name, $value)
	{
		$this->_vars[$name] = $value;
	}
	
	public function __get($name)
	{
		return $this->_vars[$name];
	}
	
	public function render()
	{
			$this->_setBody();
			echo $this->_body;
	}

    // Cuando se llama a un objeto en la View,
    // se pide por el helper que este en La view
    public function __call($method, $args)
    {
        if (!isset($this->_helpers[$method])) {
            $this->_registerHelper($method);
        }

        return $this->_loadHelper($method, $args);
    }

    protected function _loadHelper($helper, $args)
    {
        $h = $this->_helpers[$helper];
        return new $h($args);
    }

    protected function _registerHelper($helper)
    {
        $pathToHelper = FRONTEND_PATH . 'views/helpers/' . $helper . '.php';
        include_once($pathToHelper);
        $helperClassName = '\Frontend\ViewHelper\\' . $helper;
        $this->_helpers[$helper] = $helperClassName;
    }

    public function getStylesheets()
    {
        $stylesheetList = '';
        foreach ($this->_stylesheets as $stylesheet) {
            $stylesheetList .= "<link rel=\"stylesheet\" href=\"" . $stylesheet . "\" />\n";
        }

        return $stylesheetList;
    }

    public function getJavascripts()
    {
        $javascriptList = '';
        foreach ($this->_javascripts as $javascript) {
            $javascriptList .= "<script language=\"javascript\" src=\"" . $javascript . "\"></script>\n";
        }

        return $javascriptList;
    }

    public function appendStylesheet($stylesheet)
    {
       array_push($this->_stylesheets, $stylesheet);
       return $this;
    }

    public function appendJavascript($javascript)
    {
       array_push($this->_javascripts, $javascript);
       return $this;
    }

    public function _setFile($path)
    {
        if (!file_exists($path)) {
            throw new \Exception('No se ha encontrado el archivo');
        }
        $this->_path = $path;
    }

	// Limpiamos el buffer al incluir el archivo... kuak.. jojo!
	private function _setBody()
	{
		ob_start();
		include_once $this->_path;
		$this->_body = ob_get_contents();
		ob_end_clean();
	}
	
}
