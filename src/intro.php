<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

require "DBConnect.php";
require "DBQuery.php";
require "config.php";

$host = DB_HOST;
$name = DB_NAME;
$user = DB_USER;
$pswd = DB_PASS;

$dsn = "mysql:dbname=$name;host=$host;charset=utf8mb4";
$sql = 'INSERT VALUES (?)';

$db = DBConnect::connect($dsn,$user,$pswd);
$query = new DBQuery($db);

try{
    /*[DBConnection part]*/
    //$db->reconnect();
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //var_dump($db->getAttribute(PDO::ATTR_ERRMODE));
    //var_dump($db->getAvailableDrivers());
    //var_dump($db->getPdoInstance());
//    var_dump($db->getLastInsertID());

    /*[DBQuery part]*/
    var_dump($query->query($sql));
    //var_dump($query->execute($sql));
    //var_dump($query->beginTransaction());
    //var_dump($query->queryAll($sql, ['franko']));
    //var_dump($query->errorCode());
    //var_dump($query->errorInfo());
    //var_dump($query->inTransaction());
    //var_dump($query->rollBack());
    //var_dump($query->inTransaction());
    //var_dump($query->queryColumn($sql2));
    //$query->queryRow($sql, ['test']);
    //var_dump($query->queryScalar($sql));
    //var_dump($query->getLastQueryTime());

} catch(PDOException $e) {
    echo "[There are error with code #" . $e->getCode() . " occurred.]" . PHP_EOL;
    $e->getTrace();
    echo "[Details: " . $e->getMessage() . "]"  . PHP_EOL;
}


