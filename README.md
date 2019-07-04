<h1 align="center">soar-php</h1>

<p align="center">SQL 语句优化器</p>

[![Build Status](https://scrutinizer-ci.com/g/guanguans/soar-php/badges/build.png?b=master)](https://scrutinizer-ci.com/g/guanguans/soar-php/build-status/master)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/guanguans/soar-php/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/guanguans/soar-php/?branch=master)
[![StyleCI](https://github.styleci.io/repos/178793017/shield?branch=master)](https://github.styleci.io/repos/178793017)

## 环境要求

* PHP >= 5.6
* ext-pdo
* ext-json

## 安装

``` shell
$ composer require guanguans/soar-php -dev
```

## 使用

``` php
<?php

require_once __DIR__.'/vendor/autoload.php';

use Guanguans\SoarPHP\Soar;

$config = [
    // soar 路径
    '-soar-path' => '/Users/yaozm/Documents/wwwroot/soar-php/soar',
    // 测试环境配置
    '-test-dsn' => [
        'host' => '127.0.0.1',
        'port' => '3306',
        'dbname' => 'fastadmin',
        'username' => 'root',
        'password' => 'root',
        'disable' => true,
    ],
    // 日志输出文件
    '-log-output' => './soar.log',
    '-report-type' => 'html',
];
$soarPhp = new Soar($config);
$sql = 'select * from fa_user where id=1';

// SQL 评分
echo $soarPhp->score($sql);

// 语法检查
echo $soarPhp->syntaxCheck($sql);

// SQL 指纹
echo $soarPhp->fingerPrint($sql);

// SQL 美化
var_dump($soarPhp->pretty($sql));

// sql explain 分析
echo $soarPhp->explain($sql, 'html');
echo $soarPhp->mdExplain($sql);
echo $soarPhp->htmlExplain($sql);

// markdown 转化为 html
echo $soarPhp->md2html("## 这是一个测试");
```

## License

[MIT](LICENSE)