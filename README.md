# soar-php

> [!NOTE]
> SQL optimizer and rewriter(assisted SQL tuning) based on Xiaomi's [soar](https://github.com/XiaoMi/soar) development. - 基于小米的 [soar](https://github.com/XiaoMi/soar) 开发的 SQL 优化器和重写器(辅助 SQL 调优)。

[![tests](https://github.com/guanguans/soar-php/actions/workflows/tests.yml/badge.svg)](https://github.com/guanguans/soar-php/actions/workflows/tests.yml)
[![php-cs-fixer](https://github.com/guanguans/soar-php/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/soar-php/actions/workflows/php-cs-fixer.yml)
[![codecov](https://codecov.io/gh/guanguans/soar-php/graph/badge.svg?token=0RtgSGom4K)](https://codecov.io/gh/guanguans/soar-php)
[![Latest Stable Version](https://poser.pugx.org/guanguans/soar-php/v)](https://packagist.org/packages/guanguans/soar-php)
[![GitHub release (with filter)](https://img.shields.io/github/v/release/guanguans/soar-php)](https://github.com/guanguans/soar-php/releases)
[![Total Downloads](https://poser.pugx.org/guanguans/soar-php/downloads)](https://packagist.org/packages/guanguans/soar-php)
[![License](https://poser.pugx.org/guanguans/soar-php/license)](https://packagist.org/packages/guanguans/soar-php)

## Requirement

* PHP >= 8.1

## Used in the framework

- [x] Laravel - [laravel-soar](https://github.com/guanguans/laravel-soar)、[laravel-web-soar](https://github.com/huangdijia/laravel-web-soar)
- [x] ThinkPHP - [think-soar](https://github.com/guanguans/think-soar)
- [x] Hyperf - [hyperf-soar](https://github.com/wilbur-oo/hyperf-soar)
- [x] Webman - [webman-soar](https://github.com/Tinywan/webman-soar)
- [ ] Yii2
- [ ] Symfony
- [ ] Slim

## Installation

```shell
composer require guanguans/soar-php --ansi -v
```

## Usage

<details>
<summary><b>Quick start</b></summary>

```php
<?php

declare(strict_types=1);

require __DIR__.'/vendor/autoload.php';

use Guanguans\SoarPHP\Soar;

$queries = [
    <<<'QUERY'
        SELECT
            DATE_FORMAT (t.last_update, '%Y-%m-%d'),
            COUNT(DISTINCT (t.city))
        FROM
            city t
        WHERE
            t.last_update > '2018-10-22 00:00:00'
            AND t.city LIKE '%Chrome%'
            AND t.city = 'eip'
        GROUP BY
            DATE_FORMAT(t.last_update, '%Y-%m-%d')
        ORDER BY
            DATE_FORMAT(t.last_update, '%Y-%m-%d');
        QUERY,
    'SELECT * FROM `foo`;',
];

/**
 * Examples of scoring.
 */
$scores = Soar::make()->arrayScores($queries); // Basic scoring
dump($scores);

$scores = Soar::make() // Advanced scoring
    ->withTestDsn([
        'user' => 'you_user',
        'password' => 'you_password',
        'addr' => 'you_host:you_port',
        // 'host' => 'you_host',
        // 'port' => 'you_port',
        'schema' => 'you_dbname',
        // 'disable' => false,
    ])
    ->withOnlineDsn([
        'user' => 'you_user',
        'password' => 'you_password',
        // 'addr' => 'you_host:you_port',
        'host' => 'you_host',
        'port' => 'you_port',
        'schema' => 'you_dbname',
        'disable' => true,
    ])
    ->withExplain(true) // Enable EXPLAIN
    ->withAllowOnlineAsTest(true) // Enable index suggestions
    ->arrayScores($queries);

/**
 * Examples of running any soar command.
 */
// Final run: '/.../bin/soar.darwin-arm64' '-report-type=fingerprint' '-query=SELECT * FROM `foo`;'
$fingerprint = Soar::make()->withReportType('fingerprint')->withQuery($queries[1])->run();

// Final run: '/.../bin/soar.darwin-arm64' '-report-type=pretty' '-query=SELECT * FROM `foo`;'
$pretty = Soar::make()->withReportType('pretty')->withQuery($queries[1])->run();

// Final run: '/.../bin/soar.darwin-arm64' '-version=true'
$version = Soar::make()->withHelp(true)->setVersion(true)->run();

// Final run: '/.../bin/soar.darwin-arm64' '-only-syntax-check=true' '-query=SELECT * FROM `foo`;'
// $syntaxCheck = Soar::make()->withOnlySyntaxCheck(true)->withQuery('SELECT * FRO `foo`;')->run();
$syntaxCheck = Soar::make()->withOnlySyntaxCheck(true)->withQuery('SELECT * FROM `foo`;')->run();
```
</details>

<details>
<summary><b>SQL Scores(Fingerprint、Score、Explain、Heuristic suggestions、Index suggestions)</b></summary>

```php
$queries = <<<'QUERIES'
SELECT * FROM users;
SELECT DATE_FORMAT (t.last_update,'%Y-%m-%d'),COUNT (DISTINCT (t.city)) FROM city t WHERE t.last_update> '2018-10-22 00:00:00' AND t.city LIKE '%Chrome%' AND t.city='eip' GROUP BY DATE_FORMAT(t.last_update,'%Y-%m-%d') ORDER BY DATE_FORMAT(t.last_update,'%Y-%m-%d');
DELETE city FROM city LEFT JOIN country ON city.country_id=country.country_id WHERE country.country IS NULL;
UPDATE city INNER JOIN country ON city.country_id=country.country_id INNER JOIN address ON city.city_id=address.city_id SET city.city='Abha',city.last_update='2006-02-15 04:45:25',country.country='Afghanistan' WHERE city.city_id=10;
INSERT INTO city (country_id) SELECT country_id FROM country;
REPLACE INTO city (country_id) SELECT country_id FROM country;
ALTER TABLE inventory ADD INDEX `idx_store_film` (`store_id`,`film_id`),ADD INDEX `idx_store_film` (`store_id`,`film_id`),ADD INDEX `idx_store_film` (`store_id`,`film_id`);
DROP TABLE `users`;
CREATE TABLE `users` (
  `id` bigint unsigned NOT NULL AUTO_INCREMENT,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `email_verified_at` timestamp NULL DEFAULT NULL,
  `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `users_email_unique` (`email`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;
QUERIES;

$soar->scores($queries);
$soar->htmlScores($queries);
$soar->markdownScores($queries);
$soar->arrayScores($queries);
$soar->jsonScores($queries);
```

```php
array:9 [
  0 => array:8 [
    "ID" => "30AFCB1E1344BEBD"
    "Fingerprint" => "select * from users"
    "Score" => 80
    "Sample" => "SELECT * FROM users"
    "Explain" => array:1 [
      0 => array:6 [
        "Item" => "EXP.000"
        "Severity" => "L0"
        "Summary" => "Explain信息"
        "Content" => """
          | id | select\_type | table | partitions | type | possible_keys | key | key\_len | ref | rows | filtered | scalability | Extra |\n
          |---|---|---|---|---|---|---|---|---|---|---|---|---|\n
          | 1  | SIMPLE | *users* | NULL | ALL | NULL | NULL | NULL | NULL | 1 | ☠️ **100.00%** | ☠️ **O(n)** | NULL |\n
          \n
          """
        "Case" => """
          ### Explain信息解读\n
          \n
          #### SelectType信息解读\n
          \n
          * **SIMPLE**: 简单SELECT(不使用UNION或子查询等).\n
          \n
          #### Type信息解读\n
          \n
          * ☠️ **ALL**: 最坏的情况, 从头到尾全表扫描.\n
          """
        "Position" => 0
      ]
    ]
    "HeuristicRules" => array:1 [
      0 => array:6 [
        "Item" => "CLA.001"
        "Severity" => "L4"
        "Summary" => "最外层 SELECT 未指定 WHERE 条件"
        "Content" => "SELECT 语句没有 WHERE 子句，可能检查比预期更多的行(全表扫描)。对于 SELECT COUNT(*) 类型的请求如果不要求精度，建议使用 SHOW TABLE STATUS 或 EXPLAIN 替代。"
        "Case" => "select id from tbl"
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => array:1 [
      0 => "`laravel`.`users`"
    ]
  ]
  1 => array:8 [
    "ID" => "23D3498A40F9900D"
    "Fingerprint" => "select date_format (t.last_update,?),count (distinct (t.city)) from city t where t.last_update> ? and t.city like ? and t.city=? group by date_format(t.last_update,?) order by date_format(t.last_update,?)"
    "Score" => 0
    "Sample" => "SELECT DATE_FORMAT (t.last_update,'%Y-%m-%d'),COUNT (DISTINCT (t.city)) FROM city t WHERE t.last_update> '2018-10-22 00:00:00' AND t.city LIKE '%Chrome%' AND t.city='eip' GROUP BY DATE_FORMAT(t.last_update,'%Y-%m-%d') ORDER BY DATE_FORMAT(t.last_update,'%Y-%m-%d')"
    "Explain" => null
    "HeuristicRules" => array:7 [
      0 => array:6 [
        "Item" => "ALI.001"
        "Severity" => "L0"
        "Summary" => "建议使用 AS 关键字显示声明一个别名"
        "Content" => "在列或表别名(如"tbl AS alias")中, 明确使用 AS 关键字比隐含别名(如"tbl alias")更易懂。"
        "Case" => "select name from tbl t1 where id < 1000"
        "Position" => 0
      ]
      1 => array:6 [
        "Item" => "ARG.001"
        "Severity" => "L4"
        "Summary" => "不建议使用前项通配符查找"
        "Content" => "例如 "％foo"，查询参数有一个前项通配符的情况无法使用已有索引。"
        "Case" => "select c1,c2,c3 from tbl where name like '%foo'"
        "Position" => 0
      ]
      2 => array:6 [
        "Item" => "CLA.009"
        "Severity" => "L2"
        "Summary" => "ORDER BY 的条件为表达式"
        "Content" => "当 ORDER BY 条件为表达式或函数时会使用到临时表，如果在未指定 WHERE 或 WHERE 条件返回的结果集较大时性能会很差。"
        "Case" => "select description from film where title ='ACADEMY DINOSAUR' order by length-language_id;"
        "Position" => 0
      ]
      3 => array:6 [
        "Item" => "CLA.010"
        "Severity" => "L2"
        "Summary" => "GROUP BY 的条件为表达式"
        "Content" => "当 GROUP BY 条件为表达式或函数时会使用到临时表，如果在未指定 WHERE 或 WHERE 条件返回的结果集较大时性能会很差。"
        "Case" => "select description from film where title ='ACADEMY DINOSAUR' GROUP BY length-language_id;"
        "Position" => 0
      ]
      4 => array:6 [
        "Item" => "ERR.000"
        "Severity" => "L8"
        "Summary" => "No available MySQL environment, build-in sql parse failed: line 1 column 61 near "DISTINCT (t.city)) FROM city t WHERE t.last_update> '2018-10-22 00:00:00' AND t.city LIKE '%Chrome%' AND t.city='eip' GROUP BY DATE_FORMAT(t.last_update,'%Y-%m-%d') ORDER BY DATE_FORMAT(t.last_update,'%Y-%m-%d')" "
        "Content" => "line 1 column 61 near "DISTINCT (t.city)) FROM city t WHERE t.last_update> '2018-10-22 00:00:00' AND t.city LIKE '%Chrome%' AND t.city='eip' GROUP BY DATE_FORMAT(t.last_update,'%Y-%m-%d') ORDER BY DATE_FORMAT(t.last_update,'%Y-%m-%d')" "
        "Case" => ""
        "Position" => 0
      ]
      5 => array:6 [
        "Item" => "ERR.002"
        "Severity" => "L8"
        "Summary" => "MySQL execute failed"
        "Content" => "You have an error in your SQL syntax; check the manual that corresponds to your MySQL server version for the right syntax to use near 'DISTINCT (t.city)) FROM city t WHERE t.last_update> '2018-10-22 00:00:00' AND t.' at line 1"
        "Case" => ""
        "Position" => 0
      ]
      6 => array:6 [
        "Item" => "KEY.008"
        "Severity" => "L4"
        "Summary" => "ORDER BY 多个列但排序方向不同时可能无法使用索引"
        "Content" => "在 MySQL 8.0 之前当 ORDER BY 多个列指定的排序方向不同时将无法使用已经建立的索引。"
        "Case" => "SELECT * FROM tbl ORDER BY a DESC, b ASC;"
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => null
  ]
  2 => array:8 [
    "ID" => "E759EFCE5B432198"
    "Fingerprint" => "delete city from city left join country on city.country_id=country.country_id where country.country is null"
    "Score" => 80
    "Sample" => "DELETE city FROM city LEFT JOIN country ON city.country_id=country.country_id WHERE country.country IS NULL"
    "Explain" => null
    "HeuristicRules" => array:2 [
      0 => array:6 [
        "Item" => "JOI.007"
        "Severity" => "L4"
        "Summary" => "不建议使用联表删除或更新"
        "Content" => "当需要同时删除或更新多张表时建议使用简单语句，一条 SQL 只删除或更新一张表，尽量不要将多张表的操作在同一条语句。"
        "Case" => "UPDATE users u LEFT JOIN hobby h ON u.id = h.uid SET u.name = 'pianoboy' WHERE h.hobby = 'piano';"
        "Position" => 0
      ]
      1 => array:6 [
        "Item" => "SEC.003"
        "Severity" => "L0"
        "Summary" => "使用DELETE/DROP/TRUNCATE等操作时注意备份"
        "Content" => "在执行高危操作之前对数据进行备份是十分有必要的。"
        "Case" => "delete from table where col = 'condition'"
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => array:2 [
      0 => "`laravel`.`city`"
      1 => "`laravel`.`country`"
    ]
  ]
  3 => array:8 [
    "ID" => "67B0C3CE9FA26F37"
    "Fingerprint" => "update city inner join country on city.country_id=country.country_id inner join address on city.city_id=address.city_id set city.city=?,city.last_update=?,country.country=? where city.city_id=?"
    "Score" => 80
    "Sample" => "UPDATE city INNER JOIN country ON city.country_id=country.country_id INNER JOIN address ON city.city_id=address.city_id SET city.city='Abha',city.last_update='2006-02-15 04:45:25',country.country='Afghanistan' WHERE city.city_id=10"
    "Explain" => null
    "HeuristicRules" => array:1 [
      0 => array:6 [
        "Item" => "JOI.007"
        "Severity" => "L4"
        "Summary" => "不建议使用联表删除或更新"
        "Content" => "当需要同时删除或更新多张表时建议使用简单语句，一条 SQL 只删除或更新一张表，尽量不要将多张表的操作在同一条语句。"
        "Case" => "UPDATE users u LEFT JOIN hobby h ON u.id = h.uid SET u.name = 'pianoboy' WHERE h.hobby = 'piano';"
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => array:3 [
      0 => "`laravel`.`address`"
      1 => "`laravel`.`city`"
      2 => "`laravel`.`country`"
    ]
  ]
  4 => array:8 [
    "ID" => "3656B13CC4F888E2"
    "Fingerprint" => "insert into city (country_id) select country_id from country"
    "Score" => 65
    "Sample" => "INSERT INTO city (country_id) SELECT country_id FROM country"
    "Explain" => null
    "HeuristicRules" => array:2 [
      0 => array:6 [
        "Item" => "CLA.001"
        "Severity" => "L4"
        "Summary" => "最外层 SELECT 未指定 WHERE 条件"
        "Content" => "SELECT 语句没有 WHERE 子句，可能检查比预期更多的行(全表扫描)。对于 SELECT COUNT(*) 类型的请求如果不要求精度，建议使用 SHOW TABLE STATUS 或 EXPLAIN 替代。"
        "Case" => "select id from tbl"
        "Position" => 0
      ]
      1 => array:6 [
        "Item" => "LCK.001"
        "Severity" => "L3"
        "Summary" => "INSERT INTO xx SELECT 加锁粒度较大请谨慎"
        "Content" => "INSERT INTO xx SELECT 加锁粒度较大请谨慎"
        "Case" => "INSERT INTO tbl SELECT * FROM tbl2;"
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => array:2 [
      0 => "`laravel`.`city`"
      1 => "`laravel`.`country`"
    ]
  ]
  5 => array:8 [
    "ID" => "E3DDA1A929236E72"
    "Fingerprint" => "replace into city (country_id) select country_id from country"
    "Score" => 65
    "Sample" => "REPLACE INTO city (country_id) SELECT country_id FROM country"
    "Explain" => null
    "HeuristicRules" => array:2 [
      0 => array:6 [
        "Item" => "CLA.001"
        "Severity" => "L4"
        "Summary" => "最外层 SELECT 未指定 WHERE 条件"
        "Content" => "SELECT 语句没有 WHERE 子句，可能检查比预期更多的行(全表扫描)。对于 SELECT COUNT(*) 类型的请求如果不要求精度，建议使用 SHOW TABLE STATUS 或 EXPLAIN 替代。"
        "Case" => "select id from tbl"
        "Position" => 0
      ]
      1 => array:6 [
        "Item" => "LCK.001"
        "Severity" => "L3"
        "Summary" => "INSERT INTO xx SELECT 加锁粒度较大请谨慎"
        "Content" => "INSERT INTO xx SELECT 加锁粒度较大请谨慎"
        "Case" => "INSERT INTO tbl SELECT * FROM tbl2;"
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => array:2 [
      0 => "`laravel`.`city`"
      1 => "`laravel`.`country`"
    ]
  ]
  6 => array:8 [
    "ID" => "9BB74D074BA0727C"
    "Fingerprint" => "alter table inventory add index `idx_store_film` (`store_id`,`film_id`),add index `idx_store_film` (`store_id`,`film_id`),add index `idx_store_film` (`store_id`,`film_id`)"
    "Score" => 100
    "Sample" => "ALTER TABLE inventory ADD INDEX `idx_store_film` (`store_id`,`film_id`),ADD INDEX `idx_store_film` (`store_id`,`film_id`),ADD INDEX `idx_store_film` (`store_id`,`film_id`)"
    "Explain" => null
    "HeuristicRules" => array:1 [
      0 => array:6 [
        "Item" => "KEY.004"
        "Severity" => "L0"
        "Summary" => "提醒：请将索引属性顺序与查询对齐"
        "Content" => "如果为列创建复合索引，请确保查询属性与索引属性的顺序相同，以便DBMS在处理查询时使用索引。如果查询和索引属性订单没有对齐，那么DBMS可能无法在查询处理期间使用索引。"
        "Case" => "create index idx1 on tbl (last_name,first_name)"
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => array:1 [
      0 => "`laravel`.`inventory`"
    ]
  ]
  7 => array:8 [
    "ID" => "C77607894B4EFCC6"
    "Fingerprint" => "drop table `users`"
    "Score" => 100
    "Sample" => "DROP TABLE `users`"
    "Explain" => null
    "HeuristicRules" => array:1 [
      0 => array:6 [
        "Item" => "SEC.003"
        "Severity" => "L0"
        "Summary" => "使用DELETE/DROP/TRUNCATE等操作时注意备份"
        "Content" => "在执行高危操作之前对数据进行备份是十分有必要的。"
        "Case" => "delete from table where col = 'condition'"
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => array:1 [
      0 => "`laravel`.`users`"
    ]
  ]
  8 => array:8 [
    "ID" => "D0870E395F2CA834"
    "Fingerprint" => "create table `users` ( `id` bigint unsigned not null auto_increment, `name` varchar(?) collate utf8mb4_unicode_ci not ?, `email` varchar(?) collate utf8mb4_unicode_ci not ?, `email_verified_at` timestamp ? default ?, `password` varchar(?) collate utf8mb4_unicode_ci not ?, `remember_token` varchar(?) collate utf8mb4_unicode_ci default ?, `created_at` timestamp ? default ?, `updated_at` timestamp ? default ?, primary key (`id`), unique key `users_email_unique` (`email`) ) engine=innodb default charset=utf8mb4 collate=utf8mb4_unicode_ci"
    "Score" => 75
    "Sample" => """
      CREATE TABLE `users` (\n
        `id` bigint unsigned NOT NULL AUTO_INCREMENT,\n
        `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n
        `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n
        `email_verified_at` timestamp NULL DEFAULT NULL,\n
        `password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,\n
        `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,\n
        `created_at` timestamp NULL DEFAULT NULL,\n
        `updated_at` timestamp NULL DEFAULT NULL,\n
        PRIMARY KEY (`id`),\n
        UNIQUE KEY `users_email_unique` (`email`)\n
      ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci
      """
    "Explain" => null
    "HeuristicRules" => array:7 [
      0 => array:6 [
        "Item" => "CLA.011"
        "Severity" => "L1"
        "Summary" => "建议为表添加注释"
        "Content" => "为表添加注释能够使得表的意义更明确，从而为日后的维护带来极大的便利。"
        "Case" => "CREATE TABLE `test1` (`ID` bigint(20) NOT NULL AUTO_INCREMENT,`c1` varchar(128) DEFAULT NULL,PRIMARY KEY (`ID`)) ENGINE=InnoDB DEFAULT CHARSET=utf8"
        "Position" => 0
      ]
      1 => array:6 [
        "Item" => "COL.004"
        "Severity" => "L1"
        "Summary" => "请为列添加默认值"
        "Content" => "请为列添加默认值，如果是 ALTER 操作，请不要忘记将原字段的默认值写上。字段无默认值，当表较大时无法在线变更表结构。"
        "Case" => "CREATE TABLE tbl (col int) ENGINE=InnoDB;"
        "Position" => 0
      ]
      2 => array:6 [
        "Item" => "COL.005"
        "Severity" => "L1"
        "Summary" => "列未添加注释"
        "Content" => "建议对表中每个列添加注释，来明确每个列在表中的含义及作用。"
        "Case" => "CREATE TABLE tbl (col int) ENGINE=InnoDB;"
        "Position" => 0
      ]
      3 => array:6 [
        "Item" => "COL.011"
        "Severity" => "L0"
        "Summary" => "当需要唯一约束时才使用 NULL，仅当列不能有缺失值时才使用 NOT NULL"
        "Content" => "NULL 和0是不同的，10乘以 NULL 还是 NULL。NULL 和空字符串是不一样的。将一个字符串和标准 SQL 中的 NULL 联合起来的结果还是 NULL。NULL 和 FALSE 也是不同的。AND、OR 和 NOT 这三个布尔操作如果涉及 NULL，其结果也让很多人感到困惑。当您将一列声明为 NOT NULL 时，也就是说这列中的每一个值都必须存在且是有意义的。使用 NULL 来表示任意类型不存在的空值。 当您将一列声明为 NOT NULL 时，也就是说这列中的每一个值都必须存在且是有意义的。"
        "Case" => "select c1,c2,c3 from tbl where c4 is null or c4 <> 1"
        "Position" => 49
      ]
      4 => array:6 [
        "Item" => "KWR.003"
        "Severity" => "L1"
        "Summary" => "不建议使用复数做列名或表名"
        "Content" => "表名应该仅仅表示表里面的实体内容，不应该表示实体数量，对应于 DO 类名也是单数形式，符合表达习惯。"
        "Case" => "CREATE TABLE tbl ( `books` int )"
        "Position" => 0
      ]
      5 => array:6 [
        "Item" => "SEC.002"
        "Severity" => "L0"
        "Summary" => "不使用明文存储密码"
        "Content" => "使用明文存储密码或者使用明文在网络上传递密码都是不安全的。如果攻击者能够截获您用来插入密码的SQL语句，他们就能直接读到密码。另外，将用户输入的字符串以明文的形式插入到纯SQL语句中，也会让攻击者发现它。如果您能够读取密码，黑客也可以。解决方案是使用单向哈希函数对原始密码进行加密编码。哈希是指将输入字符串转化成另一个新的、不可识别的字符串的函数。对密码加密表达式加点随机串来防御“字典攻击”。不要将明文密码输入到SQL查询语句中。在应用程序代码中计算哈希串，只在SQL查询中使用哈希串。"
        "Case" => "create table test(id int,name varchar(20) not null,password varchar(200)not null)"
        "Position" => 0
      ]
      6 => array:6 [
        "Item" => "STA.003"
        "Severity" => "L1"
        "Summary" => "索引起名不规范"
        "Content" => "建议普通二级索引以idx_为前缀，唯一索引以uk_为前缀。"
        "Case" => "select col from now where type!=0"
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => array:1 [
      0 => "`laravel`.`users`"
    ]
  ]
]
```

![](docs/scores.png)
</details>

<details>
<summary><b>:warning: When running in a unix OS non-cli environment, may throw `Fatal error: ...Exit Code: 2(Misuse of shell builtins)...`</b></summary>

### Configure sudo password

```php
// Fatal error: Uncaught Symfony\Component\Process\Exception\ProcessFailedException: The command "'/Users/yaozm/Documents/develop/soar-php/bin/soar.darwin-arm64' '-report-type=json' '-query=SELECT * FROM `foo`;'" failed. Exit Code: 2(Misuse of shell builtins) Working directory: /Users/yaozm/Documents/develop/soar-php Output: ================ Error Output: ================ panic: runtime error: invalid memory address or nil pointer dereference [signal SIGSEGV: segmentation violation code=0x2 addr=0x0 pc=0x104d22798] goroutine 1 [running]: github.com/pingcap/tidb/util/memory.MemTotalNormal() pkg/mod/github.com/pingcap/tidb@v1.1.0-beta.0.20210601085537-5d7c852770eb/util/memory/meminfo.go:41 +0x68 github.com/pingcap/tidb/util/memory.init.0() pkg/mod/github.com/pingcap/tidb@v1.1.0-beta.0.20210601085537-5d7c852770eb/util/memory/meminfo.go:134 +0x184 in /Users/yaozm/Documents/develop/soar-php/vendor/symfony/process/Process.php:273
$soar->withSudoPassword('your sudo password'); // With a sudo password to run the soar command with sudo to avoid the above errors.
```

### Or configure sudoers

> On higher versions of macOS, it is possible that the fingerprint authentication window will pop up. You can configure sudoers to run `soar` command without password.

1. Edit Configuration file of sudoers:

```shell
sudo visudo
```

2. Add rule [`{user name} ALL=(ALL) NOPASSWD: {soar binary(You can find it from the exception message.)}`]:

```shell
guanguans ALL=(ALL) NOPASSWD: /Users/guanguans/Documents/develop/soar-php/bin/soar.darwin-arm64
```
</details>

## Composer scripts

```shell
composer benchmark
composer checks:required
composer soar:example-run
composer soar:example-serve
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

* [guanguans](https://github.com/guanguans)
* [All Contributors](../../contributors)

## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="https://github.com/kamly"><img src="https://avatars2.githubusercontent.com/u/15706085?v=4?s=100" width="100px;" alt=""/><br /><sub><b>kamly</b></sub></a><br /><a href="https://github.com/guanguans/soar-php/issues?q=author%3Akamly" title="Bug reports">🐛</a></td>
    <td align="center"><a href="https://github.com/leslieeilsel"><img src="https://avatars1.githubusercontent.com/u/25165449?v=4?s=100" width="100px;" alt=""/><br /><sub><b>Leslie Lau</b></sub></a><br /><a href="https://github.com/guanguans/soar-php/issues?q=author%3Aleslieeilsel" title="Bug reports">🐛</a></td>
    <td align="center"><a href="https://github.com/huangdijia"><img src="https://avatars1.githubusercontent.com/u/8337659?v=4?s=100" width="100px;" alt=""/><br /><sub><b>D.J.Hwang</b></sub></a><br /><a href="#ideas-huangdijia" title="Ideas, Planning, & Feedback">🤔</a></td>
    <td align="center"><a href="https://github.com/zhonghaibin"><img src="https://avatars.githubusercontent.com/u/22255693?v=4?s=100" width="100px;" alt=""/><br /><sub><b>海彬</b></sub></a><br /><a href="https://github.com/guanguans/soar-php/issues?q=author%3Azhonghaibin" title="Bug reports">🐛</a></td>
    <td align="center"><a href="https://github.com/Aexus"><img src="https://avatars.githubusercontent.com/u/3403478?v=4?s=100" width="100px;" alt=""/><br /><sub><b>imcm</b></sub></a><br /><a href="#ideas-Aexus" title="Ideas, Planning, & Feedback">🤔</a></td>
  </tr>
</table>

<!-- markdownlint-restore -->
<!-- prettier-ignore-end -->

<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!

## License

The MIT License (MIT). Please see [License File](LICENSE) for more information.
