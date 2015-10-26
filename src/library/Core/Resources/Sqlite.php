<?php

class Sqlite
{

    protected $_cnx;

    protected $_database;

    protected $_result;

    protected $_queryResource;

    protected $_sql;

    protected $_error;

    public function __construct($config)
    {
        $this->_connect(
            $config['hostname'], 
            $config['username'], 
            $config['password'], 
            $config['database']
        );
    }

    public function query
    (
        $sql = null, 
        $bindValues = array()
    )
    {
        if (is_null($sql)) 
            die('Debe ingresar una consulta SQL');

        $this->_sql = $sql;

        $this->_queryResource = $this->_cnx->prepare($sql);

        if (!empty($bindValues)) {
            foreach($bindValues as $key => $value) {
                $this->_queryResource->bindValue($key, $value);
            }
        }

        $this->_queryResource->execute();
      
        return $this;
    }

    public function getError()
    {
        return $this->_error;
    }

    public function fetchAll()
    {
        $result = $this->_queryResource->fetchAll();
        return $result;
    }

    private function _connect
    (
        $host, 
        $user, 
        $pass, 
        $databaseFile
    ) 
    {
        try {
            $this->_cnx = new PDO('sqlite:' . APPLICATION_PATH . $databaseFile);
            return true;
        } catch (PDOException $e) {
            $this->_error = "PDO database connection problem: " . $e->getMessage();
        } catch (Exception $e) {
            $this->_error = "General problem: " . $e->getMessage();
        }

        return false;
    }

}
?>
