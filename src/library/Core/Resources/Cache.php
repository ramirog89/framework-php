<?php

class Cache
{

    const DEFAULT_PORT = '11211';
    const DEFAULT_HOST = 'localhost';

    private $_settings = array(
        'host' => null,
        'port' => null
    );

    private $_baseUrl = 'localhost/';

    private $_endpoint;

    private $_cnx;

    private $_content;

    public function __construct(
        $host,
        $port
    )
    {
		$this->_settings['host'] = (!is_null($host)) ? $host : self::DEFAULT_HOST;
		$this->_settings['port'] = (!is_null($port)) ? $port : self::DEFAULT_PORT;

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

        $this->_content = $this->_cnx->get($uri);

        if ($this->_content == false) {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $uri);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); 
            $this->_content = curl_exec($ch);
            curl_close($ch);

            $this->_cnx->set($this->_endpoint, $this->_content);
        }

        return $this;
    }

    private function _memcacheConnect()
    {
        $this->_cnx = new Memcache;

        $this->_cnx->connect(
            $this->_settings['host'],
            $this->_settings['port']
        ) or die ('Could not connect to memcache server');

        return $this;
    }

}

