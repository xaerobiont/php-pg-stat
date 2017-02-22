<?php

namespace zvook\PostgreStat\Models;

use zvook\PostgreStat\Components\Helper;

/**
 * @package zvook\PostgreStat\Models
 * @author Dmitry zvook Klyukin
 * @see https://www.postgresql.org/docs/9.5/static/monitoring-stats.html#PG-STAT-USER-FUNCTIONS-VIEW
 */
class FunctionStat extends Model
{
    /**
     * @var int
     */
    protected $funcid;

    /**
     * @var string
     */
    protected $schemaname;

    /**
     * @var string
     */
    protected $funcname;

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
    protected $self_time;

    /**
     * @var float
     */
    protected $avg_time;

    /**
     * @return int
     */
    public function getFuncid()
    {
        return $this->funcid;
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
    public function getFuncname()
    {
        return $this->funcname;
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
    public function getSelfTime($pretty = true)
    {
        return $pretty ? Helper::formatMilliseconds($this->self_time) : $this->self_time;
    }

    /**
     * @param bool|true $pretty
     * @return float|string
     */
    public function getAvgTime($pretty = true)
    {
        return $pretty ? Helper::formatMilliseconds($this->avg_time) : $this->avg_time;
    }
}