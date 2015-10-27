<?php
/** 
 * Debera haber un ResourceAbstract? 			*
 * algo asi como : 								*
 * class Translator extends ResourceAbstract	*
 **/

class Language
{

	const DEFAULT_LANGUAGE = "es";

    const DEFAULT_LANGUAGES_PATH = "data/languages/";
	
	protected $lang;
	
	public $keyMap = array();

	protected $path = null;

    protected $fileExt = '.php';
	
	public function __construct
    (
        $path = null,
        $lang = null
    )
	{
		$this->path = (!is_null($path)) ? $path : self::DEFAULT_LANGUAGES_PATH;
		$this->lang = (!is_null($lang)) ? $lang : self::DEFAULT_LANGUAGE;

		$this->setContent();
	}
	
	public function setContent()
	{
		$langFile = APPLICATION_PATH 
                  . $this->path 
                  . $this->lang 
                  . $this->fileExt;
		
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
        return isset($this->keyMap[$key]) ? $this->keyMap[$key] : '';
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

?>
