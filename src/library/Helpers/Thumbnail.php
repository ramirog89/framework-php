<?php

set_time_limit(0);

class Thumbnail
{

	const PARENT_PATH = 'C:/Users/gonzaram/Desktop/';
	
	protected $_directoryPath;

	protected $_width;

	protected $_height;

	protected $_targetPath;

	protected $_result = array();

	protected $_files = array();

	public function __construct($path)
	{
		$this->_directoryPath = $path;
		$this->_readDir($this->_directoryPath);
		return $this;
	}

	public function generate()
	{
		if (!is_dir($this->_targetPath)) {
			mkdir($this->_targetPath, 0777);
		}

		foreach ($this->_files as $index => $file) {
			//This will set our output to 45% of the original size 
			//$size = 0.45; 
			//$thumb_w = $this->_width  * $size; 
			//$thumb_h = $this->_height * $size; 
			$fileLocation = self::PARENT_PATH 
						  . $this->_directoryPath
						  . DIRECTORY_SEPARATOR
						  . $file;

			// Setting the resize parameters 
			list($width, $height) = getimagesize($fileLocation); 

			// Calculate the new size
			$ratio1 = $width  / $this->_width;
			$ratio2 = $height / $this->_height;

			if($ratio1 > $ratio2) {
				$thumb_w = $this->_width;;
				$thumb_h = $height / $ratio1;
			} else {
				$thumb_h = $this->_height;
				$thumb_w = $width / $ratio2;
			}

			// Resizing the Image 
			$tn    = imagecreatetruecolor($thumb_w, $thumb_h); 
			$image = imagecreatefromjpeg($fileLocation); 
			imagecopyresampled($tn, $image, 0, 0, 0, 0, $thumb_w, $thumb_h, $width, $height); 

			// Outputting a .jpg, you can make this gif or png if you want 
			//notice we set the quality (third value) to 100 
			$destinationThumbnail = $this->_targetPath . 'thumb_' . $file;	
			imagejpeg($tn, $destinationThumbnail, 100); 

			imagedestroy($tn);
			imagedestroy($image);
		}
	}

	public function setWidth($width)
	{
		$this->_width = $width;
		return $this;
	}

	public function setHeight($height)
	{
		$this->_height = $height;
		return $this;
	}

	public function setTargetDirectory($target)
	{
		$this->_targetPath = $target;
		return $this;
	}

    private function _readDir($path) {
        $fullPath   = self::PARENT_PATH . $path;
        $resources  = scandir($fullPath);

        foreach ($resources as $resource) {
            if ($resource != "." && $resource != "..") {
                $resourceDir = $fullPath . '/'. $resource;
                if (is_dir($resourceDir)) {
                    $this->_files[$resource] = $this->_readDir($path . '/' . $resource);
                } else {
                    $this->_files[] = $resource;
                }
            }
        }

        return $this->_files;
    }

}

$thumbs = new Thumbnail('test');

$thumbs->setWidth(250)
	   ->setHeight(250)
	   ->generate();

echo "<pre>";
var_dump($thumbs);