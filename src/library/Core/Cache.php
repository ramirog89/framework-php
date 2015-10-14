<?php

class Cache
{
    
    private $_host    = 'local';

    private $_baseUrl = 'http://noticias.mtvla.com/feeds/';

    private $_endpoint;

    private $_memcache;

    private $_settings = array(
        'memcache' => array(
            'local' => array(
                'host' => 'localhost',
                'port' => '11211'
            )
        )
    );

    private $_content;

    public function __construct()
    {
        $this->_memcacheConnect();
    }

    public function getLastArticles() {
        return $this->setEndpoint('latest-articles-paginated?page=1')
                    ->_doRequest()
                    ->_sendResponse();
    }

    public function setEndpoint($endpoint)
    {
        $this->_endpoint = $endpoint;
        return $this;
    }

    public function getEndpoint()
    {
        return $this->_endpoint;
    }

    private function _sendResponse()
    {
        return json_decode($this->_content);
    }

    private function _doRequest()
    {
        $uri = $this->_baseUrl . $this->_endpoint;

        $this->_content = $this->_memcache->get($uri);

        if ($this->_content == false) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $uri);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            $this->_content = curl_exec($ch);
            curl_close($ch);

            $this->_memcache->set($this->_endpoint, $this->_content);
        }

        return $this;
    }

    private function _memcacheConnect()
    {
        $this->_memcache = new Memcache;

        $this->_memcache->connect(
            $this->_settings['memcache'][$this->_host]['host'],
            $this->_settings['memcache'][$this->_host]['port']
        ) or die ('Could not connect to memcache server');

        return $this;
    }

}

echo "<pre>";
$feed = new Feed();
var_dump($feed);
