<?php

/*
 * This file is part of the guanguans/-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    // soar 路径
    '-soar-path'   => 'path/to/soar',
    // 线上环境配置
    '-online-dsn'  => [
        'host'     => '127.0.0.1',
        'port'     => '3306',
        'dbname'   => 'database',
        'username' => 'selectuser',
        'password' => '123456',
        'disable'  => false,
    ],
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
    '-log-output'  => './soar.log',
    // 日志级别: [0=>Emergency, 1=>Alert, 2=>Critical, 3=>Error, 4=>Warning, 5=>Notice, 6=>Informational, 7=>Debug]
    '-log-level'   => 7,
    // 报告输出格式: [markdown, html, json]
    '-report-type' => 'html',



    // // 是否允许测试环境与线上环境配置相同
    // '-allow-online-as-test' => true,
    //
    // // 是否清理测试时产生的临时文件
    // '-drop-test-temporary'  => true,
    //
    // // 语法检查小工具
    // '-only-syntax-check'    => false,
    //
    // '-sampling-statistic-target' => 100,
    // '-sampling'                  => false,
    //
    // // 日志级别: [0=>Emergency, 1=>Alert, 2=>Critical, 3=>Error, 4=>Warning, 5=>Notice, 6=>Informational, 7=>Debug]
    // '-log-level'                 => 7,
    // '-log-output'                => 'soar.log',
    //
    // // 优化建议输出格式
    // '-report-type'               => 'markdown',
    //
    // // 忽略规则
    // '-ignore-rules'              => [],
    //
    // // 黑名单中的 SQL 将不会给评审意见。一行一条 SQL，可以是正则也可以是指纹，填写指纹时注意问号需要加反斜线转义。
    // '-blacklist'                 => './soar.blacklist',
    //
    // // 启发式算法相关配置
    // '-max-join-table-count'      => 5,
    // '-max-group-by-cols-count'   => 5,
    // '-max-distinct-count'        => 5,
    // '-max-index-cols-count'      => 5,
    // '-max-total-rows'            => 9999999,
    // '-spaghetti-query-length'    => 2048,
    // '-allow-drop-index'          => false,
    //
    // // EXPLAIN相关配置
    // '-explain-sql-report-type'   => 'pretty',
    // '-explain-type'              => 'extended',
    // '-explain-format'            => 'traditional',
    // '-explain-warn-select-type'  => [],
    // '-explain-warn-access-type'  => [],
    // '-explain-max-keys'          => 3,
    // '-explain-min-keys'          => 0,
    // '-explain-max-rows'          => 10000,
    // '-explain-warn-extra'        => [],
    // '-explain-max-filtered'      => 100,
    // '-explain-warn-scalability'  => [],
    //
    // '-query'                => "",
    // '-list-heuristic-rules' => false,
    // '-list-test-sqls'       => false,
    // '-verbose'              => true,
    //
    // '-config' => 'soar.yaml'
];
