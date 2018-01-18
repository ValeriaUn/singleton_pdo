<?php
include_once "DBQueryInterface.php";
include_once "DBConnectionInterface.php";
include_once "DBConnect.php";

class DBQuery implements DBQueryInterface
{
    public $connection = null;

    /**
     * Create new instance DBQuery.
     *
     * @param DBConnectionInterface $DBConnection
     */
    public function __construct(DBConnectionInterface $DBConnection)
    {
        $this->connection = $DBConnection;
    }

    /**
     * Returns the DBConnection instance.
     *
     * @return DBConnectionInterface
     */
    public function getDBConnection()
    {
        return $this->connection;
    }

    //what this method should do?
    /**
     * Change DBConnection.
     *
     * @param DBConnectionInterface $DBConnection
     *
     * @return void
     */
    public function setDBConnection(DBConnectionInterface $DBConnection)
    {
        $this->connection->reconnect();
    }

    //what should be in params? "non-query" - is it UPDATE, INSERT, DELETE? which way this should be implemented this?
    /**
     * Executes the SQL statement.
     * This method is meant only for executing non-query SQL statement.
     * No result set will be returned.
     *
     * @param string $query  sql query
     * @param array  $params input parameters (name=>value) for the SQL execution
     *
     * @return integer number of rows affected by the execution.
     */
    public function execute($query, array $params = null)
    {
        $db = $this->connection->getPdoInstance();
        return $db->exec($query);
        /*
         * prepare()/execute()/rowCount()?
         * */
    }

    //what should be in params?
    /**
     * Executes the SQL statement and returns query result.
     *
     * @param string $query  sql query
     * @param array  $params input parameters (name=>value) for the SQL execution
     *
     * @return mixed if successful, returns a PDOStatement on error false
     */
    public function query($query, $params = null)
    {
        $db = $this->connection->getPdoInstance();

        $result = $db->query($query);

        return $result->fetchAll(PDO::FETCH_NUM);

    }

    /**
     * Executes the SQL statement and returns all rows of a result set as an associative array
     *
     * @param string $query  sql query
     * @param array  $params input parameters (name=>value) for the SQL execution
     *
     * @return array
     */
    public function queryAll($query, array $params = null)
    {
        $prepared = $this->connection->getPdoInstance()->prepare($query);

        if ($params === null) {
            $prepared->execute();
        } else {
            $prepared->execute($params);
        }

        return $prepared->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Executes the SQL statement and returns the first column of the query result.
     *
     * @param string $query sql query
     * @param array $params input parameters (name=>value) for the SQL execution
     *
     * @return array
     */
    public function queryColumn($query, array $params = null)
    {
        $prepared = $this->connection->getPdoInstance()->prepare($query);

        if ($params === null) {
            $prepared->execute();
        } else {
            $prepared->execute($params);
        }

        return $prepared->fetchAll(PDO::FETCH_COLUMN);
    }

    /**
     * Executes the SQL statement returns the first row of the query result
     *
     * @param string $query sql query
     * @param array $params input parameters (name=>value) for the SQL execution
     *
     * @return array
     */
    public function queryRow($query, array $params = null)
    {
        $prepared = $this->connection->getPdoInstance()->prepare($query);

        if ($params === null) {

            $prepared->execute();

        } else {

            $prepared->execute($params);
        }

        return $prepared->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Executes the SQL statement and returns the first field of the first row of the result.
     *
     * @param string $query sql query
     * @param array $params input parameters (name=>value) for the SQL execution
     *
     * @return mixed  column value
     */
    public function queryScalar($query, array $params = null)
    {
        $prepared = $this->connection->getPdoInstance()->prepare($query);

        if ($params === null) {
            $prepared->execute();
        } else {
            $prepared->execute($params);
        }

        return $prepared->fetchColumn();
    }

    /**
     * Returns the last query execution time in seconds
     *
     * @return float query time in seconds
     */
    public function getLastQueryTime()
    {
        $tmp = $this->queryAll('show profiles');

        return end($tmp)["Duration"];
    }

    /**
     * Initiates a transaction
     *
     * @return bool
     */
    public function beginTransaction() {
        return $this->connection->getPdoInstance()->beginTransaction();
    }

    /**
     * Commits a transaction
     *
     * @return bool
     */
    public function commit() {
        return $this->connection->getPdoInstance()->commit();
    }

    /**
     * Fetch the SQLSTATE associated with the last operation on the database handle
     *
     * @return string
     */
    public function errorCode() {
        return $this->connection->getPdoInstance()->errorCode();
    }

    /**
     * Fetch extended error information associated with the last operation on the database handle
     *
     * @return array
     */
    public function errorInfo() {
        return $this->connection->getPdoInstance()->errorInfo();
    }

    /**
     * Rolls back a transaction
     *
     * @return bool
     */
    public function rollBack() {
        return $this->connection->getPdoInstance()->rollBack();
    }

    /**
     * Checks is transaction started
     *
     * @return bool
     */
    public function inTransaction() {
        return $this->connection->getPdoInstance()->inTransaction();
    }
}