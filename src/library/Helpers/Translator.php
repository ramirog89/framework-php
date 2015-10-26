<?php
namespace Core;

class Translator
{

    // Current language setted
    protected $_lang = null;

	public function __construct()
	{
        $bootstrap   = \Core\Front::getBootstrap();
        $this->_lang = $bootstrap->getResource('language');
	}
	
	public function get($key) 
	{
        $value = $this->_lang->translate($key);
		return (isset($value)) ? $value : '';
	}
	
}
