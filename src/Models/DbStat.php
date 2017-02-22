<?php

namespace zvook\PostgreStat\Models;

use zvook\PostgreStat\Components\Helper;

/**
 * @package zvook\PostgreStat\Models
 * @author Dmitry zvook Klyukin
 * @see https://www.postgresql.org/docs/9.5/static/monitoring-stats.html#PG-STAT-DATABASE-VIEW
 */
class DbStat extends Model
{
    /**
     * @var int
     */
    protected $datid;

    /**
     * @var string
     */
    protected $datname;

    /**
     * @var int
     */
    protected $numbackends = 0;

    /**
     * @var int
     */
    protected $xact_commit = 0;

    /**
     * @var int
     */
    protected $xact_rollback = 0;

    /**
     * @var int
     */
    protected $blks_read = 0;

    /**
     * @var int
     */
    protected $blks_hit = 0;

    /**
     * @var int
     */
    protected $tup_returned = 0;

    /**
     * @var int
     */
    protected $tup_fetched = 0;

    /**
     * @var int
     */
    protected $tup_inserted = 0;

    /**
     * @var int
     */
    protected $tup_deleted = 0;

    /**
     * @var int
     */
    protected $conflicts = 0;

    /**
     * @var int
     */
    protected $temp_files = 0;

    /**
     * @var int
     */
    protected $temp_bytes = 0;

    /**
     * @var int
     */
    protected $deadlocks = 0;

    /**
     * @var float
     */
    protected $blk_read_time = 0;

    /**
     * @var float
     */
    protected $blk_write_time = 0;

    /**
     * @var string
     */
    protected $stats_reset = 0;

    /**
     * @var int
     */
    protected $db_size;

    /**
     * @return int
     */
    public function getDatid()
    {
        return $this->datid;
    }

    /**
     * @return string
     */
    public function getDatname()
    {
        return $this->datname;
    }

    /**
     * @return int
     */
    public function getNumbackends()
    {
        return $this->numbackends;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getXactCommit($pretty = true)
    {
        return $pretty ? number_format($this->xact_commit) : $this->xact_commit;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getXactRollback($pretty = true)
    {
        return $pretty ? number_format($this->xact_rollback) : $this->xact_rollback;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getBlksRead($pretty = true)
    {
        return $pretty ? number_format($this->blks_read) : $this->blks_read;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getBlksHit($pretty = true)
    {
        return $pretty ? number_format($this->blks_hit) : $this->blks_hit;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getTupReturned($pretty = true)
    {
        return $pretty ? number_format($this->tup_returned) : $this->tup_returned;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getTupFetched($pretty = true)
    {
        return $pretty ? number_format($this->tup_fetched) : $this->tup_fetched;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getTupInserted($pretty = true)
    {
        return $pretty ? number_format($this->tup_inserted) : $this->tup_inserted;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getTupDeleted($pretty = true)
    {
        return $pretty ? number_format($this->tup_deleted) : $this->tup_deleted;
    }

    /**
     * @return int
     */
    public function getConflicts()
    {
        return $this->conflicts;
    }

    /**
     * @return int
     */
    public function getTempFiles()
    {
        return $this->temp_files;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getTempBytes($pretty = true)
    {
        return $pretty ? Helper::formatSize($this->temp_bytes) : $this->temp_bytes;
    }

    /**
     * @return int
     */
    public function getDeadlocks()
    {
        return $this->deadlocks;
    }

    /**
     * @param bool|true $pretty
     * @return float|string
     */
    public function getBlkReadTime($pretty = true)
    {
        return $pretty ? Helper::formatMilliseconds($this->blk_read_time) : $this->blk_read_time;
    }

    /**
     * @param bool|true $pretty
     * @return float|string
     */
    public function getBlkWriteTime($pretty = true)
    {
        return $pretty ? Helper::formatMilliseconds($this->blk_write_time) : $this->blk_write_time;
    }

    /**
     * @param null $format
     * @return string
     */
    public function getStatsReset($format = null)
    {
        if ($format && $this->stats_reset) {
            $dt = \DateTime::createFromFormat('Y-m-d H:i:s.uP', $this->stats_reset);

            return $dt->format($format);
        }

        return $this->stats_reset;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getDbSize($pretty = true)
    {
        return $pretty ? Helper::formatSize($this->db_size) : $this->db_size;
    }
}