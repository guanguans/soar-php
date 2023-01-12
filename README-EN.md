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
* ext-pdo

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
$ composer require guanguans/soar-php -vvv
```

## Usage

<details>
<summary><b>Create the soar instance</b></summary>

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Guanguans\SoarPHP\Soar;

$soar = Soar::create();

/** Configuration Options Reference @see soar.config.example.php */
// $soar->setSoarPath('custom soar path')
//     ->setOptions([
//         // Test environment configuration
//         '-test-dsn'    => [
//             'host'     => '127.0.0.1',
//             'port'     => '3306',
//             'dbname'   => 'database',
//             'username' => 'root',
//             'password' => '123456',
//             'disable'  => false,
//         ],
//         // log output file
//         '-log-output'  => __DIR__ . '/logs/soar.log',
//         // Report output format: [markdown, html, json, ...]
//         '-report-type' => 'html',
//     ]);
```
</details>

<details>
<summary><b>SQL score</b></summary>

```php
$sql ="SELECT * FROM `fa_user` `user` LEFT JOIN `fa_user_group` `group` ON `user`.`group_id`=`group`.`id`;";
echo $soar->score($sql);

$sql = 'SELECT * FROM users LEFT JOIN post ON users.id=post.user_id; SELECT * FROM post;';
echo $soar->jsonScore($sql);
echo $soar->arrayScore($sql);
echo $soar->htmlScore($sql);
echo $soar->markdownScore($sql);
```

![](docs/score.png)

```json
[
    {
        "ID": "628CC297F69EB186",
        "Fingerprint": "select * from users left join post on users.id=post.user_id",
        "Score": 85,
        "Sample": "SELECT * FROM users LEFT JOIN post ON users.id=post.user_id",
        "Explain": [
            {
                "Item": "EXP.000",
                "Severity": "L0",
                "Summary": "Explain信息",
                "Content": "| id | select\\_type | table | partitions | type | possible_keys | key | key\\_len | ref | rows | filtered | scalability | Extra |\n|---|---|---|---|---|---|---|---|---|---|---|---|---|\n| 1  | SIMPLE | *users* | NULL | ALL | NULL | NULL | NULL | NULL | 1 | ☠️ **100.00%** | ☠️ **O(n)** | NULL |\n| 1  | SIMPLE | *post* | NULL | ALL | NULL | NULL | NULL | NULL | 3 | ☠️ **100.00%** | ☠️ **O(n)** | Using where; Using join buffer (hash join) |\n\n",
                "Case": "### Explain信息解读\n\n#### SelectType信息解读\n\n* **SIMPLE**: 简单SELECT(不使用UNION或子查询等).\n\n#### Type信息解读\n\n* ☠️ **ALL**: 最坏的情况, 从头到尾全表扫描.\n\n#### Extra信息解读\n\n* **Using join buffer**: 从已有连接中找被读入缓存的数据, 并且通过缓存来完成与当前表的连接.\n\n* **Using where**: WHERE条件用于筛选出与下一个表匹配的数据然后返回给客户端. 除非故意做的全表扫描, 否则连接类型是ALL或者是index, 且在Extra列的值中没有Using Where, 则该查询可能是有问题的.\n",
                "Position": 0
            }
        ],
        "HeuristicRules": [
            {
                "Item": "COL.001",
                "Severity": "L1",
                "Summary": "不建议使用 SELECT * 类型查询",
                "Content": "当表结构变更时，使用 * 通配符选择所有列将导致查询的含义和行为会发生更改，可能导致查询返回更多的数据。",
                "Case": "select * from tbl where id=1",
                "Position": 0
            }
        ],
        "IndexRules": [
            {
                "Item": "IDX.001",
                "Severity": "L2",
                "Summary": "为laravel库的post表添加索引",
                "Content": "为列user_id添加索引; 由于未开启数据采样，各列在索引中的顺序需要自行调整。",
                "Case": "ALTER TABLE `laravel`.`post` add index `idx_user_id` (`user_id`) ;\n",
                "Position": 0
            }
        ],
        "Tables": [
            "`laravel`.`post`",
            "`laravel`.`users`"
        ]
    },
    {
        "ID": "E3C219F643102497",
        "Fingerprint": "select * from post",
        "Score": 75,
        "Sample": "SELECT * FROM post",
        "Explain": [
            {
                "Item": "EXP.000",
                "Severity": "L0",
                "Summary": "Explain信息",
                "Content": "| id | select\\_type | table | partitions | type | possible_keys | key | key\\_len | ref | rows | filtered | scalability | Extra |\n|---|---|---|---|---|---|---|---|---|---|---|---|---|\n| 1  | SIMPLE | *post* | NULL | ALL | NULL | NULL | NULL | NULL | 3 | ☠️ **100.00%** | ☠️ **O(n)** | NULL |\n\n",
                "Case": "### Explain信息解读\n\n#### SelectType信息解读\n\n* **SIMPLE**: 简单SELECT(不使用UNION或子查询等).\n\n#### Type信息解读\n\n* ☠️ **ALL**: 最坏的情况, 从头到尾全表扫描.\n",
                "Position": 0
            }
        ],
        "HeuristicRules": [
            {
                "Item": "CLA.001",
                "Severity": "L4",
                "Summary": "最外层 SELECT 未指定 WHERE 条件",
                "Content": "SELECT 语句没有 WHERE 子句，可能检查比预期更多的行(全表扫描)。对于 SELECT COUNT(*) 类型的请求如果不要求精度，建议使用 SHOW TABLE STATUS 或 EXPLAIN 替代。",
                "Case": "select id from tbl",
                "Position": 0
            },
            {
                "Item": "COL.001",
                "Severity": "L1",
                "Summary": "不建议使用 SELECT * 类型查询",
                "Content": "当表结构变更时，使用 * 通配符选择所有列将导致查询的含义和行为会发生更改，可能导致查询返回更多的数据。",
                "Case": "select * from tbl where id=1",
                "Position": 0
            }
        ],
        "IndexRules": null,
        "Tables": [
            "`laravel`.`post`"
        ]
    }
]
```
</details>

<details>
<summary><b>explain information</b></summary>

```php
$sql = "SELECT * FROM `fa_auth_group_access` `aga` LEFT JOIN `fa_auth_group` `ag` ON `aga`.`group_id`=`ag`.`id`;";
echo $soar->htmlExplain($sql);
echo $soar->mdExplain($sql);
echo $soar->explain($sql);
```

![](docs/explain.png)
</details>

<details>
<summary><b>Grammar check</b></summary>

```php
$sql = 'selec * from fa_user';
echo $soar->syntaxCheck($sql);
```

```sql
At SQL 1 : line 1 column 5 near "selec * from fa_user" (total length 20)
```
</details>

<details>
<summary><b>SQL fingerprint</b></summary>

```php
$sql = 'select * from fa_user where id=1';
echo $soar->fingerPrint($sql);
```

```sql
select * from fa_user where id = ?
```
</details>

<details>
<summary><b>SQL pretty</b></summary>

```php
$sql = 'select * from fa_user where id=1';
var_dump($soar->pretty($sql));
```

```sql
SELECT  
  * 
FROM  
  fa_user  
WHERE  
  id  = 1;
```
</details>

<details>
<summary><b>Markdown to html</b></summary>

```php
echo $soar->md2html("## this is a test");
```

```html
...
<h2>this is a test</h2>
...
```
</details>

<details>
<summary><b>Soar help</b></summary>

```php
var_dump($soar->help());
```

```yaml
···
'Usage of /Users/yaozm/Documents/wwwroot/soar-php/soar:
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
    	指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。
···    
```
</details>

<details>
<summary><b>Execute any `soar` command</b></summary>

```php
$command = "echo '## 这是另一个测试' | /Users/yaozm/Documents/wwwroot/soar-php/soar.darwin-amd64 -report-type md2html";
echo $soar->exec($command);
```

```html
...
<h2>This is another test'</h2>
...
```
</details>

## Testing

```bash
$ composer test
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
