<h1 align="center">soar-php</h1>
[![All Contributors](https://img.shields.io/badge/all_contributors-1-orange.svg?style=flat-square)](#contributors)

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

* PHP >= 5.6
* ext-pdo
* ext-json

## 框架中使用

- [x] ThinkPHP - [think-soar](https://github.com/guanguans/think-soar)
- [ ] Symfony
- [ ] Laravel
- [ ] Lumen
- [ ] Yii2
- [ ] Slim

## 安装

``` shell
$ composer require guanguans/soar-php --dev
```

## 使用

### 下载 [XiaoMi](https://github.com/XiaoMi/) 开源的 SQL 优化器 [soar](https://github.com/XiaoMi/soar/releases)，更多详细安装请参考 [soar install](https://github.com/XiaoMi/soar/blob/master/doc/install.md)

``` bash
# macOS
$ wget https://github.com/XiaoMi/soar/releases/download/0.11.0/soar.darwin-amd64
# linux
$ wget https://github.com/XiaoMi/soar/releases/download/0.11.0/soar.linux-amd64
# windows
$ wget https://github.com/XiaoMi/soar/releases/download/0.11.0/soar.windows-amd64
# 用其他命令或下载器下载均可以
```

### 初始化配置，更多详细配置请参考 [soar config](https://github.com/XiaoMi/soar/blob/master/doc/config.md)

#### 方法一、运行时初始化配置

``` php
<?php

require_once __DIR__.'/vendor/autoload.php';

use Guanguans\SoarPHP\Soar;

$config = [
    // 下载的 soar 的路径
    '-soar-path' => '/Users/yaozm/Documents/wwwroot/soar-php/soar.darwin-amd64',
    // 测试环境配置
    '-test-dsn' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => 'database',
        'username' => 'root',
        'password' => '123456',
    ],
    // 日志输出文件
    '-log-output' => './soar.log',
    // 报告输出格式: 默认  markdown [markdown, html, json]
    '-report-type' => 'html',
];
$soar = new Soar($config);
```

#### 方法二、配置文件初始化配置

`vendor` 同级目录下新建 `.soar.dist` 或者 `.soar`，内容参考 [.soar.example](.soar.example)，例如：

``` php
<?php
return [
    // 下载的 soar 的路径
    '-soar-path' => '/Users/yaozm/Documents/wwwroot/soar-php/soar.darwin-amd64',
    // 测试环境配置
    '-test-dsn' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => 'database',
        'username' => 'root',
        'password' => '123456',
    ],
    // 日志输出文件
    '-log-output' => './soar.log',
    // 报告输出格式: 默认  markdown [markdown, html, json]
    '-report-type' => 'html',
];
```

然后初始化

``` php
<?php

require_once __DIR__.'/vendor/autoload.php';

use Guanguans\SoarPHP\Soar;

$soar = new Soar();
```

#### 配置优先级：运行时初始化配置 > .soar > .soar.dist

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

## 参考链接

* [https://github.com/XiaoMi/soar](https://github.com/XiaoMi/soar)，[XiaoMi](https://github.com/XiaoMi)

## License

[MIT](LICENSE)

## Contributors ✨

Thanks goes to these wonderful people ([emoji key](https://allcontributors.org/docs/en/emoji-key)):

<!-- ALL-CONTRIBUTORS-LIST:START - Do not remove or modify this section -->
<!-- prettier-ignore -->
<table>
  <tr>
    <td align="center"><a href="http://blog.charmingkamly.cn"><img src="https://avatars2.githubusercontent.com/u/15706085?v=4" width="100px;" alt="kamly"/><br /><sub><b>kamly</b></sub></a><br /><a href="https://github.com/guanguans/soar-php/issues?q=author%3Akamly" title="Bug reports">🐛</a></td>
  </tr>
</table>

<!-- ALL-CONTRIBUTORS-LIST:END -->

This project follows the [all-contributors](https://github.com/all-contributors/all-contributors) specification. Contributions of any kind welcome!