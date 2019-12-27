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

if (!class_exists('Database')) {

    class Database
    {
        // TODO: Create table
        // TODO: Drop table
        // TODO: Update table

        public $hostname;
        public $username;
        public $password;
        public $dbname;
        public $charset;
        private $_connection;

        function __construct()
        {
            $this->hostname = '';
            $this->username = '';
            $this->password = '';
            $this->dbname = '';
            $this->charset = 'utf-8';
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

        public function connect_database($hostname = '', $username = '', $password = '', $dbname = '', $charset = '')
        {
            !(empty($hostname)) ? $this->hostname = $hostname : $this->hostname = $this->hostname;
            !(empty($username)) ? $this->username = $username : $this->username = $this->username;
            !(empty($password)) ? $this->password = $password : $this->password = $this->password;
            !(empty($dbname)) ? $this->dbname = $dbname : $this->dbname = $this->dbname;
            !(empty($charset)) ? $this->charset = $charset : $this->charset = $this->charset;

            $this->_connection = @mysqli_connect($this->hostname, $this->username, $this->password);

            if (mysqli_connect_errno()) {
                exit('Database connection failed! ' . mysqli_connect_errno());
            } else {
                if (!empty($this->dbname)) {
                    $db_selected = @mysqli_select_db($this->_connection, $this->dbname);

                    if ($db_selected) {
                        if (!empty($this->charset)) {
                            @mysqli_set_charset($this->_connection, $this->charset);
                            @mysqli_query($this->_connection, "SET NAMES " . $this->charset);
                        }
                    } else {
                        exit('Database connection failed! ' . mysqli_connect_errno());
                    }
                }

                return (true);
            }
        }

        public function select_database($databasename = '')
        {
            if (!empty($databasename)) {
                if (isset($this->_connection)) {
                    $result = @mysqli_select_db($this->_connection, $this->dbname);

                    return ($result ? true : false);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function create_database($databasename = '')
        {
            if (!empty($databasename)) {
                if (isset($this->_connection)) {
                    $query = "CREATE DATABASE IF NOT EXISTS $databasename";
                    $result = @mysqli_query($this->_connection, $query);

                    return ($result ? true : false);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function drop_database($databasename = '')
        {
            if (!empty($tablename)) {
                if (isset($this->_connection)) {
                    $query = "DROP DATABASE IF NOT EXISTS $databasename";
                    $result = @mysqli_query($this->_connection, $query);

                    return ($result ? $result : false);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function add_new($table = '', $dataset = array())
        {
            !($this->_connection) ? exit('Connection failed!') : true;
            if (!empty($table) && !empty($dataset)) {
                if (isset($this->_connection)) {
                    $columns = implode(', ', array_keys($dataset));
                    $data = '\'' . implode('\',' . '\'', array_values($dataset)) . '\'';
                    $query = "INSERT INTO $table ($columns) VALUES($data)";
                    $result = @mysqli_query($this->_connection, $query);

                    return ($result ? true : false);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function select($table = '', $dataset = array())
        {
            !($this->_connection) ? exit('Connection failed!') : true;
            if (!empty($table) && !empty($dataset)) {
                if (isset($this->_connection)) {
                    $columns = implode(', ', $dataset);
                    $query = "SELECT $columns FROM $table";
                    $result = @mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {

                }
            }
        }

        public function select_all($table = '')
        {
            !($this->_connection) ? exit('Connection failed!') : true;
            if (!empty($table)) {
                if (isset($this->_connection)) {
                    $query = "SELECT * FROM $table";
                    $result = @mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    return (false);
                }
            }
        }

        public function select_where($table = '', $dataset = array(), $conditions = '')
        {
            if (!empty($table) && !empty($dataset) && !empty($conditions)) {
                if (isset($this->_connection)) {
                    $columns = implode(', ', $dataset);
                    $query = "SELECT $columns FROM $table WHERE $conditions";
                    $result = @mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function select_all_where($table = '', $conditions = '')
        {
            if (!empty($table) && !empty($conditions)) {
                if (isset($this->_connection)) {
                    $query = "SELECT * FROM $table WHERE $conditions";
                    $result = @mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function select_group_by($table = '', $dataset = array(), $groupby = '')
        {
            if (!empty($table) && !empty($dataset) && !empty($groupby)) {
                if (isset($this->_connection)) {
                    $columns = implode(', ', $dataset);
                    $query = "SELECT $columns FROM $table GROUP BY $groupby";
                    $result = mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function select_all_group_by($table = '', $groupby = '')
        {
            if (!empty($table) && !empty($groupby)) {
                if (isset($this->_connection)) {
                    $query = "SELECT * FROM $table GROUP BY $groupby";
                    $result = mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function select_where_group_by($table = '', $columns = array(), $conditions = '', $dataset = '')
        {
            if (!empty($table) && !empty($columns) && !empty($conditions) && !empty($dataset)) {
                if (isset($this->_connection)) {
                    $columns = implode(', ', $columns);
                    $query = "SELECT $columns FROM $table WHERE $conditions GROUP BY $dataset";
                    $result = mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }

        }

        public function select_all_where_group_by($table = '', $conditions = '', $dataset = '')
        {
            if (!empty($table) && !empty($conditions) && !empty($dataset)) {
                if (isset($this->_connection)) {
                    $query = "SELECT * FROM $table WHERE $conditions GROUP BY $dataset";
                    $result = mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function select_order_by($table = '', $columns = array(), $ordered = '')
        {
            if (!empty($table) && !empty($columns) && !empty($ordered)) {
                if (isset($this->_connection)) {
                    $columns = implode(', ', $columns);
                    $query = "SELECT $columns FROM $table ORDER BY $ordered";
                    $result = mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function select_all_order_by($table = '', $ordered = '')
        {
            if (!empty($table) && !empty($ordered)) {
                if (isset($this->_connection)) {
                    $query = "SELECT * FROM $table ORDER BY $ordered";
                    $result = mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function select_where_order_by($table = '', $columns = array(), $conditions = '', $ordered = '')
        {
            if (!empty($table) && !empty($columns) && !empty($conditions) && !empty($ordered)) {
                if (isset($this->_connection)) {
                    $columns = implode(', ', $columns);
                    $query = "SELECT $columns FROM $table WHERE $conditions ORDER BY $ordered";
                    $result = mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function select_all_where_order_by($table = '', $conditions = '', $ordered = '')
        {
            if (!empty($table) && !empty($conditions) && !empty($ordered)) {
                if (isset($this->_connection)) {
                    $query = "SELECT * FROM $table WHERE $conditions ORDER BY $ordered";
                    $result = mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function delete_record($table = '', $conditions = '')
        {
            if (!empty($table) && !empty($conditions)) {
                if (isset($this->_connection)) {
                    $query = "DELETE FROM $table WHERE $conditions";
                    $result = @mysqli_query($this->_connection, $query);

                    return ($result ? true : false);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }

            } else {
                return (false);
            }
        }

        public function delete_all_record($table = '')
        {
            if (!empty($table)) {
                if (isset($this->_connection)) {
                    $query = "DELETE FROM $table";
                    $result = mysqli_query($this->_connection, $query);

                    return ($result ? true : false);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }

            } else {
                return (false);
            }
        }

        public function update_record($table = '', $changed = '', $conditions = '')
        {
            if (!empty($table) && !empty($changed) && !empty($conditions)) {
                if (isset($this->_connection)) {
                    $query = "UPDATE $table SET $changed WHERE $conditions";
                    $result = mysqli_query($this->_connection, $query);

                    return ($result ? true : false);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function custom_query($custom_query = '')
        {
            if (!empty($custom_query)) {
                if (isset($this->_connection)) {
                    $query = $custom_query;
                    $result = @mysqli_query($this->_connection, $query);

                    return ($result ? $result : null);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }
        }

        public function count_record($dataset = array())
        {
            if (!empty($dataset)) {
                if (isset($this->_connection)) {
                    $result = @mysqli_num_rows($dataset);

                    return ($result ? $result : false);
                } else {
                    exit('Database connection failed! ' . mysqli_connect_errno());
                }
            } else {
                return (false);
            }

        }

        public function close_database()
        {
            if (isset($this->_connection)) {
                $result = @mysqli_close($this->_connection);
                return ($result ? true : false);
            } else {
                exit('Database connection failed! ' . mysqli_connect_errno());
            }
        }
    }
}
