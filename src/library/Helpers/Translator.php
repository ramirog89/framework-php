<?php
namespace Core;

class Translator
{

    // Current language setted
    protected $_lang = null;

	public function __construct($key = null)
	{
        $bootstrap   = \Core\Front::getBootstrap();
        $this->_lang = $bootstrap->getResource('language');

        //$this->get($key);
	}
	
	public function get($key) 
	{
        $value = $this->_lang->keyMap[$key];
		return (isset($value)) ? $value : '';
	}
	
}
