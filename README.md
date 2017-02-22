# PHP tool for monitoring PostgreSQL statistic

### Requirements

- PHP 5.6+
- PostgreSQL 9.2+ (9.5+ recommended)


### Containing

- Database statistic
- Tables statistic
- Indexes statistic
- Functions statistic
- Statements
- Useless/Missing indexes analytic

### Installation

1. First of all you need to enable **pg_stat_statements** library
   Add to your *postgresql.conf*:
   ```
   shared_preload_libraries = 'pg_stat_statements'
   track_io_timing = on # optional
   ```
2. Then connect to the **database you want to track** with user you will use to connect (**not with postgres user!**) and run:
   ```sql
   CREATE EXTENSION pg_stat_statements
   ```
   !Please note that you should run SQL above exactly **inside** your database and **exactly** by your backend user
3. Restart postgre server

4. Add to your composer.json
   ```
   "require": {
       "zvook/php-postgresql-stat": "*"
   }
   ```
5. Run
   ```sh
   $ composer update
   ```

### Demo

When package installed and postgreSQL configured you can build demo page to observe the situation.
Go to the package root directory and edit **demo.php** with your database credentials. Then run:
```sh
php demo.php > demo.html
```
Then open demo.html with browser

### Basic Usage

!Please not that pg_stat_statements needs a time for collecting statistic to provide you adequate information

```php
use zvook\PostgreStat;

$dbName = 'my_db';
$dbUser = 'my_user';
$dbPass = 'my_pass';

$pgStat = new PgStat($dbName, $dbUser, $dbPass);

# Get basic DB statistic
# Returns instance of zvook\PostgreStat\Models\DbStat
$pgStat->getDbStat();

# Get detailed tables statistic
# Returns an array of zvook\PostgreStat\Models\TableStat instances
$pgStat->getTablesStat();

# Get user functions statistic
# Returns an array of zvook\PostgreStat\Models\FunctionStat instances
$pgStat->getFunctionsStat();

# Get indexes statistic
# Returns an array of zvook\PostgreStat\Models\IndexStat instances
$pgStat->getIndexesStat();

# Get statements
# Returns an array of zvook\PostgreStat\Models\StatementStat instances
$pgStat->getStatementsStat();

# Get useless indexes (analytic)
# Returns the same as getIndexesStat()
$pgStat->getUselessIndexes();

# Get missing indexes (analytic)
# Returns the same as getTablesStat()
$pgStat->getLowIndexUsageTables();
```
Also you can find complete usage example in **demo.php** in the root dir of the package

### Information

- [PostgreSQL Statistics](https://www.postgresql.org/docs/9.5/static/monitoring-stats.html)
- [PostgreSQL Statements](https://www.postgresql.org/docs/9.5/static/pgstatstatements.html)