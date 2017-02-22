<?php

namespace zvook\PostgreStat\Models;

use zvook\PostgreStat\Components\Helper;

/**
 * @package zvook\PostgreStat\Models
 * @author Dmitry zvook Klyukin
 * @see https://www.postgresql.org/docs/9.5/static/pgstatstatements.html#AEN175645
 */
class StatementStat extends Model
{
    /**
     * @var int
     */
    protected $userid;

    /**
     * @var int
     */
    protected $dbid;

    /**
     * @var int
     */
    protected $queryid;

    /**
     * @var string
     */
    protected $query;

    /**
     * @var int
     */
    protected $calls;

    /**
     * @var float
     */
    protected $total_time;

    /**
     * @var float
     */
    protected $avg_time;

    /**
     * @var float
     */
    protected $min_time;

    /**
     * @var float
     */
    protected $max_time;

    /**
     * @var float
     */
    protected $mean_time;

    /**
     * @var float
     */
    protected $stddev_time;

    /**
     * @var int
     */
    protected $rows;

    /**
     * @var int
     */
    protected $shared_blks_hit;

    /**
     * @var int
     */
    protected $shared_blks_read;

    /**
     * @var int
     */
    protected $shared_blks_dirtied;

    /**
     * @var int
     */
    protected $shared_blks_written;

    /**
     * @var int
     */
    protected $local_blks_hit;

    /**
     * @var int
     */
    protected $local_blks_read;

    /**
     * @var int
     */
    protected $local_blks_dirtied;

    /**
     * @var int
     */
    protected $local_blks_written;

    /**
     * @var int
     */
    protected $temp_blks_read;

    /**
     * @var int
     */
    protected $temp_blks_written;

    /**
     * @var float
     */
    protected $blk_read_time;

    /**
     * @var float
     */
    protected $blk_write_time;

    /**
     * @return int
     */
    public function getUserid()
    {
        return $this->userid;
    }

    /**
     * @return int
     */
    public function getDbid()
    {
        return $this->dbid;
    }

    /**
     * @return int
     */
    public function getQueryid()
    {
        return $this->queryid;
    }

    /**
     * @return string
     */
    public function getQuery()
    {
        return $this->query;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getCalls($pretty = true)
    {
        return $pretty ? number_format($this->calls) : $this->calls;
    }

    /**
     * @param bool|true $pretty
     * @return float|string
     */
    public function getTotalTime($pretty = true)
    {
        return $pretty ? Helper::formatMilliseconds($this->total_time) : $this->total_time;
    }

    /**
     * @param bool|true $pretty
     * @return float|string
     */
    public function getAvgTime($pretty = true)
    {
        return $pretty ? Helper::formatMilliseconds($this->avg_time) : $this->avg_time;
    }

    /**
     * @param bool|true $pretty
     * @return float|string
     */
    public function getMinTime($pretty = true)
    {
        return $pretty ? Helper::formatMilliseconds($this->min_time) : $this->min_time;
    }

    /**
     * @param bool|true $pretty
     * @return float|string
     */
    public function getMaxTime($pretty = true)
    {
        return $pretty ? Helper::formatMilliseconds($this->max_time) : $this->max_time;
    }

    /**
     * @param bool|true $pretty
     * @return float|string
     */
    public function getMeanTime($pretty = true)
    {
        return $pretty ? Helper::formatMilliseconds($this->mean_time) : $this->mean_time;
    }

    /**
     * @param bool|true $pretty
     * @return float|string
     */
    public function getStddevTime($pretty = true)
    {
        return $pretty ? Helper::formatMilliseconds($this->stddev_time) : $this->stddev_time;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getRows($pretty = true)
    {
        return $pretty ? number_format($this->rows) : $this->rows;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getSharedBlksHit($pretty = true)
    {
        return $pretty ? number_format($this->shared_blks_hit) : $this->shared_blks_hit;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getSharedBlksRead($pretty = true)
    {
        return $pretty ? number_format($this->shared_blks_read) : $this->shared_blks_read;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getSharedBlksDirtied($pretty = true)
    {
        return $pretty ? number_format($this->shared_blks_dirtied) : $this->shared_blks_dirtied;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getSharedBlksWritten($pretty = true)
    {
        return $pretty ? number_format($this->shared_blks_written) : $this->shared_blks_written;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getLocalBlksHit($pretty = true)
    {
        return $pretty ? number_format($this->local_blks_hit) : $this->local_blks_hit;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getLocalBlksRead($pretty = true)
    {
        return $pretty ? number_format($this->local_blks_read) : $this->local_blks_read;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getLocalBlksDirtied($pretty = true)
    {
        return $pretty ? number_format($this->local_blks_dirtied) : $this->local_blks_dirtied;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getLocalBlksWritten($pretty = true)
    {
        return $pretty ? number_format($this->local_blks_written) : $this->local_blks_written;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getTempBlksRead($pretty = true)
    {
        return $pretty ? number_format($this->temp_blks_read) : $this->temp_blks_read;
    }

    /**
     * @param bool|true $pretty
     * @return int|string
     */
    public function getTempBlksWritten($pretty = true)
    {
        return $pretty ? number_format($this->temp_blks_written) : $this->temp_blks_written;
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
}