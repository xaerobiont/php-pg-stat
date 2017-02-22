<?php

namespace zvook\PostgreStat\Components;

/**
 * @package zvook\PostgreStat\Components
 * @author Dmitry zvook Klyukin
 */
class Helper
{
    /**
     * @param int $bytes
     * @return string
     */
    public static function formatSize($bytes)
    {
        if (!$bytes) {
            return 0;
        }
        $units = array('B', 'KB', 'MB', 'GB', 'TB');
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);
        $bytes /= (1 << (10 * $pow));

        return round($bytes, 2) . ' ' . $units[$pow];
    }

    /**
     * @param float $milliseconds
     * @return string
     */
    public static function formatMilliseconds($milliseconds)
    {
        if ($milliseconds) {
            $t = floor($milliseconds);
            $hrs = floor($t/3600);
            $mnts = ($t/60)%60;
            $scs = $t%60;
            $mlscs = round($milliseconds - $t, 3)*1000;
            $template = $hrs ? $hrs.'h ' : '';
            $template .= $mnts ? $mnts.'m ' : '';
            $template .= $scs ? $scs.'s ' : '';
            $template .= $mlscs.'ms';

            return $template;
        }

        return 0;
    }
}