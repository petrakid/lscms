<?php
// Database connection settings (you can change these to meet your needs)
$db_host  = 'localhost';
$db_db    = 'stpaulsl_db1';
$db_user  = 'stpaulsl_conn1';
$db_pass  = '9-n=Mgal@a*{';
$_SESSION['prefix'] = "tbl";

$dsn = "mysql:host=$db_host;dbname=$db_db;charset=utf8mb4";
try {
     // create a PDO connection with the configuration data
     $db = new PDO($dsn, $db_user, $db_pass);
     $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
} catch(PDOException $e) {
     echo 'Exception -> ';
     var_dump($e->getMessage());
}
?>