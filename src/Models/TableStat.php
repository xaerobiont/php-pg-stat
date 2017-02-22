<?php

namespace zvook\PostgreStat\Models;

use zvook\PostgreStat\Components\Helper;

/**
 * @package zvook\PostgreStat\Models
 * @author Dmitry zvook Klyukin
 * @see https://www.postgresql.org/docs/9.5/static/monitoring-stats.html#PG-STAT-ALL-TABLES-VIEW
 */
class TableStat extends Model
{
    /**
     * @var int
     */
    protected $relid;

    /**
     * @var string
     */
    protected $schemaname;

    /**
     * @var string
     */
    protected $relname;

    /**
     * @var int
     */
    protected $seq_scan;

    /**
     * @var int
     */
    protected $seq_tup_read;

    /**
     * @var int
     */
    protected $idx_scan;

    /**
     * @var int
     */
    protected $idx_tup_fetch;

    /**
     * @var int
     */
    protected $n_tup_ins;

    /**
     * @var int
     */
    protected $n_tup_upd;

    /**
     * @var int
     */
    protected $n_tup_del;

    /**
     * @var int
     */
    protected $n_tup_hot_upd;

    /**
     * @var int
     */
    protected $n_live_tup;

    /**
     * @var int
     */
    protected $n_dead_tup;

    /**
     * @var int
     */
    protected $n_mod_since_analyze;

    /**
     * @var string
     */
    protected $last_vacuum;

    /**
     * @var string
     */
    protected $last_autovacuum;

    /**
     * @var string
     */
    protected $last_analyze;

    /**
     * @var string
     */
    protected $last_autoanalyze;

    /**
     * @var int
     */
    protected $vacuum_count;

    /**
     * @var int
     */
    protected $autovacuum_count;

    /**
     * @var int
     */
    protected $analyze_count;

    /**
     * @var int
     */
    protected $autoanalyze_count;

    /**
     * @var int
     */
    protected $table_size;

    /**
     * @var int
     */
    protected $total_table_size;

    /**
     * @var float
     */
    protected $index_usage_percent;

    /**
     * @return int
     */
    public function getRelid()
    {
        return $this->relid;
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
     * @param bool|true $pretty
     * @return int|string
     */
    public function getSeqScan($pretty = true)
    {
        return $pretty ? number_format($this->seq_scan) : $this->seq_scan;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getSeqTupRead($pretty = true)
    {
        return $pretty ? number_format($this->seq_tup_read) : $this->seq_tup_read;
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
    public function getIdxTupFetch($pretty = true)
    {
        return $pretty ? number_format($this->idx_tup_fetch) : $this->idx_tup_fetch;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getNTupIns($pretty = true)
    {
        return $pretty ? number_format($this->n_tup_ins) : $this->n_tup_ins;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getNTupUpd($pretty = true)
    {
        return $pretty ? number_format($this->n_tup_upd) : $this->n_tup_upd;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getNTupDel($pretty = true)
    {
        return $pretty ? number_format($this->n_tup_del) : $this->n_tup_del;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getNTupHotUpd($pretty = true)
    {
        return $pretty ? number_format($this->n_tup_hot_upd) : $this->n_tup_hot_upd;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getNLiveTup($pretty = true)
    {
        return $pretty ? number_format($this->n_live_tup) : $this->n_live_tup;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getNDeadTup($pretty = true)
    {
        return $pretty ? number_format($this->n_dead_tup) : $this->n_dead_tup;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getNModSinceAnalyze($pretty = true)
    {
        return $pretty ? number_format($this->n_mod_since_analyze) : $this->n_mod_since_analyze;
    }

    /**
     * @param null $format
     * @return string
     */
    public function getLastVacuum($format = null)
    {
        if ($format && $this->last_vacuum) {
            $dt = \DateTime::createFromFormat('Y-m-d H:i:s.uP', $this->last_vacuum);

            return $dt->format($format);
        }

        return $this->last_vacuum;
    }

    /**
     * @param null $format
     * @return string
     */
    public function getLastAutovacuum($format = null)
    {
        if ($format && $this->last_autovacuum) {
            $dt = \DateTime::createFromFormat('Y-m-d H:i:s.uP', $this->last_autovacuum);

            return $dt->format($format);
        }

        return $this->last_autovacuum;
    }

    /**
     * @param null $format
     * @return string
     */
    public function getLastAnalyze($format = null)
    {
        if ($format && $this->last_analyze) {
            $dt = \DateTime::createFromFormat('Y-m-d H:i:s.uP', $this->last_analyze);

            return $dt->format($format);
        }

        return $this->last_analyze;
    }

    /**
     * @param null $format
     * @return string
     */
    public function getLastAutoanalyze($format = null)
    {
        if ($format && $this->last_autoanalyze) {
            $dt = \DateTime::createFromFormat('Y-m-d H:i:s.uP', $this->last_autoanalyze);

            return $dt->format($format);
        }

        return $this->last_autoanalyze;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getVacuumCount($pretty = true)
    {
        return $pretty ? number_format($this->vacuum_count) : $this->vacuum_count;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getAutovacuumCount($pretty = true)
    {
        return $pretty ? number_format($this->autovacuum_count) : $this->autovacuum_count;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getAnalyzeCount($pretty = true)
    {
        return $pretty ? number_format($this->analyze_count) : $this->analyze_count;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getAutoanalyzeCount($pretty = true)
    {
        return $pretty ? number_format($this->autoanalyze_count) : $this->autoanalyze_count;
    }

    /**
     * @return float
     */
    public function getIndexUsagePercent()
    {
        return $this->index_usage_percent;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getTableSize($pretty = true)
    {
        return $pretty ? Helper::formatSize($this->table_size) : $this->table_size;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getTotalTableSize($pretty = true)
    {
        return $pretty ? Helper::formatSize($this->total_table_size) : $this->total_table_size;
    }
}