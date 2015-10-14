<?php
namespace Frontend\ViewHelper;


class verListaImagenesDeCarpeta extends \Core\ViewHelper
{
    private $_contentPath = PUBLIC_PATH . 'assets/contenido/';

    private $_directoryContent;

    private $_nameDir;

    private $_publicPath = '/public/assets/contenido/';

    public function __construct($pathDir)
    {
        // if (file_exists($pathDir)) ...
        $this->_nameDir = $pathDir[0];
        $this->_directoryContent = $this->_read($pathDir[0]);
    }

    public function getFiltros()
    {
        $items = "";
        foreach ($this->_directoryContent as $carpeta => $archivos) {
            $items .= '<li>'
                   .  '<a data-filter="' . $carpeta . '" href="#">' . $carpeta . '</a>'
                   .  '</li>';
        }

        $filtros =<<<HTML
            <ul class="filters">
                <li>
                    <a data-filter="*" href="#" class="active">Todos</a>
                </li>
                {$items}
            </ul>
HTML;

        return $filtros;
    }

    public function getLista()
    {
        $elementItems = "";

        foreach ($this->_directoryContent as $carpeta => $archivos) {
           foreach ($archivos as $index => $archivo) {
                $file = $this->_publicPath . $this->_nameDir . "/$carpeta/$archivo";

                $elementItems .= '<div class="imagen element-item ' . $carpeta . ' isotope">'
                              .  '<a href="' . $file . '" data-lightbox="image-' . $index . '" data-title="' . $archivo . '">'
                              .  '<img src="' . $file . '" />'
                              .  '</a>'
                              .  '<div class="caracteristicas">'
                              .  '    <h3>' . $archivo . '</h3>'
                              .  '    <p>descripcion</p>'
                              .  '</div>'
                              .  '</div>';
            }
        }

        return $elementItems;
    }

    private function _read($path) {
        $fullPath   = $this->_contentPath . $path;
        $resources  = scandir($fullPath);

        $files = array();

        foreach ($resources as $resource) {
            if ($resource != "." && $resource != ".." && $resource != "thumbs") {
                $resourceDir = $fullPath . '/'. $resource;
                if (is_dir($resourceDir)) {
                    $files[$resource] = $this->_read($path . '/' . $resource);
                } else {
                    $files[] = $resource;
                }
            }
        }

        return $files;
    }

}

?>
