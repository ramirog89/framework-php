<?php

class Language
{

	const DEFAULT_LANGUAGE = "es";

	const DEFAULT_LANGUAGE_PATH = "data/languages/";
	
	protected $lang;
	
	protected $keyMap;

	protected $path = "/langs/";
	
	public function __construct
	(
		$path = null,
		$lang = null
	)
	{
		$this->path = (!is_null($path)) ? $path : self::DEFAULT_LANGUAGE_PATH;
		$this->lang = (!is_null($lang)) ? $lang : self::DEFAULT_LANGUAGE;
		$this->setContent();
	}
	
	public function setContent()
	{
		$langFile = APPLICATION_PATH 
				  . $this->path 
				  . $this->lang 
				  . ".php";
		
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