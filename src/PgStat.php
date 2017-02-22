<?php

namespace zvook\PostgreStat;

use zvook\PostgreStat\Components\Connection;
use zvook\PostgreStat\Components\PgStatException;
use zvook\PostgreStat\Models\DbStat;
use zvook\PostgreStat\Models\FunctionStat;
use zvook\PostgreStat\Models\IndexStat;
use zvook\PostgreStat\Models\StatementStat;
use zvook\PostgreStat\Models\TableStat;

/**
 * @package zvook\PostgreStat
 * @author Dmitry zvook Klyukin
 */
class PgStat
{
    /**
     * @var Connection
     */
    protected $connection;

    /**
     * @param $dbName
     * @param $dbUser
     * @param $dbPassword
     * @param string $host
     * @param null $port
     * @throws PgStatException
     */
    function __construct($dbName, $dbUser, $dbPassword, $host = 'localhost', $port = null)
    {
        $this->connection = new Connection($dbName, $dbUser, $dbPassword, $host = 'localhost', $port = null);
    }

    /**
     * @return DbStat
     * @throws PgStatException
     */
    public function getDbStat()
    {
        $sql = sprintf("SELECT pg_database_size(pgd.datname) db_size, pgd.* FROM pg_stat_database pgd WHERE pgd.datname = '%s'",
            $this->connection->getDbName());

        return $this->connection->queryAndFetch(DbStat::className(), $sql, true);
    }

    /**
     * @param string $order
     * @param null $limit
     * @return TableStat[]
     * @throws PgStatException
     */
    public function getTablesStat($order = 'total_table_size DESC', $limit = null)
    {
        $sql = sprintf("SELECT pgsut.*, pg_relation_size(pgsut.relid) as table_size,
            pg_total_relation_size(pgsut.relid) as total_table_size, CASE idx_scan WHEN 0 THEN 0
            ELSE round((100 * idx_scan / (seq_scan + idx_scan))::NUMERIC, 2) END as index_usage_percent
            FROM pg_stat_user_tables pgsut ORDER BY %s",
            $order);
        if (!is_null($limit)) {
            $sql .= sprintf(' LIMIT %d', $limit);
        }

        return $this->connection->queryAndFetch(TableStat::className(), $sql);
    }

    /**
     * @param string $order
     * @return FunctionStat[]
     * @throws PgStatException
     */
    public function getFunctionsStat($order = 'calls DESC')
    {
        $sql = sprintf("SELECT pgsuf.*, CASE calls WHEN 0 THEN 0 ELSE round((total_time/calls)::NUMERIC, 2) END as avg_time
            FROM pg_stat_user_functions pgsuf ORDER BY %s
        ", $order);

        return $this->connection->queryAndFetch(FunctionStat::className(), $sql);
    }

    /**
     * @param string $order
     * @param null $tableName
     * @return IndexStat[]
     * @throws PgStatException
     */
    public function getIndexesStat($order = 'idx_scan DESC', $tableName = null)
    {
        $sql = "SELECT pgsui.*, pg_relation_size(pgsui.indexrelid) as indexsize,
            (SELECT pgi.indexdef FROM pg_indexes pgi WHERE pgi.indexname = pgsui.indexrelname AND pgi.tablename = pgsui.relname) as indexdef
            FROM pg_stat_user_indexes pgsui";
        if ($tableName) {
            $sql .= sprintf(" WHERE pgsui.relname = '%s'", $tableName);
        }
        $sql .= sprintf(' ORDER BY %s', $order);

        return $this->connection->queryAndFetch(IndexStat::className(), $sql);
    }

    /**
     * @param string $order
     * @param null $limit
     * @return StatementStat[]
     * @throws PgStatException
     */
    public function getStatementsStat($order = 'calls DESC, avg_time DESC', $limit = null)
    {
        $sql = "SELECT pgss.*, (total_time/calls) as avg_time
            FROM pg_stat_statements pgss WHERE dbid = ".$this->connection->getDbId()."
            AND query NOT SIMILAR TO ('%(pg_indexes|pg_database|pg_stat_user_tables|pg_stat_database|pg_stat_statements|DEALLOCATE)%')
            ORDER BY ".$order;
        if (!is_null($limit)) {
            $sql .= sprintf(' LIMIT %d', $limit);
        }

        return $this->connection->queryAndFetch(StatementStat::className(), $sql);
    }

    /**
     * @param int $minTableSize Minimum table size (in bytes) to participate this query
     * @param int $maxIdxScans Index scans low limit
     * @return IndexStat[]
     * @throws PgStatException
     */
    public function getUselessIndexes($minTableSize = 1000, $maxIdxScans = 50)
    {
        $sql = sprintf("SELECT pgsui.*, pg_relation_size(pgsui.indexrelid) as indexsize,
            (SELECT pgis.indexdef FROM pg_indexes pgis WHERE pgis.indexname = pgsui.indexrelname AND pgis.tablename = pgsui.relname) as indexdef
            FROM pg_stat_user_indexes pgsui INNER JOIN pg_index pgi ON pgsui.indexrelid = pgi.indexrelid
            WHERE pgi.indisunique IS FALSE AND pgi.indisprimary IS FALSE AND pg_relation_size(pgsui.relid) >= %d AND pgsui.idx_scan <= %d
            ORDER BY idx_scan ASC",
            $minTableSize, $maxIdxScans);

        return $this->connection->queryAndFetch(IndexStat::className(), $sql);
    }

    /**
     * @param int $minTableScans Minimum table scans (incl idx scans) to participate this query
     * @param int $limit
     * @return array|object
     * @throws PgStatException
     */
    public function getLowIndexUsageTables($minTableScans = 100, $limit = 50)
    {
        $sql = sprintf("SELECT pgsut.*, pg_relation_size(pgsut.relid) as table_size,
            pg_total_relation_size(pgsut.relid) as total_table_size, CASE idx_scan WHEN 0 THEN 0
            ELSE round((100 * idx_scan / (seq_scan + idx_scan))::NUMERIC, 2) END as index_usage_percent
            FROM pg_stat_user_tables pgsut WHERE seq_scan+idx_scan >= %d AND idx_scan < seq_scan
            ORDER BY index_usage_percent ASC", $minTableScans);
        if (!is_null($limit)) {
            $sql .= sprintf(' LIMIT %d', $limit);
        }

        return $this->connection->queryAndFetch(TableStat::className(), $sql);
    }
}