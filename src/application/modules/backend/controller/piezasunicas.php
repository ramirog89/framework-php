<?php
namespace Backend\Controller;

class PiezasUnicas extends \Core\ControllerAction
{
    private $_em;

    private $_repo;

	public function indexAction()
	{
/*
        $this->view->headLink()->appendStylesheet('/media/site/assets/css/dataTables.css')
                               ->appendStylesheet('/media/site/assets/css/jquery-ui.css')
                               ->appendStylesheet('/media/site/js/jquery/jquery-fileupload/css/jquery.fileupload-ui.css');
        
        $this->view->headScript()
                                 ->appendFile('/media/site/assets/js/jquery.dataTables.js')
                                 ->appendFile('/media/site/assets/js/TableTools.js')
                                 ->appendFile('/media/site/assets/js/jquery.editable.js')
                                 ->appendFile('/media/site/assets/js/dataTables.editor.js')
                                 ->appendFile('/media/site/assets/js/dataTables.editor.bootstrap.js')
                                 ->appendFile('/media/site/assets/js/dataTables.bootstrap.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/vendor/jquery.ui.widget.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/tmpl.min.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/load-image.min.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/canvas-to-blob.min.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/jquery.blueimp-gallery.min.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/jquery.fileupload.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/jquery.fileupload-process.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/jquery.fileupload-image.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/jquery.fileupload-audio.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/jquery.fileupload-video.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/jquery.fileupload-validate.js')
                                 ->appendFile('/media/site/js/jquery/jquery-fileupload/js/jquery.fileupload-ui.js')
                                 ->appendFile('/media/site/assets/js/campana.js');

        $this->view->campanas  = $campanas;

        $this->view->campanaArticulos = json_encode($this->getCampanaArticulos($campanas));
    */
    }

    public function getCampanaArticulos($campanas)
    {
        $articulos = array();

        foreach ($campanas as $campana) {
            $cid = $campana->getId();
            $ar = $campana->getArticulos()->toArray();

            foreach ($ar as $i => $a) {
                $orden = $a->getOrden();
                if ($orden == 0 && $i > 0) {
                    $orden = $i;
                }

                $articulos[$cid][$orden]['id'] = $a->getId();
                $articulos[$cid][$orden]['imagen'] = $a->getImagen();
                $articulos[$cid][$orden]['orden'] = $orden;
                $articulos[$cid][$orden]['campana'] = $a->getCampana()->getId();
            }
        }

        return $articulos;
    }

}
