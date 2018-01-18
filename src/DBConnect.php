<?php
include_once "DBConnectionInterface.php";

class DBConnect implements DBConnectionInterface
{
    private static $instance = null;
    public static $connection = null;
    private static $dsn, $user, $pswd;

    public static function getInstance()
    {
        if (null === self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    private function __clone()
    {
    }

    private function __construct()
    {
        echo "[Singletone instance]" . PHP_EOL;
    }

    private function __wakeup()
    {
        // TODO: Implement __wakeup() method.
    }

    public static function connect($dsn, $username = '', $password = '')
    {
        try {
            self::$dsn = $dsn;
            self::$user = $username;
            self::$pswd = $password;

            self::$connection = new PDO(self::$dsn, self::$user, self::$pswd, [PDO::ATTR_EMULATE_PREPARES => false]);
            self::$connection->query('set profiling=1');

            echo "[Connection succeed]" . PHP_EOL;

            return self::getInstance();
        } catch (PDOException $e) {

            echo 'Connection failed: ' . $e->getMessage();
            self::$connection = null;

        }
        return null;
    }

    public function reconnect()
    {
        self::$connection = null;

        self::connect(self::$dsn, self::$user, self::$pswd);
    }

    /**
     * Returns the PDO instance.
     *
     * @return PDO the PDO instance, null if the connection is not established yet
     */
    public function getPdoInstance()
    {
        return self::$connection instanceof \PDO ? self::$connection : null;
    }

    public function setAttribute($attribute, $value)
    {
        return self::$connection->setAttribute($attribute, $value);
    }

    public function getAttribute($attribute)
    {
        return self::$connection->getAttribute($attribute);
    }

    public function getLastInsertID($sequenceName = '')
    {
        return self::$connection->lastInsertId();
    }

    /**
     * Return an array of available PDO drivers
     *
     * @return array
     */
    public function getAvailableDrivers(){
        return self::$connection->getAvailableDrivers();
    }

    public function close()
    {
       self::$connection = null;
    }
}

