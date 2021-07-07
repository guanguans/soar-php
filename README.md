<h1 align="center">soar-php</h1>

<p align="center">
    <a>简体中文</a> |
    <a href="README-EN.md">ENGLISH</a>
</p>

<p align="center">SQL 语句优化器和重写器</p>

> **[soar-php](https://github.com/guanguans/soar-php)** 是一个基于小米公司开源的 [soar](https://github.com/XiaoMi/soar) 开发的 PHP 扩展包，方便框架中 SQL 语句调优。

[![Build Status](https://travis-ci.org/guanguans/soar-php.svg?branch=master)](https://travis-ci.org/guanguans/soar-php)
[![Build Status](https://scrutinizer-ci.com/g/guanguans/soar-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/guanguans/soar-php/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/guanguans/soar-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/guanguans/soar-php/?branch=master)
[![codecov](https://codecov.io/gh/guanguans/soar-php/branch/master/graph/badge.svg)](https://codecov.io/gh/guanguans/soar-php)
[![StyleCI](https://github.styleci.io/repos/178793017/shield?branch=master)](https://github.styleci.io/repos/178793017)
[![Total Downloads](https://poser.pugx.org/guanguans/soar-php/downloads)](https://packagist.org/packages/guanguans/soar-php)
[![Latest Stable Version](https://poser.pugx.org/guanguans/soar-php/v/stable)](https://packagist.org/packages/guanguans/soar-php)
[![License](https://poser.pugx.org/guanguans/soar-php/license)](https://packagist.org/packages/guanguans/soar-php)

## 环境要求

* PHP >= 7.1
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
$ composer require guanguans/soar-php --dev
```

## 使用

### 下载 [XiaoMi](https://github.com/XiaoMi/) 开源的 SQL 优化器 [soar](https://github.com/XiaoMi/soar/releases)，更多详细安装请参考 [soar install](https://github.com/XiaoMi/soar/blob/master/doc/install.md)(*如果不使用自定义的 soar 路径，这一步请忽略*)

``` bash
# macOS
$ wget https://github.com/XiaoMi/soar/releases/download/0.11.0/soar.darwin-amd64
# linux
$ wget https://github.com/XiaoMi/soar/releases/download/0.11.0/soar.linux-amd64
# windows
$ wget https://github.com/XiaoMi/soar/releases/download/0.11.0/soar.windows-amd64
# 用其他命令或下载器下载均可以
$ chmod +x soar.* # 添加可执行权限
```

### 初始化配置，更多详细配置请参考 [soar.config.example](./soar.config.example.php)、[soar.config](https://github.com/XiaoMi/soar/blob/master/doc/config.md)

``` php
<?php

require __DIR__.'/vendor/autoload.php';

use Guanguans\SoarPHP\Soar;

$config = [
    // 包自带soar 路径或者自定义的 soar 路径
    '-soar-path' => OsHelper::isWindows() ? __DIR__.'/vendor/guanguans/soar-php/bin/soar.windows-amd64' : (OsHelper::isMacOS() ? __DIR__.'/vendor/guanguans/soar-php/bin/soar.darwin-amd64' : __DIR__.'/vendor/guanguans/soar-php/bin/soar.linux-amd64'),
    // '-soar-path' => __DIR__.'/vendor/guanguans/soar-php/bin/soar.linux-amd64',
    // 测试环境配置
    '-test-dsn' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => 'database',
        'username' => 'root',
        'password' => '123456',
        'disable' => false,
    ],
    // 日志输出文件
    '-log-output' => __DIR__.'/logs/soar.log',
    // 报告输出格式: [markdown, html, json, ...]
    '-report-type' => 'html',
];
$soar = new Soar($config);
```

### SQL 评分

**方法调用：**

``` php
$sql ="SELECT * FROM `fa_user` `user` LEFT JOIN `fa_user_group` `group` ON `user`.`group_id`=`group`.`id`;";
echo $soar->score($sql);
```

**输出结果：**

![](docs/score.png)

### explain 信息解读

**方法调用：**

``` php
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

``` php
$sql = 'selec * from fa_user';
echo $soar->syntaxCheck($sql);
```

**输出结果：**

``` sql
At SQL 1 : line 1 column 5 near "selec * from fa_user" (total length 20)
```

### SQL 指纹

**方法调用：**

``` php
$sql = 'select * from fa_user where id=1';
echo $soar->fingerPrint($sql);
```

**输出结果：**

``` sql
select * from fa_user where id = ?
```

### SQL 美化

**方法调用：**

``` php
$sql = 'select * from fa_user where id=1';
var_dump($soar->pretty($sql));
```

**输出结果：**

``` sql
SELECT  
  * 
FROM  
  fa_user  
WHERE  
  id  = 1;
```

### markdown 转化为 html

**方法调用：**

``` php
echo $soar->md2html("## 这是一个测试");
```

**输出结果：**

``` html
...
<h2>这是一个测试</h2>
...
```

### soar 帮助

**方法调用：**

``` php
var_dump($soar->help());
```

**输出结果：**

``` yaml
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

``` php
$command = "echo '## 这是另一个测试' | /Users/yaozm/Documents/wwwroot/soar-php/soar.darwin-amd64 -report-type md2html";
echo $soar->exec($command);
```

**输出结果：**

``` html
...
<h2>这是另一个测试</h2>
...
```

## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore -->
<table>
  <tr>
    <td align="center"><a href="http://blog.charmingkamly.cn"><img src="https://avatars2.githubusercontent.com/u/15706085?v=4" width="100px;" alt="kamly"/><br /><sub><b>kamly</b></sub></a><br /><a href="https://github.com/guanguans/soar-php/issues?q=author%3Akamly" title="Bug reports">🐛</a></td>
    <td align="center"><a href="http://leslieeilsel.com/"><img src="https://avatars1.githubusercontent.com/u/25165449?v=4" width="100px;" alt="Leslie Lau"/><br /><sub><b>Leslie Lau</b></sub></a><br /><a href="https://github.com/guanguans/soar-php/issues?q=author%3Aleslieeilsel" title="Bug reports">🐛</a></td>
    <td align="center"><a href="https://github.com/huangdijia"><img src="https://avatars1.githubusercontent.com/u/8337659?v=4" width="100px;" alt="D.J.Hwang"/><br /><sub><b>D.J.Hwang</b></sub></a><br /><a href="#ideas-huangdijia" title="Ideas, Planning, & Feedback">🤔</a></td>
  </tr>
</table>

<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!

## 参考链接

* [https://github.com/XiaoMi/soar](https://github.com/XiaoMi/soar)，[XiaoMi](https://github.com/XiaoMi)

## License

[MIT](LICENSE)
