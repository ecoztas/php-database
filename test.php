<?php include('class.database.php');

$database = new Database();
$database->set_hostname('localhost');
$database->set_username('root');
$database->set_password('');
$database->set_charset('UTF-8');
$database->set_dbname('db_test');

$database->connect_database();
$selection = $database->select_all_where('tbl_test', 'name LIKE \'%emrecan%\'');

foreach ($selection as $select) {
    echo($select['name'] . '<br>');
}