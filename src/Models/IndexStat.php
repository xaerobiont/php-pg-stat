<?php

namespace zvook\PostgreStat\Models;
use zvook\PostgreStat\Components\Helper;

/**
 * @package zvook\PostgreStat\Models
 * @author Dmitry zvook Klyukin
 * @see https://www.postgresql.org/docs/9.5/static/monitoring-stats.html#PG-STAT-ALL-INDEXES-VIEW
 */
class IndexStat extends Model
{
    /**
     * @var int
     */
    protected $relid;

    /**
     * @var int
     */
    protected $indexrelid;

    /**
     * @var string
     */
    protected $schemaname;

    /**
     * @var string
     */
    protected $relname;

    /**
     * @var string
     */
    protected $indexrelname;

    /**
     * @var string
     */
    protected $indexdef;

    /**
     * @var int
     */
    protected $indexsize;

    /**
     * @var int
     */
    protected $idx_scan;

    /**
     * @var int
     */
    protected $idx_tup_read;

    /**
     * @var int
     */
    protected $idx_tup_fetch;

    /**
     * @return int
     */
    public function getRelid()
    {
        return $this->relid;
    }

    /**
     * @return int
     */
    public function getIndexrelid()
    {
        return $this->indexrelid;
    }

    /**
     * @return string
     */
    public function getSchemaname()
    {
        return $this->schemaname;
    }

    /**
     * @return string
     */
    public function getRelname()
    {
        return $this->relname;
    }

    /**
     * @return string
     */
    public function getIndexrelname()
    {
        return $this->indexrelname;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getIdxScan($pretty = true)
    {
        return $pretty ? number_format($this->idx_scan) : $this->idx_scan;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getIdxTupRead($pretty = true)
    {
        return $pretty ? number_format($this->idx_tup_read) : $this->idx_tup_read;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getIdxTupFetch($pretty = true)
    {
        return $pretty ? number_format($this->idx_tup_fetch) : $this->idx_tup_fetch;
    }

    /**
     * @return string
     */
    public function getIndexdef()
    {
        return $this->indexdef;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getIndexsize($pretty = true)
    {
        return $pretty ? Helper::formatSize($this->indexsize) : $this->indexsize;
    }
}