<?php

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

// +----------------------------------------------------------------------+//
// |              请参考 @see https://github.com/XiaoMi/soar               |//
// +----------------------------------------------------------------------+//

return [
    // Config file path
    '-config' => __DIR__.'/options.yaml',

    // TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
    '-test-dsn' => [
        'user' => 'you_user',
        'password' => 'you_password',
        'addr' => '127.0.0.1:3306',
        // 'host' => 'you_host',
        // 'port' => 'you_port',
        'schema' => 'you_dbname',
        'net' => 'tcp',
        'charset' => 'utf8',
        'collation' => 'utf8mb4_general_ci',
        'loc' => 'UTC',
        'tls' => '',
        'server-public-key' => '',
        'max-allowed-packet' => 4194304,
        'params' => [
            'charset' => 'utf8',
        ],
        'timeout' => '3s',
        'read-timeout' => '0s',
        'write-timeout' => '0s',
        'allow-native-passwords' => true,
        'allow-old-passwords' => false,
        'disable' => false,
    ],

    // OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
    '-online-dsn' => [
        'user' => 'you_user',
        'password' => 'you_password',
        'addr' => '127.0.0.1:3306',
        // 'host' => 'you_host',
        // 'port' => 'you_port',
        'schema' => 'you_dbname',
        'net' => 'tcp',
        'charset' => 'utf8',
        'collation' => 'utf8mb4_general_ci',
        'loc' => 'UTC',
        'tls' => '',
        'server-public-key' => '',
        'max-allowed-packet' => 4194304,
        'params' => [
            'charset' => 'utf8',
        ],
        'timeout' => '3s',
        'read-timeout' => '0s',
        'write-timeout' => '0s',
        'allow-native-passwords' => true,
        'allow-old-passwords' => false,
        'disable' => true,
    ],

    // AllowOnlineAsTest, 允许线上环境也可以当作测试环境
    '-allow-online-as-test' => true,

    // 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
    '-blacklist' => __DIR__.'/blacklist.example',

    // Explain, 是否开启Explain执行计划分析 (default true)
    '-explain' => true,

    // IgnoreRules, 忽略的优化建议规则 (default "COL.011")
    '-ignore-rules' => [
        'COL.011',
    ],

    // LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
    '-log-level' => 3,

    // LogOutput, 日志输出位置 (default "soar.log")
    '-log-output' => __DIR__.'/../bin/soar.log',

    // ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
    '-report-type' => 'json',
];
