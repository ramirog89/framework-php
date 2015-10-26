<?php

class Sqlite
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

        $this->_queryResource = sqlite_query(
            $this->_cnx, $this->_sql
        );

        if ($query_error)
            die("Error: " . $query_error);

        if (!$this->_queryResource)
            die("No se pudo ejecutar la consulta");

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

        while ($rs = sqlite_fetch_array($this->_queryResource)) {
            $result[$rs['column_name']] = $rs['data_type'];
        }

        return $result;
    }

    public function fetch()
    {
        $result = array();

        while ($row = sqlite_fetch_array($this->_queryResource)) {
            array_push($result, $row);
        }

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
        $this->_database = $databaseFile;
        $this->_cnx = sqlite_open($this->_database, 0666, $error);
        if (!$this->_cnx) {
            $error = (file_exists($this->_database)) ? "Impossible to open, check permissions" : "Impossible to create, check permissions";
            die($error);
        }
    }

}
?>
