<h1 align="center">soar-php</h1>

<p align="center">
    <a>简体中文</a> |
    <a href="README-EN.md">ENGLISH</a>
</p>

<p align="center">SQL 优化器、重写器</p>

> **[soar-php](https://github.com/guanguans/soar-php)** 是一个基于小米公司开源的 [soar](https://github.com/XiaoMi/soar) 开发的 SQL 优化器、重写器(辅助 SQL 调优)。

[![tests](https://github.com/guanguans/soar-php/actions/workflows/tests.yml/badge.svg)](https://github.com/guanguans/soar-php/actions/workflows/tests.yml)
[![check & fix styling](https://github.com/guanguans/soar-php/actions/workflows/php-cs-fixer.yml/badge.svg)](https://github.com/guanguans/soar-php/actions/workflows/php-cs-fixer.yml)
[![codecov](https://codecov.io/gh/guanguans/soar-php/branch/master/graph/badge.svg)](https://codecov.io/gh/guanguans/soar-php)
[![Total Downloads](https://poser.pugx.org/guanguans/soar-php/downloads)](https://packagist.org/packages/guanguans/soar-php)
[![Latest Stable Version](https://poser.pugx.org/guanguans/soar-php/v/stable)](https://packagist.org/packages/guanguans/soar-php)
[![License](https://poser.pugx.org/guanguans/soar-php/license)](https://packagist.org/packages/guanguans/soar-php)

## 环境要求

* PHP >= 7.1
* ext-json
* ext-mbstring
* ext-pdo

## 框架中使用

- [x] Laravel - [laravel-soar](https://github.com/guanguans/laravel-soar), [laravel-web-soar](https://github.com/huangdijia/laravel-web-soar)
- [x] ThinkPHP - [think-soar](https://github.com/guanguans/think-soar)
- [x] Hyperf - [hyperf-soar](https://github.com/wilbur-oo/hyperf-soar)
- [ ] Yii2
- [ ] Symfony
- [ ] Slim

## 安装

``` shell
$ composer require guanguans/soar-php -vvv
```

## 使用

### 创建 soar 实例(配置参考 [soar.config.example](./soar.config.example.php)、[soar.config](https://github.com/XiaoMi/soar/blob/master/doc/config.md))

```php
<?php

require __DIR__.'/vendor/autoload.php';

use Guanguans\SoarPHP\Soar;

$soar = Soar::create();
// $soar->setSoarPath('自定义的 soar 路径')
//     ->setOptions([
//         // 测试环境配置
//         '-test-dsn'    => [
//             'host'     => '127.0.0.1',
//             'port'     => '3306',
//             'dbname'   => 'database',
//             'username' => 'root',
//             'password' => '123456',
//             'disable'  => false,
//         ],
//         // 日志输出文件
//         '-log-output'  => __DIR__ . '/logs/soar.log',
//         // 报告输出格式: [markdown, html, json, ...]
//         '-report-type' => 'html',
//     ]);
```

### SQL 评分

**方法调用：**

```php
$sql ="SELECT * FROM `fa_user` `user` LEFT JOIN `fa_user_group` `group` ON `user`.`group_id`=`group`.`id`;";
echo $soar->score($sql);
```

**输出结果：**

![](docs/score.png)

### explain 信息解读

**方法调用：**

```php
$sql = "SELECT * FROM `fa_auth_group_access` `aga` LEFT JOIN `fa_auth_group` `ag` ON `aga`.`group_id`=`ag`.`id`;";
// 输出 html 格式
echo $soar->htmlExplain($sql);
// 输出 md 格式
echo $soar->mdExplain($sql);
// 输出 html 格式
echo $soar->explain($sql, 'html');
// 输出 md 格式
echo $soar->explain($sql, 'md');

```

**输出结果：**

![](docs/explain.png)

### 语法检查

**方法调用：**

```php
$sql = 'selec * from fa_user';
echo $soar->syntaxCheck($sql);
```

**输出结果：**

```sql
At SQL 1 : line 1 column 5 near "selec * from fa_user" (total length 20)
```

### SQL 指纹

**方法调用：**

```php
$sql = 'select * from fa_user where id=1';
echo $soar->fingerPrint($sql);
```

**输出结果：**

```sql
select * from fa_user where id = ?
```

### SQL 美化

**方法调用：**

```php
$sql = 'select * from fa_user where id=1';
var_dump($soar->pretty($sql));
```

**输出结果：**

```sql
SELECT  
  * 
FROM  
  fa_user  
WHERE  
  id  = 1;
```

### markdown 转化为 html

**方法调用：**

```php
echo $soar->md2html("## 这是一个测试");
```

**输出结果：**

```html
...
<h2>这是一个测试</h2>
...
```

### soar 帮助

**方法调用：**

```php
var_dump($soar->help());
```

**输出结果：**

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

### 执行任意 soar 命令

**方法调用：**

```php
$command = "echo '## 这是另一个测试' | /Users/yaozm/Documents/wwwroot/soar-php/soar.darwin-amd64 -report-type md2html";
echo $soar->exec($command);
```

**输出结果：**

```html
...
<h2>这是另一个测试</h2>
...
```

## 测试

```bash
$ composer test
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