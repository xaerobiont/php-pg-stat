<?php

use zvook\PostgreStat\PgStat;

/**
 * @author Dmitry zvook Klyukin
 */
class PgStatTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     */
    public function testDbStat()
    {
        $monitor = new PgStat($_ENV['dbname'], $_ENV['dbuser'], $_ENV['dbpassword']);
        $stat = $monitor->getDbStat();
        $this->assertInstanceOf('zvook\\PostgreStat\\Models\\DbStat', $stat);
    }

    /**
     * @test
     */
    public function testTablesStat()
    {
        $monitor = new PgStat($_ENV['dbname'], $_ENV['dbuser'], $_ENV['dbpassword']);
        $stat = $monitor->getTablesStat();
        $this->assertNotEmpty($stat);
        $this->assertInstanceOf('zvook\\PostgreStat\\Models\\TableStat', $stat[0]);
    }

    /**
     * @test
     */
    public function testFunctionsStat()
    {
        $monitor = new PgStat($_ENV['dbname'], $_ENV['dbuser'], $_ENV['dbpassword']);
        $stat = $monitor->getFunctionsStat();
        if (!empty($stat)) {
            $this->assertInstanceOf('zvook\\PostgreStat\\Models\\FunctionStat', $stat[0]);
        }
    }

    /**
     * @test
     */
    public function testIndexesStat()
    {
        $monitor = new PgStat($_ENV['dbname'], $_ENV['dbuser'], $_ENV['dbpassword']);
        $stat = $monitor->getIndexesStat();
        $this->assertNotEmpty($stat);
        $this->assertInstanceOf('zvook\\PostgreStat\\Models\\IndexStat', $stat[0]);
    }

    /**
     * @test
     */
    public function testStatementsStat()
    {
        $monitor = new PgStat($_ENV['dbname'], $_ENV['dbuser'], $_ENV['dbpassword']);
        $stat = $monitor->getStatementsStat('avg_time DESC', 20);
        $this->assertNotEmpty($stat);
        $this->assertInstanceOf('zvook\\PostgreStat\\Models\\StatementStat', $stat[0]);
    }

    /**
     * @test
     */
    public function testUselessIndexes()
    {
        $monitor = new PgStat($_ENV['dbname'], $_ENV['dbuser'], $_ENV['dbpassword']);
        $stat = $monitor->getUselessIndexes();
        if (!empty($stat)) {
            $this->assertInstanceOf('zvook\\PostgreStat\\Models\\IndexStat', $stat[0]);
        }
    }

    /**
     * @test
     */
    public function testMissingIndexes()
    {
        $monitor = new PgStat($_ENV['dbname'], $_ENV['dbuser'], $_ENV['dbpassword']);
        $stat = $monitor->getLowIndexUsageTables();
        if (!empty($stat)) {
            $this->assertInstanceOf('zvook\\PostgreStat\\Models\\TableStat', $stat[0]);
        }
    }
}