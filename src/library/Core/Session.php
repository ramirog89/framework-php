<?php

class Session
{

    protected $_sessions;

    public function __construct()
    {}

    public static function set($id)
    {
        $this->_sessions[$id] = $_SESSION[$id];
    }

    public static function start()
    {
        session_start();
    }

    public static function get($id)
    {
        return (isset($this->_sessions[$id])) ? $this->_sessions[$id] : null;
    }

    public static function destroy()
    {
        unset($_sessions, $_SESSION);
        session_destroy();
    } 

}
