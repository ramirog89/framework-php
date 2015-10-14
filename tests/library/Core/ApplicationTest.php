<?php
require_once __DIR__ . '/../../../src/library/Core/Application.php';
require_once __DIR__ . '/../../../src/library/Core/Front.php';
require_once __DIR__ . '/../../../src/library/Core/Bootstrap.php';
require_once __DIR__ . '/../../../src/library/Core/Route.php';


class ApplicationTest extends PHPUnit_Framework_TestCase
{

    protected $_app;

    public function setUp()
    {
        $this->_app = new Core\Application();
    }

    public function testConstructor()
    {
        $this->assertInstanceOf('Core\Application', new Core\Application());
    }

    public function testInit()
    {
        $this->assertInstanceOf('Core\Application', $this->_app->init());
    }

    public function testStart()
    {
        $this->assertInstanceOf('Core\Application', $this->_app->init());
    }

}
?>
