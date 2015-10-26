<?php

class Translator
{

	const DEFAULT_LANGUAGE = "es";
	
	protected $lang;
	
	protected $keyMap;

	protected $path = "/langs/";
	
	public function __construct($lang = null)
	{
		$this->lang = (!is_null($lang)) ? $lang : self::DEFAULT_LANGUAGE;
		$this->setContent();
	}
	
	public function setContent()
	{
		$langFile = __DIR__ . $this->path . $this->lang . ".php";
		
		if (!file_exists($langFile)) 
			die ("El archivo " . $langFile . " no existe.");

		$this->keyMap = include($langFile);
	}
	
	public function getLang()
	{
		return $this->lang;		
	}
	
	public function getKeyMap()
	{
			return $this->keyMap;
	}
	
	public function translate($key) 
	{
		return $this->keyMap[$key];
	}

	public function setPath($path) 
	{
		$this->path = $path;
	}
	
	public function getPath()
	{
		return $this->path;
	}
	
}