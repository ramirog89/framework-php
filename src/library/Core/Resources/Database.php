<?php

class Database
{

    protected $_cnx;

    protected $_database;

    protected $_result;

    protected $_queryResource;

    protected $_sql;

    public function __construct($config)
    {
        $this->_connect(
            $config['hostname'], 
            $config['username'], 
            $config['password'], 
            $config['database']
        );
    }

    public function query($sql = null)
    {
        if (is_null($sql)) 
            die('Debe ingresar una consulta SQL');

        $this->_sql = $sql;

        $this->_queryResource = mysqli_query(
            $this->_cnx,
            $this->_sql
        );
        return $this;
    }


    public function getSchema()
    {
        $tables = $this->_getTables();
        $schemaTables = array();

        foreach ($tables as $table) {
            $schemaTables[$table]   = $this->_getTableSchema( $table );
        }

        return $schemaTables;
    }

    public function createTable($table)
    {
        $this->_sql = 'CREATE TABLE ';
        return $this->_query();
    }

    public function alterTable()
    {}

    private function _getTables()
    {
        $this->_sql = 'show tables';
        return $this->_query()
                    ->_fetch();
    }

    private function _getTableSchema($table)
    {
        $this->_sql = "SELECT column_name,data_type 
                FROM information_schema.columns 
                WHERE table_schema = '" . $this->_database . "'
                AND   table_name   = '" . $table . "'
                ORDER BY column_name";

        return $this->_query()
                    ->_fetchSchema();
    }

    private function _fetchSchema()
    {
        $result = array();

        while ($rs = mysqli_fetch_array($this->_queryResource)) {
            $result[$rs['column_name']] = $rs['data_type'];
        }

        return $result;
    }

    public function _fetch()
    {
        $result = array();

        while ($rs = mysql_fetch_array($this->_queryResource)) {
            array_push($result, $rs[0]);
        }

        return $result;
    }

    private function _connect
    (
        $host, 
        $user, 
        $pass, 
        $database
    ) 
    {
        $this->_database = $database;
        $this->_cnx = mysqli_connect($host, $user, $pass) or die('No se pudo conectar al host ' . $host);
        mysqli_select_db($this->_cnx, $database);
    }

}
?>
