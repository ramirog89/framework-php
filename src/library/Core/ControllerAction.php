<?php
namespace Core;

// Life cycle request? .. predispatch, dispatch, postdispatch.. kuak

abstract class ControllerAction
{

	protected $_view;

    protected $_front;

    public function __construct($front)
    {
        $this->_front = $front;
    }

	public function setView(\Core\View $view)
	{
		$this->_view = $view;
		return $this;
	}
	
	public function render()
	{
		$this->_view->render();
	}

}

