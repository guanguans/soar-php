# soar-php

> SQL optimizer and rewriter (assisted SQL tuning) developed based on Xiaomi's [soar](https://github.com/XiaoMi/soar).

[简体中文](README.md) | [ENGLISH](README-EN.md)

[![tests](https://github.com/guanguans/soar-php/actions/workflows/tests.yml/badge.svg)](https://github.com/guanguans/soar-php/actions/workflows/tests.yml)
[![check & fix styling](https://github.com/guanguans/soar-php/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/soar-php/actions/workflows/php-cs-fixer.yml)
[![codecov](https://codecov.io/gh/guanguans/soar-php/branch/master/graph/badge.svg)](https://codecov.io/gh/guanguans/soar-php)
[![Total Downloads](https://poser.pugx.org/guanguans/soar-php/downloads)](https://packagist.org/packages/guanguans/soar-php)
[![Latest Stable Version](https://poser.pugx.org/guanguans/soar-php/v/stable)](https://packagist.org/packages/guanguans/soar-php)
[![License](https://poser.pugx.org/guanguans/soar-php/license)](https://packagist.org/packages/guanguans/soar-php)

## Requirements

* PHP >= 7.2
* ext-json
* ext-mbstring

## Used in the framework

- [x] Laravel - [laravel-soar](https://github.com/guanguans/laravel-soar), [laravel-web-soar](https://github.com/huangdijia/laravel-web-soar)
- [x] ThinkPHP - [think-soar](https://github.com/guanguans/think-soar)
- [x] Hyperf - [hyperf-soar](https://github.com/wilbur-oo/hyperf-soar)
- [x] Webman - [webman-soar](https://github.com/Tinywan/webman-soar)
- [ ] Yii2
- [ ] Symfony
- [ ] Slim

## Installation

```shell
composer require guanguans/soar-php -vvv
```

## Usage

<details>
<summary><b>Quick start</b></summary>

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Guanguans\SoarPHP\Soar;

// Quickly create a soar instance
$soar = Soar::create();

/**
 * Create a custom soar instance
 * Options @see examples/soar.options.example.php
 */
$soar = Soar::create(
    [
        // 测试环境数据库配置.
        '-test-dsn'    => [
            'host'     => '127.0.0.1',
            'port'     => '3306',
            'dbname'   => 'laravel',
            'username' => 'root',
            'password' => 'root',
            'disable'  => false,
        ],
        // 日志输出位置 (default "soar.log").
        '-log-output'  => __DIR__.'/logs/soar.log',
        // 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown").
        '-report-type' => 'json',
    ],
    '自定义的 soar 路径'
);

// Final run: /Users/yaozm/Documents/develop/soar-php/bin/soar.darwin-amd64 '-version=true'
$soar->clone() // Clone soar and avoid the option to manipulate the original soar.
    ->addVersion(true) // Add -version value of the option is `true`
    ->addVerbose(true) // Add -verbose value of the option is `true`
    ->removeVersion()  // Remove -version option
    ->setVersion(true) // Set -version value of the option is `true`
    ->mergeVersion(true) // Merge -version value of the option is `true`
    ->onlyVersion() // Only keep -version option
    ->dump() // Dump debug information
    ->run(); // Run
```
</details>

<details>
<summary><b>SQL Scores(SQL fingerprint、Score、Explain interpretation、Heuristic rule suggestions、Index rule suggestions)</b></summary>

```php
$sqls = <<<'sql'
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
sql;

$soar->scores($sqls);
$soar->htmlScores($sqls);
$soar->markdownScores($sqls);
$soar->arrayScores($sqls);
$soar->jsonScores($sqls);
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
<summary><b>soar help</b></summary>

```php
$soar->help()
```

```plain
Usage of /Users/yaozm/Documents/develop/soar-php/bin/soar.darwin-amd64:
  -allow-charsets string
    	AllowCharsets (default "utf8,utf8mb4")
  -allow-collates string
    	AllowCollates
  -allow-drop-index
    	AllowDropIndex, 允许输出删除重复索引的建议
  -allow-engines string
    	AllowEngines (default "innodb")
  -allow-online-as-test
    	AllowOnlineAsTest, 允许线上环境也可以当作测试环境
  -blacklist string
    	指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
  -check-config
    	Check configs
  -cleanup-test-database
    	单次运行清理历史1小时前残余的测试库。
  -column-not-allow-type string
    	ColumnNotAllowType (default "boolean")
  -config string
    	Config file path
  -delimiter string
    	Delimiter, SQL分隔符 (default ";")
  -drop-test-temporary
    	DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
  -dry-run
    	是否在预演环境执行 (default true)
  -explain
    	Explain, 是否开启Explain执行计划分析 (default true)
  -explain-format string
    	ExplainFormat [json, traditional] (default "traditional")
  -explain-max-filtered float
    	ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
  -explain-max-keys int
    	ExplainMaxKeyLength, 最大key_len (default 3)
  -explain-max-rows int
    	ExplainMaxRows, 最大扫描行数警告 (default 10000)
  -explain-min-keys int
    	ExplainMinPossibleKeys, 最小possible_keys警告
  -explain-sql-report-type string
    	ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
  -explain-type string
    	ExplainType [extended, partitions, traditional] (default "extended")
  -explain-warn-access-type string
    	ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
  -explain-warn-extra string
    	ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
  -explain-warn-scalability string
    	ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
  -explain-warn-select-type string
    	ExplainWarnSelectType, 哪些select_type不建议使用
  -ignore-rules string
    	IgnoreRules, 忽略的优化建议规则 (default "COL.011")
  -index-prefix string
    	IdxPrefix (default "idx_")
  -list-heuristic-rules
    	ListHeuristicRules, 打印支持的评审规则列表
  -list-report-types
    	ListReportTypes, 打印支持的报告输出类型
  -list-rewrite-rules
    	ListRewriteRules, 打印支持的重写规则列表
  -list-test-sqls
    	ListTestSqls, 打印测试case用于测试
  -log-level int
    	LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
  -log-output string
    	LogOutput, 日志输出位置 (default "soar.log")
  -log_err_stacks
    	log stack traces for errors
  -log_rotate_max_size uint
    	size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
  -markdown-extensions int
    	MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
  -markdown-html-flags int
    	MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
  -max-column-count int
    	MaxColCount, 单表允许的最大列数 (default 40)
  -max-distinct-count int
    	MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
  -max-group-by-cols-count int
    	MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
  -max-in-count int
    	MaxInCount, IN()最大数量 (default 10)
  -max-index-bytes int
    	MaxIdxBytes, 索引总长度限制 (default 3072)
  -max-index-bytes-percolumn int
    	MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
  -max-index-cols-count int
    	MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
  -max-index-count int
    	MaxIdxCount, 单表最大索引个数 (default 10)
  -max-join-table-count int
    	MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
  -max-pretty-sql-length int
    	MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
  -max-query-cost int
    	MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
  -max-subquery-depth int
    	MaxSubqueryDepth (default 5)
  -max-text-cols-count int
    	MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
  -max-total-rows uint
    	MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
  -max-value-count int
    	MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
  -max-varchar-length int
    	MaxVarcharLength (default 1024)
  -min-cardinality float
    	MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
  -online-dsn string
    	OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
  -only-syntax-check
    	OnlySyntaxCheck, 只做语法检查不输出优化建议
  -print-config
    	Print configs
  -profiling
    	Profiling, 开启数据采样的情况下在测试环境执行Profile
  -query string
    	待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
  -report-css string
    	ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
  -report-javascript string
    	ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
  -report-title string
    	ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
  -report-type string
    	ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
  -rewrite-rules string
    	RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
  -sampling
    	Sampling, 数据采样开关
  -sampling-condition string
    	SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
  -sampling-statistic-target int
    	SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
  -show-last-query-cost
    	ShowLastQueryCost
  -show-warnings
    	ShowWarnings
  -spaghetti-query-length int
    	SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
  -test-dsn string
    	TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
  -trace
    	Trace, 开启数据采样的情况下在测试环境执行Trace
  -unique-key-prefix string
    	UkPrefix (default "uk_")
  -verbose
    	Verbose
  -version
    	Print version info
```
</details>

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](.github/CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore-start -->
<!-- markdownlint-disable -->
<table>
  <tr>
    <td align="center"><a href="http://blog.charmingkamly.cn"><img src="https://avatars2.githubusercontent.com/u/15706085?v=4?s=100" width="100px;" alt=""/><br /><sub><b>kamly</b></sub></a><br /><a href="https://github.com/guanguans/soar-php/issues?q=author%3Akamly" title="Bug reports">🐛</a></td>
    <td align="center"><a href="http://leslieeilsel.com/"><img src="https://avatars1.githubusercontent.com/u/25165449?v=4?s=100" width="100px;" alt=""/><br /><sub><b>Leslie Lau</b></sub></a><br /><a href="https://github.com/guanguans/soar-php/issues?q=author%3Aleslieeilsel" title="Bug reports">🐛</a></td>
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
