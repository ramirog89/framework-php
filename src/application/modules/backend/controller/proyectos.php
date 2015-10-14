<?php
namespace Backend\Controller;

class Proyectos extends \Core\ControllerAction
{

	public function indexAction()
	{
    /*
        $catalogos = $this->_repo->findBy(array(), array('id' => 'DESC'));

        $this->view->headLink()->appendStylesheet('/media/site/assets/css/dataTables.css')
                               ->appendStylesheet('/media/site/assets/css/jquery-ui.css')
                               ->appendStylesheet('/media/site/assets/css/multi-select.css');
        
        $this->view->headScript()
                                 ->appendFile('/media/site/assets/js/jquery.dataTables.js')
                                 ->appendFile('/media/site/assets/js/TableTools.js')
                                 ->appendFile('/media/site/assets/js/jquery.editable.js')
                                 ->appendFile('/media/site/assets/js/dataTables.editor.js')
                                 ->appendFile('/media/site/assets/js/dataTables.editor.bootstrap.js')
                                 ->appendFile('/media/site/assets/js/dataTables.bootstrap.js')
                                 ->appendFile('/media/site/assets/js/jquery.multi-select.min.js')
                                 ->appendFile('/media/site/assets/js/jquery.quicksearch.min.js')
                                 ->appendFile('/media/site/assets/js/catalogo.js');

        $this->view->catalogos  = $catalogos;

        $ar = array();

        // poner ArticuloRepositorio y hacer esto en el Repo y no en la entidad utilizando el namespace de jsonSerialize..
        $articulos = $this->_em->getRepository('Entity\Articulo')->findBy(array(), array('id' => 'DESC'));
        foreach ($articulos as $a) {
            $ar[$a->getId()] = $a->jsonSerialize();
        }

        $this->view->articulos = json_encode($ar);
        $this->view->artis     = $articulos;

        // Hacer un get Campanas que devueelva simplemente los articulos ID y devuelva un array de eso
        $this->view->catalogoArticulos = $this->getCatalogoArticulos($catalogos);
        */
    }

    public function getCatalogoArticulos($catalogos)
    {
        $articulos = array();

        foreach ($catalogos as $catalogo) {
            $ar = $catalogo->getArticulos()->toArray();
            $cid = $catalogo->getId();

            $articulos[$cid] = array();
            foreach ($ar as $a) {
                $articulos[$cid][] = $a->getId();
            }
        }

        return json_encode($articulos);
    }


}
