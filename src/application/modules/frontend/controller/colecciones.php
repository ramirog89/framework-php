<?php
namespace Frontend\Controller;

class Colecciones extends \Core\ControllerAction
{
	
    const FOLDER_CONTENT = 'colecciones';

	public function indexAction($args)
	{
        $this->_view->appendStylesheet("/public/assets/css/bootstrap.css")
                    ->appendStylesheet("/public/assets/css/estilo.css")
  		            ->appendStylesheet("/public/assets/css/nivo-slider.css")
        		    ->appendStylesheet("/public/assets/css/lightbox.css")
                    ->appendStylesheet("/public/assets/css/screen.css");
                

        $this->_view->appendJavascript("/public/assets/js/jquery.min.js")
                    ->appendJavascript("/public/assets/js/jquery.nivo.slider.js")
                    ->appendJavascript("/public/assets/js/lightbox.min.js")
                    ->appendJavascript("/public/assets/js/isotope.min.js")
                    ->appendJavascript("/public/assets/js/index.js");


        $this->_view->imagesDirectory = self::FOLDER_CONTENT;
	}
	
}
