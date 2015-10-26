<?php
namespace Core;

abstract class ViewAbstract
{
    protected $_helpers = array();

    public function __construct()
    {

        $commonHelpersPath = LIBRARY_PATH . 'Helpers/';
        $helpers = dir($commonHelpersPath);


        while (false !== ($helper = $helpers->read())) {
            if (substr($helper, 0, 1) != '.') 
               $this->_registerHelper($helper, $helpers->path);
        }

        $helpers->close();
    }

    protected function _loadHelper($helper, $args)
    {
        return $this->_helpers[$helper];
    }

    protected function _registerHelper($helper, $path = null)
    {
        $pathToHelper = FRONTEND_PATH . 'views/helpers/' . $helper . '.php';
        $helperClassName = '\Frontend\ViewHelper\\' . $helper;

        if(!is_null($path)) {
            $helperName = lcfirst(str_replace('.php', '', $helper));
            $pathToHelper = $path . $helper;
            $helperClassName = '\Core\\' . ucfirst($helperName);
        }

        if (!file_exists($pathToHelper))
            die ('No encontre el helper ' . $pathToHelper);

        include_once($pathToHelper);

        $this->_helpers[$helperName] = new $helperClassName;
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

    public function getHelper($helper)
    {
        return $this->_helpers[$helper];
    }

}
