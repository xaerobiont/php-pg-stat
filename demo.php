<?php

require_once 'path/to/composer/autoload.php';

$dbName = '';
$dbUser = '';
$dbPass = '';

$pgStat = new \zvook\PostgreStat\PgStat($dbName, $dbUser, $dbPass);
$dbStat = $pgStat->getDbStat();
$tablesStat = $pgStat->getTablesStat('total_table_size DESC', 5);
$statementsStat = $pgStat->getStatementsStat(5, 'avg_time DESC, calls DESC', 10);
$uselessIndexes = $pgStat->getUselessIndexes();
$missingIndexes = $pgStat->getLowIndexUsageTables();

?>

<html>
<head>
    <title>PgStat Demo</title>
    <style>
        body{
            font-size: 12px;
            font-family: Trebuchet MS, Helvetica CY, sans-serif;
            color: #888888;
        }
        table{
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
        }
        table td, table th{
            border: 1px solid #888888;
            padding: 3px;
        }
        table th{
            font-weight: 600;
        }
        table td label {
            font-style: italic;
            background-color: #f9f9f9;
        }
        table.bged tr{
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <h1>Database stat</h1>
    <table>
        <thead>
        <tr>
            <th>DB Name</th>
            <th>DB size</th>
            <th>Backend connections</th>
            <th>Xact</th>
            <th>Blocks read</th>
            <th>Tups</th>
            <th>Conflicts</th>
            <th>Deadlocks</th>
            <th>Temp</th>
            <th>Blocks RW time</th>
            <th>Last stat reset</th>
        </tr>
        </thead>
        <tbody>
        <tr>
            <td>[<?php echo $dbStat->getDatid() ?>] <?php echo $dbStat->getDatname() ?></td>
            <td><?php echo $dbStat->getDbSize() ?></td>
            <td><?php echo $dbStat->getNumbackends() ?></td>
            <td>
                <label>Commits:</label> <?php echo $dbStat->getXactCommit() ?><br>
                <label>Rollbacks:</label> <?php echo $dbStat->getXactRollback() ?>
            </td>
            <td>
                <label>Read:</label> <?php echo $dbStat->getBlksRead() ?><br>
                <label>Hit(Cache):</label> <?php echo $dbStat->getBlksHit() ?>
            </td>
            <td>
                <label>Returned:</label> <?php echo $dbStat->getTupReturned() ?><br>
                <label>Fetched:</label> <?php echo $dbStat->getTupFetched() ?><br>
                <label>Inserted:</label> <?php echo $dbStat->getTupInserted() ?><br>
                <label>Deleted:</label> <?php echo $dbStat->getTupDeleted() ?>
            </td>
            <td><?php echo $dbStat->getConflicts() ?></td>
            <td><?php echo $dbStat->getDeadlocks() ?></td>
            <td>
                <label>Files:</label> <?php echo $dbStat->getTempFiles() ?><br>
                <label>Size:</label> <?php echo $dbStat->getTempBytes() ?>
            </td>
            <td>
                <label>Read:</label> <?php echo $dbStat->getBlkReadTime() ?><br>
                <label>Write:</label> <?php echo $dbStat->getBlkWriteTime() ?>
            </td>
            <td><?php echo $dbStat->getStatsReset('d/m/y H:i:s') ?></td>
        </tr>
        </tbody>
    </table>
    <h1>Tables stat</h1>
    <table>
        <thead>
        <tr>
            <th>Table Name</th>
            <th>Table size</th>
            <th>Rows count</th>
            <th>Sequence</th>
            <th>Tups</th>
            <th>Last analyze (incl auto)</th>
            <th>Last vacuum (incl auto)</th>
            <th>Indexes</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($tablesStat as $ts): ?>
            <tr>
                <td><i><?php echo $ts->getSchemaname() ?></i>.<?php echo $ts->getRelname() ?></td>
                <td>
                    <label>Table Size:</label> <?php echo $ts->getTableSize() ?><br>
                    <label>Total Size:</label> <?php echo $ts->getTotalTableSize() ?>
                </td>
                <td><?php echo $ts->getNLiveTup() ?></td>
                <td>
                    <label>Scans:</label> <?php echo $ts->getSeqScan() ?><br>
                    <label>Tups Read:</label> <?php echo $ts->getSeqTupRead() ?>
                </td>
                <td>
                    <label>Inserted:</label> <?php echo $ts->getNTupIns() ?><br>
                    <label>Updated:</label> <?php echo $ts->getNTupUpd() ?><br>
                    <label>Deleted:</label> <?php echo $ts->getNTupDel() ?><br>
                    <label>Hot Updated:</label> <?php echo $ts->getNTupHotUpd() ?><br>
                    <label>Live Count:</label> <?php echo $ts->getNLiveTup() ?><br>
                    <label>Dead Count:</label> <?php echo $ts->getNDeadTup() ?>
                </td>
                <td>
                    <?php $lastAnalyze = $ts->getLastAnalyze('d/m/y H:i:s'); $autoAnalyze = $ts->getLastAutoanalyze('d/m/y H:i:s'); ?>
                    <?php echo strtotime($lastAnalyze) > strtotime($autoAnalyze) ? $lastAnalyze : $autoAnalyze ?>
                </td>
                <td>
                    <?php $lastVacuum = $ts->getLastVacuum('d/m/y H:i:s'); $autoVacuum = $ts->getLastAutovacuum('d/m/y H:i:s'); ?>
                    <?php echo strtotime($lastVacuum) > strtotime($autoVacuum) ? $lastVacuum : $autoVacuum ?>
                </td>
                <td>
                    <label>Scans:</label> <?php echo $ts->getIdxScan() ?><br>
                    <label>Tup Fetch:</label> <?php echo $ts->getIdxTupFetch() ?><br>
                    <label>Usage:</label> <?php echo $ts->getIndexUsagePercent().'%' ?><br>
                </td>
            </tr>
            <?php $indexes = $pgStat->getIndexesStat('idx_scan DESC', $ts->getRelname()) ?>
            <?php if (!empty($indexes)): ?>
                <tr>
                    <td colspan="2"><td>
                    <td colspan="6">
                        <table class="bged">
                            <thead>
                            <tr>
                                <th>Index Name</th>
                                <th>Scans</th>
                                <th>Size</th>
                                <th>Tups</th>
                                <th>Def</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($indexes as $idx): ?>
                                <tr>
                                    <td><?php echo $idx->getIndexrelname() ?></td>
                                    <td><?php echo $idx->getIdxScan() ?></td>
                                    <td><?php echo $idx->getIndexsize() ?></td>
                                    <td>
                                        <label>Read:</label> <?php echo $idx->getIdxTupRead() ?><br>
                                        <label>Fetch:</label> <?php echo $idx->getIdxTupFetch() ?>

                                    </td>
                                    <td><?php echo $idx->getIndexdef() ?></td>
                                </tr>
                            <?php endforeach ?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            <?php endif; ?>
            <tr></tr>
        <?php endforeach; ?>
        </tbody>
    </table>
    <h1>Statements</h1>
    <table>
        <thead>
        <tr>
            <th>QID</th>
            <th>Query</th>
            <th>Calls</th>
            <th>Avg time</th>
            <th>Time (total)</th>
            <th>Rows</th>
            <th>Time</th>
            <th>Shared Blocks</th>
            <th>Local Blocks</th>
            <th>Temp Blocks</th>
            <th>Blocks RW</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($statementsStat)): ?>
            <?php foreach ($statementsStat as $s): ?>
                <tr>
                    <td><?php echo $s->getQueryid() ?></td>
                    <td width="40%"><?php echo $s->getQuery() ?></td>
                    <td><?php echo $s->getCalls() ?></td>
                    <td><?php echo $s->getAvgTime() ?></td>
                    <td><?php echo $s->getTotalTime() ?></td>
                    <td><?php echo $s->getRows() ?></td>
                    <td>
                        <label>Min:</label> <?php echo $s->getMinTime() ?><br>
                        <label>Max:</label> <?php echo $s->getMaxTime() ?><br>
                        <label>Mean:</label> <?php echo $s->getMeanTime() ?><br>
                        <label>StdDev:</label> <?php echo $s->getStddevTime() ?>
                    </td>
                    <td>
                        <label>Read:</label> <?php echo $s->getSharedBlksRead() ?><br>
                        <label>Hit(cache):</label> <?php echo $s->getSharedBlksHit() ?><br>
                        <label>Written:</label> <?php echo $s->getSharedBlksWritten() ?><br>
                        <label>Dirtied:</label> <?php echo $s->getSharedBlksDirtied() ?>
                    </td>
                    <td>
                        <label>Read:</label> <?php echo $s->getLocalBlksRead() ?><br>
                        <label>Hit(cache):</label> <?php echo $s->getLocalBlksHit() ?><br>
                        <label>Written:</label> <?php echo $s->getLocalBlksWritten() ?><br>
                        <label>Dirtied:</label> <?php echo $s->getLocalBlksDirtied() ?>
                    </td>
                    <td>
                        <label>Read:</label> <?php echo $s->getTempBlksRead() ?><br>
                        <label>Written:</label> <?php echo $s->getTempBlksWritten() ?><br>
                    </td>
                    <td>
                        <label>Read Time:</label> <?php echo $s->getBlkReadTime() ?><br>
                        <label>Write Time:</label> <?php echo $s->getBlkWriteTime() ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
    <h1>Useless Indexes</h1>
    <table>
        <thead>
        <tr>
            <th>Table Name</th>
            <th>Index Name</th>
            <th>Scans</th>
            <th>Size</th>
            <th>Tups</th>
            <th>Def</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($uselessIndexes)): ?>
            <?php foreach ($uselessIndexes as $idx): ?>
                <tr>
                    <td><?php echo $idx->getRelname() ?></td>
                    <td><?php echo $idx->getIndexrelname() ?></td>
                    <td><?php echo $idx->getIdxScan() ?></td>
                    <td><?php echo $idx->getIndexsize() ?></td>
                    <td>
                        <label>Read:</label> <?php echo $idx->getIdxTupRead() ?><br>
                        <label>Fetch:</label> <?php echo $idx->getIdxTupFetch() ?>

                    </td>
                    <td><?php echo $idx->getIndexdef() ?></td>
                </tr>
            <?php endforeach ?>
        <?php endif; ?>
        </tbody>
    </table>
    <h1>Missing Indexes</h1>
    <table>
        <thead>
        <tr>
            <th>Table Name</th>
            <th>Table size</th>
            <th>Rows count</th>
            <th>Sequence</th>
            <th>Tups</th>
            <th>Last analyze (incl auto)</th>
            <th>Last vacuum (incl auto)</th>
            <th>Indexes</th>
        </tr>
        </thead>
        <tbody>
        <?php if (!empty($missingIndexes)): ?>
            <?php foreach ($missingIndexes as $ts): ?>
                <tr>
                    <td><i><?php echo $ts->getSchemaname() ?></i>.<?php echo $ts->getRelname() ?></td>
                    <td>
                        <label>Table Size:</label> <?php echo $ts->getTableSize() ?><br>
                        <label>Total Size:</label> <?php echo $ts->getTotalTableSize() ?>
                    </td>
                    <td><?php echo $ts->getNLiveTup() ?></td>
                    <td>
                        <label>Scans:</label> <?php echo $ts->getSeqScan() ?><br>
                        <label>Tups Read:</label> <?php echo $ts->getSeqTupRead() ?>
                    </td>
                    <td>
                        <label>Inserted:</label> <?php echo $ts->getNTupIns() ?><br>
                        <label>Updated:</label> <?php echo $ts->getNTupUpd() ?><br>
                        <label>Deleted:</label> <?php echo $ts->getNTupDel() ?><br>
                        <label>Hot Updated:</label> <?php echo $ts->getNTupHotUpd() ?><br>
                        <label>Live Count:</label> <?php echo $ts->getNLiveTup() ?><br>
                        <label>Dead Count:</label> <?php echo $ts->getNDeadTup() ?>
                    </td>
                    <td>
                        <?php $lastAnalyze = $ts->getLastAnalyze('d/m/y H:i:s'); $autoAnalyze = $ts->getLastAutoanalyze('d/m/y H:i:s'); ?>
                        <?php echo strtotime($lastAnalyze) > strtotime($autoAnalyze) ? $lastAnalyze : $autoAnalyze ?>
                    </td>
                    <td>
                        <?php $lastVacuum = $ts->getLastVacuum('d/m/y H:i:s'); $autoVacuum = $ts->getLastAutovacuum('d/m/y H:i:s'); ?>
                        <?php echo strtotime($lastVacuum) > strtotime($autoVacuum) ? $lastVacuum : $autoVacuum ?>
                    </td>
                    <td>
                        <label>Scans:</label> <?php echo $ts->getIdxScan() ?><br>
                        <label>Tup Fetch:</label> <?php echo $ts->getIdxTupFetch() ?><br>
                        <label>Usage:</label> <?php echo $ts->getIndexUsagePercent().'%' ?><br>
                    </td>
                </tr>
            <?php endforeach; ?>
        <?php endif; ?>
        </tbody>
    </table>
</body>
</html>
