<?php
namespace Core;
//Aca es donde zend tiene los predispatch. y demases..?... que los ejecuta con el bootstarp .
// y el viewwww.. jojo
abstract class ControllerAction
{

	protected $_view;

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

