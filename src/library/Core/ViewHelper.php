<?php
namespace Core;

class ViewHelper extends View
{

    protected $_parentView;

    protected $_vars = array();

    protected $_defaultPath = FRONTEND_PATH . 'views/helpers';

    public function __construct()
    {}

    // El helper esta bindeado a una vista.
    public function setView($view)
    {}

}

?>
