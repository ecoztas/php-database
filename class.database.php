<?php

/**
 * -----------------------------------------------------------------------------
 * @package   class.database.php
 * @author    ÖZTAŞ, Emre Can <me@emrecanoztas.com>
 * @copyright 2019 Open Source
 * @license   https://opensource.org/licenses/MIT  MIT License
 * @link      https://github.com/ecoztas/php-database
 * -----------------------------------------------------------------------------
 */
class Database
{
    public $hostname;
    public $username;
    public $password;
    public $dbname;
    public $charset;
    private $_connection;

    function __construct()
    {
        $this->hostname    = '';
        $this->username    = '';
        $this->password    = '';
        $this->dbname      = '';
        $this->charset     = 'utf-8';
        $this->_connection = null;
    }

    public function set_hostname($hostname = '')
    {
        !(empty($hostname)) ? $this->hostname = $hostname : $this->hostname = $this->hostname;
    }

    public function set_username($username = '')
    {
        !(empty($username)) ? $this->username = $username : $this->username = $this->username;
    }

    public function set_password($password = '')
    {
        !(empty($password)) ? $this->password = $password : $this->password = $this->password;
    }

    public function set_dbname($dbname = '')
    {
        !(empty($dbname)) ? $this->dbname = $dbname : $this->dbname = $this->dbname;
    }

    public function set_charset($charset = 'utf-8')
    {
        !(empty($charset)) ? $this->charset = $charset : $this->charset = $this->charset;
    }

    public function get_hostname()
    {
        return ($this->hostname);
    }

    public function get_username()
    {
        return ($this->username);
    }

    public function get_password()
    {
        return ($this->password);
    }

    public function get_dbname()
    {
        return ($this->dbname);
    }

    public function get_charset()
    {
        return ($this->charset);
    }

    public function the_connection($hostname = '', $username, $password = '', $dbname = '', $charset = 'utf-8')
    {
        !(empty($hostname)) ? $this->hostname = $hostname : $this->hostname = $this->hostname;
        !(empty($username)) ? $this->username = $username : $this->username = $this->username;
        !(empty($password)) ? $this->password = $password : $this->password = $this->password;
        !(empty($dbname)) ? $this->dbname = $dbname : $this->dbname = $this->dbname;
        !(empty($charset)) ? $this->charset = $charset : $this->charset = $this->charset;

        if (!empty($this->hostname) && !empty($this->username) && !empty($this->password)) {
            if (!empty($dbname)) {
                $this->_connection = @mysqli_connect($this->hostname, $this->username, $this->password, $this->dbname);
            } else {
                $this->_connection = @mysqli_connect($this->hostname, $this->username, $this->password);
            }
        }

        if (mysqli_connect_errno()) {
            exit('Database connection failed! ' . mysqli_connect_errno());
        } else {
            if (!empty($this->charset)) {
                @mysqli_set_charset($this->_connection, $this->charset);
                @mysqli_query($this->_connection, "SET NAMES " . $this->charset);
            }
            return (true);
        }
    }

    public function add_record($table = '', $record = array())
    {
        !($this->_connection) ? exit('Connection failed!') : true;
        if (!empty($table) && !empty($record)) {
            $column = implode(', ', array_keys($record));
            $data   = '\'' . implode('\',' . '\'', array_values($record)) . '\'';
            $query  = "INSERT INTO $table ($column) VALUES($data)";

            return (mysqli_query($this->_connection, $query) ? true : false);
        } else {
            return (false);
        }
    }

    public function select_record($table = '', $columns = array())
    {
        !($this->_connection) ? exit('Connection failed!') : true;
        if (!empty($table) && !empty($columns)) {
            $columns = implode(', ', $columns);
            $query  = "SELECT $columns FROM $table";

            return (mysqli_query($this->_connection, $query) ? mysqli_query($this->_connection, $query) : null);
        }
    }

    public function select_where_record($table = '', $columns = '', $conditions = '')
    {
        # code...
    }
}
