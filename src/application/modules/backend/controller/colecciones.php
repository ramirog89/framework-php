<?php
namespace Backend\Controller;

class Colecciones extends \Core\ControllerAction
{

	public function indexAction()
	{
        $this->_view->appendStylesheet('../public/assets/css/backend/dataTables.css')
                    ->appendStylesheet('../public/assets/css/backend/jquery-ui.css')
                    ->appendStylesheet('../public/assets/js/backend/jquery-fileupload/css/jquery.fileupload-ui.css');
        
        $this->_view->appendJavascript('../public/assets/js/backend/jquery.dataTables.js')
                    ->appendJavascript('../public/assets/js/backend/TableTools.js')
                    ->appendJavascript('../public/assets/js/backend/jquery.editable.js')
                    ->appendJavascript('../public/assets/js/backend/dataTables.editor.js')
                    ->appendJavascript('../public/assets/js/backend/dataTables.editor.bootstrap.js')
                    ->appendJavascript('../public/assets/js/backend/dataTables.bootstrap.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/vendor/jquery.ui.widget.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/tmpl.min.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/load-image.min.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/canvas-to-blob.min.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/jquery.blueimp-gallery.min.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/jquery.fileupload.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/jquery.fileupload-process.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/jquery.fileupload-image.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/jquery.fileupload-audio.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/jquery.fileupload-video.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/jquery.fileupload-validate.js')
                    ->appendJavascript('../public/assets/js/backend/jquery-fileupload/js/jquery.fileupload-ui.js')
                    ->appendJavascript('../public/assets/js/backend/articulos.js');

		// Load database Object
        $database = $this->_front
        				 ->getBootstrap()
        				 ->getResource('sqlite');

        // Execute query
        $rs = $database->query("
        	SELECT aC.* FROM catalogo c, albumCatalogo aC
        	WHERE c.id_catalogo = aC.id_catalogo
        	AND c.catalogo = :catalogo",
        	array(':catalogo' => 'colecciones')
        );

        // Fetch data and inject it on the view
        $this->_view->albums = $rs->fetchAll();
    }

}
