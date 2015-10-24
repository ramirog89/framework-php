<?php

return array(
    'language' => array(
    	'path' => 'lang/',
    	'lang' => 'es'
    ),

    'database' => array(
    	'local' => array(
    		'adapter'  => 'Mysql',
    		'hostname' => 'localhost',
    		'username' => 'root',
    		'password' => '',
    		'database' => 'testfw'
    	)
    ),

    'cache' => array(
    	'adapter' => 'Memcache',
    	'host'    => 'localhost',
    	'port'    => '11211'
    ),

    'acl' => array()
);

?>
