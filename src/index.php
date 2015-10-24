<?php
define('APPLICATION_PATH', __DIR__ . '/application/');
define('LIBRARY_PATH', __DIR__ . '/library/');
define('PUBLIC_PATH', __DIR__ . '/public/');
define('FRONTEND_PATH', APPLICATION_PATH . 'modules/frontend/');
define('BACKEND_PATH', APPLICATION_PATH . 'modules/backend/');

// Get autoload Zend/Symfony Standard PS-4
require_once LIBRARY_PATH . 'Core/Autoload.php';
// Autoload Instance
$autoload = new Psr4AutoloaderClass();
// Load Needed Namespaces for the application
$autoload->addNamespace('Core', LIBRARY_PATH . 'Core')
         ->addNamespace('Application', APPLICATION_PATH)
         ->addNamespace('Backend', BACKEND_PATH)
         ->addNamespace('Frontend', FRONTEND_PATH);

$autoload->register();

// estaria bueno definir las routes aca y el acces list?

// onda.. Access list y se lo inyecto a la aplicacion.
//$acl = new Acl();
//$acl->addRole();

// lo mismo con las routes..
// las routes es tambien para forwardear un 404, un 500 etc..

// Create the Application via Namespace..
$api = new Core\Application();
$api->init()
	->start();
?>
