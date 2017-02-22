<?php

namespace zvook\PostgreStat\Components;

/**
 * @package zvook\PostgreStat\Components
 * @author Dmitry zvook Klyukin
 */
class Connection
{
    /**
     * @var null|\PDO
     */
    protected $connection = null;

    /**
     * @var string
     */
    protected $dbName;

    /**
     * @var int
     */
    protected $dbId;

    /**
     * @param $db
     * @param $user
     * @param $password
     * @param string $host
     * @param null $port
     * @throws PgStatException
     */
    function __construct($db, $user, $password, $host = 'localhost', $port = null)
    {
        try {
            $string = "pgsql:host=$host;dbname=$db".($port ? "port:$port;" : "");
            $this->connection = new \PDO($string, $user, $password);
            $this->connection->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_ASSOC);
            $this->connection->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
            $this->dbName = $db;
            $this->dbId = $this->connection->query(sprintf("SELECT oid FROM pg_database WHERE datname = '%s'", $db))
                ->fetchColumn();
        } catch (\Exception $e) {
            throw new PgStatException($e->getMessage(), $e->getCode(), $e);
        }
    }

    /**
     * @return null|\PDO
     */
    public function get()
    {
        return $this->connection;
    }

    public function close()
    {
        $this->connection = null;
    }

    /**
     * @return string
     */
    public function getDbName()
    {
        return $this->dbName;
    }

    /**
     * @return int
     */
    public function getDbId()
    {
        return $this->dbId;
    }

    /**
     * @param $instance
     * @param $query
     * @param bool|false $one
     * @return array|object
     * @throws PgStatException
     */
    public function queryAndFetch($instance, $query, $one = false)
    {
        $res = [];
        try {
            $rows = $this->get()->query($query);
            if (!empty($rows)) {
                if ($one) {
                    $res = new $instance($rows->fetch());
                } else {
                    foreach ($rows->fetchAll() as $row) {
                        $res[] = new $instance($row);
                    }
                }
            }
        } catch (\Exception $e) {
            throw new PgStatException($e->getMessage(), (int)$e->getCode(), $e);
        }

        return $res;
    }
}