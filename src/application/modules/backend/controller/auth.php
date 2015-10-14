<?php

class Admin_AuthController extends Zend_Controller_Action
{

    protected $_em;

    public function init()
    {
        $this->view->pageId = 'auth';
        $this->_em = Zend_Registry::get('em');
    }

    public function loginAction()
    {
        $this->_helper->layout()->disableLayout(true);

		$form = new MyApp_Form_Auth_SignIn();

		if ($this->getRequest()->isPost()) {

			$data = $this->getRequest()->getPost();

			if ($form->isValid($data)) {

                $adapter  = new Zend_Doctrine_Auth_Adapter($this->_em);
                $adapter->setTableName('usuarios')
                        ->setIdentityColumn('usuario')
                        ->setCredentialColumn('password')
                        ->setIdentity($data['usuario'])
                        ->setCredential($data['password']);

                $result = Zend_Auth::getInstance()->authenticate($adapter);

                if ($result->isValid()) {
                    $storage = $adapter->getResultRowObject(array('id', 'usuario', 'nombre', 'apellido', 'rol'));
                    $auth = new MyApp_Models_Auth($storage);
                    Zend_Auth::getInstance()->getStorage()->write($auth);
                    return $this->_redirect('/admin');
                }
			}

		}
		
		$this->view->form = $form;
    }
	
	public function logoutAction()
	{
        Zend_Auth::getInstance()->getStorage()->clear();
        return $this->_redirect('/admin');
	}

}



