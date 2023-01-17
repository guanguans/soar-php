<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

// +----------------------------------------------------------------------+//
// |              请参考 @see https://github.com/XiaoMi/soar               |//
// +----------------------------------------------------------------------+//

return [
    /**
     * 测试环境数据库配置.
     */
    '-test-dsn' => [
        'host' => 'you_host',
        'port' => 'you_port',
        'dbname' => 'you_dbname',
        'username' => 'you_username',
        'password' => 'you_password',
        'disable' => false,
    ],

    /**
     * 线上环境数据库配置(数据库用户只需 select 权限).
     */
    '-online-dsn' => [
        'host' => 'you_host',
        'port' => 'you_port',
        'dbname' => 'you_dbname',
        'username' => 'you_username',
        'password' => 'you_password',
        'disable' => true,
    ],

    /**
     * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则.
     */
    '-blacklist' => __DIR__.'/soar.blacklist.example',

    /**
     * Config file path.
     */
    '-config' => __DIR__.'/soar.options.example.yaml',

    /**
     * Explain, 是否开启Explain执行计划分析 (default true).
     */
    '-explain' => true,

    /**
     * IgnoreRules, 忽略的优化建议规则 (default "COL.011").
     */
    '-ignore-rules' => [
        'COL.011',
    ],

    /**
     * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3).
     */
    '-log-level' => 3,

    /**
     * LogOutput, 日志输出位置 (default "soar.log").
     */
    '-log-output' => __DIR__.'/bin/soar.log',

    /**
     * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown").
     */
    '-report-type' => 'json',
];
