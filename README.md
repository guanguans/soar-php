# soar-php

> 基于小米的 [soar](https://github.com/XiaoMi/soar) 开发的 SQL 优化器、重写器(辅助 SQL 调优)。

[简体中文](README.md) | [ENGLISH](README-EN.md)

[![tests](https://github.com/guanguans/soar-php/actions/workflows/tests.yml/badge.svg)](https://github.com/guanguans/soar-php/actions/workflows/tests.yml)
[![check & fix styling](https://github.com/guanguans/soar-php/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/soar-php/actions/workflows/php-cs-fixer.yml)
[![codecov](https://codecov.io/gh/guanguans/soar-php/branch/master/graph/badge.svg)](https://codecov.io/gh/guanguans/soar-php)
[![Total Downloads](https://poser.pugx.org/guanguans/soar-php/downloads)](https://packagist.org/packages/guanguans/soar-php)
[![Latest Stable Version](https://poser.pugx.org/guanguans/soar-php/v/stable)](https://packagist.org/packages/guanguans/soar-php)
[![License](https://poser.pugx.org/guanguans/soar-php/license)](https://packagist.org/packages/guanguans/soar-php)

## 环境要求

* PHP >= 7.2
* ext-json
* ext-mbstring
* ext-pdo

## 框架中使用

- [x] Laravel - [laravel-soar](https://github.com/guanguans/laravel-soar), [laravel-web-soar](https://github.com/huangdijia/laravel-web-soar)
- [x] ThinkPHP - [think-soar](https://github.com/guanguans/think-soar)
- [x] Hyperf - [hyperf-soar](https://github.com/wilbur-oo/hyperf-soar)
- [x] Webman - [webman-soar](https://github.com/Tinywan/webman-soar)
- [ ] Yii2
- [ ] Symfony
- [ ] Slim

## 安装

```shell
composer require guanguans/soar-php -vvv
```

## 使用

<details>
<summary><b>创建 soar 实例</b></summary>

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Guanguans\SoarPHP\Soar;

$soar = Soar::create();

/**
 * 配置选项(可选)参考 @see soar.config.example.php
 */
$soar->setSoarPath('自定义的 soar 路径')
    ->setOptions([
        // 测试环境配置
        '-test-dsn'    => [
            'host'     => '127.0.0.1',
            'port'     => '3306',
            'dbname'   => 'database',
            'username' => 'root',
            'password' => '123456',
            'disable'  => false,
        ],
        // 日志输出文件
        '-log-output'  => __DIR__.'/logs/soar.log',
        // 报告输出格式: [markdown, html, json, ...]
        '-report-type' => 'html',
    ]);
```
</details>

<details>
<summary><b>SQL 评分、Explain 信息解读</b></summary>

```php
$sql = <<<sql
SELECT*FROM admin_users JOIN admin_role_users ON admin_users.id=admin_role_users.user_id JOIN admin_roles ON admin_roles.id=admin_role_users.role_id;
SELECT \ tDATE_FORMAT (t.last_update,'%Y-%m-%d'),\ tCOUNT (DISTINCT (t.city)) \ tFROM city t WHERE t.last_update> '2018-10-22 00:00:00' \ tAND t.city LIKE '%Chrome%' \ tAND t.city='eip' GROUP BY DATE_FORMAT(t.last_update,'%Y-%m-%d') ORDER BY DATE_FORMAT(t.last_update,'%Y-%m-%d'); 
SELECT maxId,minId FROM (SELECT max(film_id) maxId,min(film_id) minId FROM film WHERE last_update> '2016-03-27 02:01:01') AS d; 
DELETE city FROM city LEFT JOIN country ON city.country_id=country.country_id WHERE country.country IS NULL; 
UPDATE city INNER JOIN country USING (country_id) SET city.city='Abha',city.last_update='2006-02-15 04:45:25',country.country='Afghanistan' WHERE city.city_id=10; 
REPLACE INTO city (country_id) SELECT country_id FROM country;
ALTER TABLE inventory ADD INDEX `idx_store_film` (`store_id`,`film_id`),ADD INDEX `idx_store_film` (`store_id`,`film_id`),ADD INDEX `idx_store_film` (`store_id`,`film_id`); 
CREATE TABLE hello.t (id INT UNSIGNED);
sql;

$soar->score($sql);
$soar->htmlScore($sql);
$soar->markdownScore($sql);
$soar->arrayScore($sql);
$soar->jsonScore($sql);
```

```php
array:8 [
  0 => array:8 [
    "ID" => "369F669A622BA5D2"
    "Fingerprint" => "select*from admin_users join admin_role_users on admin_users.id=admin_role_users.user_id join admin_roles on admin_roles.id=admin_role_users.role_id"
    "Score" => 90
    "Sample" => "SELECT*FROM admin_users JOIN admin_role_users ON admin_users.id=admin_role_users.user_id JOIN admin_roles ON admin_roles.id=admin_role_users.role_id"
    "Explain" => array:1 [
      0 => array:6 [
        "Item" => "EXP.000"
        "Severity" => "L0"
        "Summary" => "Explain信息"
        "Content" => """
          | id | select\_type | table | partitions | type | possible_keys | key | key\_len | ref | rows | filtered | scalability | Extra |\n
          |---|---|---|---|---|---|---|---|---|---|---|---|---|\n
          | 1  | SIMPLE | *admin\_users* | NULL | ALL | PRIMARY | NULL | NULL | NULL | 1 | ☠️ **100.00%** | ☠️ **O(n)** | NULL |\n
          | 1  | SIMPLE | *admin\_role\_users* | NULL | ALL | admin\_role\_users\_role\_id\_user\_id\_unique | NULL | NULL | NULL | 1 | ☠️ **100.00%** | ☠️ **O(n)** | Using where; Using join buffer (Block Nested Loop) |\n
          | 1  | SIMPLE | *admin\_roles* | NULL | eq\_ref | PRIMARY | PRIMARY | 8 | laravel.admin\_role\_users.role\_id | 1 | ☠️ **100.00%** | O(log n) | Using where |\n
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
          * **eq_ref**: 除const类型外最好的可能实现的连接类型. 它用在一个索引的所有部分被连接使用并且索引是UNIQUE或PRIMARY KEY, 对于每个索引键, 表中只有一条记录与之匹配. 例: 'SELECT * FROM RefTbl, tbl WHERE RefTbl.col=tbl.col;'.\n
          \n
          * ☠️ **ALL**: 最坏的情况, 从头到尾全表扫描.\n
          \n
          #### Extra信息解读\n
          \n
          * **Using join buffer**: 从已有连接中找被读入缓存的数据, 并且通过缓存来完成与当前表的连接.\n
          \n
          * **Using where**: WHERE条件用于筛选出与下一个表匹配的数据然后返回给客户端. 除非故意做的全表扫描, 否则连接类型是ALL或者是index, 且在Extra列的值中没有Using Where, 则该查询可能是有问题的.\n
          """
        "Position" => 0
      ]
    ]
    "HeuristicRules" => null
    "IndexRules" => array:1 [
      0 => array:6 [
        "Item" => "IDX.001"
        "Severity" => "L2"
        "Summary" => "为laravel库的admin_role_users表添加索引"
        "Content" => "为列user_id添加索引; 由于未开启数据采样，各列在索引中的顺序需要自行调整。"
        "Case" => "ALTER TABLE `laravel`.`admin_role_users` add index `idx_user_id` (`user_id`) ;\n"
        "Position" => 0
      ]
    ]
    "Tables" => array:3 [
      0 => "`laravel`.`admin_role_users`"
      1 => "`laravel`.`admin_roles`"
      2 => "`laravel`.`admin_users`"
    ]
  ]
  1 => array:8 [
    "ID" => "0C5DCE6FC98AAD74"
    "Fingerprint" => "select \ tdate_format (t.last_update,?),\ tcount (distinct (t.city)) \ tfrom city t where t.last_update> ? \ tand t.city like ? \ tand t.city=? group by date_format(t.last_update,?) order by date_format(t.last_update,?)"
    "Score" => 0
    "Sample" => "SELECT \ tDATE_FORMAT (t.last_update,'%Y-%m-%d'),\ tCOUNT (DISTINCT (t.city)) \ tFROM city t WHERE t.last_update> '2018-10-22 00:00:00' \ tAND t.city LIKE '%Chrome%' \ tAND t.city='eip' GROUP BY DATE_FORMAT(t.last_update,'%Y-%m-%d') ORDER BY DATE_FORMAT(t.last_update,'%Y-%m-%d')"
    "Explain" => null
    "HeuristicRules" => array:2 [
      0 => array:6 [
        "Item" => "ALI.001"
        "Severity" => "L0"
        "Summary" => "建议使用 AS 关键字显示声明一个别名"
        "Content" => "在列或表别名(如"tbl AS alias")中, 明确使用 AS 关键字比隐含别名(如"tbl alias")更易懂。"
        "Case" => "select name from tbl t1 where id < 1000"
        "Position" => 0
      ]
      1 => array:6 [
        "Item" => "ERR.000"
        "Severity" => "L8"
        "Summary" => "No available MySQL environment, build-in sql parse failed: line 1 column 8 near "\ tDATE_FORMAT (t.last_update,'%Y-%m-%d'),\ tCOUNT (DISTINCT (t.city)) \ tFROM city t WHERE t.last_update> '2018-10-22 00:00:00' \ tAND t.city LIKE '%Chrome%' \ tAND t.city='eip' GROUP BY DATE_FORMAT(t.last_update,'%Y-%m-%d') ORDER BY DATE_FORMAT(t.last_update,'%Y-%m-%d')" "
        "Content" => "line 1 column 8 near "\ tDATE_FORMAT (t.last_update,'%Y-%m-%d'),\ tCOUNT (DISTINCT (t.city)) \ tFROM city t WHERE t.last_update> '2018-10-22 00:00:00' \ tAND t.city LIKE '%Chrome%' \ tAND t.city='eip' GROUP BY DATE_FORMAT(t.last_update,'%Y-%m-%d') ORDER BY DATE_FORMAT(t.last_update,'%Y-%m-%d')" "
        "Case" => ""
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => null
  ]
  2 => array:8 [
    "ID" => "9E65CFF6D5AE1F36"
    "Fingerprint" => "select maxid,minid from (select max(film_id) maxid,min(film_id) minid from film where last_update> ?) as d"
    "Score" => 50
    "Sample" => "SELECT maxId,minId FROM (SELECT max(film_id) maxId,min(film_id) minId FROM film WHERE last_update> '2016-03-27 02:01:01') AS d"
    "Explain" => null
    "HeuristicRules" => array:3 [
      0 => array:6 [
        "Item" => "CLA.001"
        "Severity" => "L4"
        "Summary" => "最外层 SELECT 未指定 WHERE 条件"
        "Content" => "SELECT 语句没有 WHERE 子句，可能检查比预期更多的行(全表扫描)。对于 SELECT COUNT(*) 类型的请求如果不要求精度，建议使用 SHOW TABLE STATUS 或 EXPLAIN 替代。"
        "Case" => "select id from tbl"
        "Position" => 0
      ]
      1 => array:6 [
        "Item" => "SUB.001"
        "Severity" => "L4"
        "Summary" => "MySQL 对子查询的优化效果不佳"
        "Content" => "MySQL 将外部查询中的每一行作为依赖子查询执行子查询。 这是导致严重性能问题的常见原因。这可能会在 MySQL 5.6 版本中得到改善, 但对于5.1及更早版本, 建议将该类查询分别重写为 JOIN 或 LEFT OUTER JOIN。"
        "Case" => "select col1,col2,col3 from table1 where col2 in(select col from table2)"
        "Position" => 0
      ]
      2 => array:6 [
        "Item" => "SUB.006"
        "Severity" => "L2"
        "Summary" => "不建议在子查询中使用函数"
        "Content" => "MySQL将外部查询中的每一行作为依赖子查询执行子查询，如果在子查询中使用函数，即使是semi-join也很难进行高效的查询。可以将子查询重写为OUTER JOIN语句并用连接条件对数据进行过滤。"
        "Case" => "SELECT * FROM staff WHERE name IN (SELECT max(NAME) FROM customer)"
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => array:1 [
      0 => "`laravel`.`film`"
    ]
  ]
  3 => array:8 [
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
  4 => array:8 [
    "ID" => "1E6CB161B39B3F38"
    "Fingerprint" => "update city inner join country using (country_id) set city.city=?,city.last_update=?,country.country=? where city.city_id=?"
    "Score" => 80
    "Sample" => "UPDATE city INNER JOIN country USING (country_id) SET city.city='Abha',city.last_update='2006-02-15 04:45:25',country.country='Afghanistan' WHERE city.city_id=10"
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
    "ID" => "C11ECE7AE5F80CE5"
    "Fingerprint" => "create table hello.t (id int unsigned)"
    "Score" => 45
    "Sample" => "CREATE TABLE hello.t (id INT UNSIGNED)"
    "Explain" => null
    "HeuristicRules" => array:5 [
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
        "Item" => "KEY.007"
        "Severity" => "L4"
        "Summary" => "未指定主键或主键非 int 或 bigint"
        "Content" => "未指定主键或主键非 int 或 bigint，建议将主键设置为 int unsigned 或 bigint unsigned。"
        "Case" => "CREATE TABLE tbl (a int);"
        "Position" => 0
      ]
      4 => array:6 [
        "Item" => "TBL.002"
        "Severity" => "L4"
        "Summary" => "请为表选择合适的存储引擎"
        "Content" => "建表或修改表的存储引擎时建议使用推荐的存储引擎，如：innodb"
        "Case" => "create table test(`id` int(11) NOT NULL AUTO_INCREMENT)"
        "Position" => 0
      ]
    ]
    "IndexRules" => null
    "Tables" => array:1 [
      0 => "`hello`.`t`"
    ]
  ]
]
```

![](docs/score.png)
</details>

<details>
<summary><b>soar 帮助</b></summary>

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

<details>
<summary><b>执行任意 soar 选项命令</b></summary>

```php
$soar->setVersion(true)->run();
$soar->run('-version');
```
</details>

## 测试

```bash
composer test
```

## 变更日志

请参阅 [CHANGELOG](CHANGELOG.md) 获取最近有关更改的更多信息。

## 贡献指南

请参阅 [CONTRIBUTING](.github/CONTRIBUTING.md) 有关详细信息。

## 安全漏洞

请查看[我们的安全政策](../../security/policy)了解如何报告安全漏洞。

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

## 协议

MIT 许可证（MIT）。有关更多信息，请参见[协议文件](LICENSE)。