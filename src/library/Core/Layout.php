<?php
namespace Core;

class Layout extends View
{

    const DEFAULT_PATH = 'views/layouts/layout.phtml';

    protected $_content;

    public function __construct($module)
    {
        $layoutPath = APPLICATION_PATH
                    . $module
                    . self::DEFAULT_PATH;
        parent::__construct($layoutPath);
    }

    public function setContent(\Core\View $content)
    {
        $this->_content = $content;
    }

    public function getContent()
    {
        return $this->_content->render();
    }

    public function headContent()
    {
        return $this->_content->getStylesheets();
    }

    public function footerContent()
    {
        return $this->_content->getJavascripts();
    }

}


