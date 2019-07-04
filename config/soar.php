<?php

/*
 * This file is part of the guanguans/soar_php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

return [
    // soar 路径
    'soar_path'        => '/Users/yaozm/Documents/wwwroot/soar_php/soar',
    // 线上环境配置
    'soar_online_dsn'  => [
        'host'     => '127.0.0.1',
        'port'     => '3307',
        'schema'   => 'sakila',
        'dbname'   => 'fastadmin',
        'user'     => 'root',
        'password' => 'root',
        'disable'  => false,
    ],
    // 测试环境配置
    'soar_test_dsn'    => [
        'host'     => '127.0.0.1',
        'port'     => '3306',
        'schema'   => 'test',
        'dbname'   => 'fastadmin',
        'user'     => 'root',
        'password' => 'root',
        'disable'  => false,
    ],
    // 日志输出文件
    'soar_log_output'  => './soar.log',
    // 日志级别: [0=>Emergency, 1=>Alert, 2=>Critical, 3=>Error, 4=>Warning, 5=>Notice, 6=>Informational, 7=>Debug]
    'soar_log_level'   => 7,
    // 报告输出格式
    'soar_report_type' => 'json',


    // // 是否允许测试环境与线上环境配置相同
    // 'soar_allow_online_as_test' => true,
    //
    // // 是否清理测试时产生的临时文件
    // 'soar_drop_test_temporary'  => true,
    //
    // // 语法检查小工具
    // 'soar_only_syntax_check'    => false,
    //
    // 'soar_sampling_statistic_target' => 100,
    // 'soar_sampling'                  => false,
    //
    // // 日志级别: [0=>Emergency, 1=>Alert, 2=>Critical, 3=>Error, 4=>Warning, 5=>Notice, 6=>Informational, 7=>Debug]
    // 'soar_log_level'                 => 7,
    // 'soar_log_output'                => 'soar.log',
    //
    // // 优化建议输出格式
    // 'soar_report_type'               => 'markdown',
    //
    // // 忽略规则
    // 'soar_ignore_rules'              => [],
    //
    // // 黑名单中的 SQL 将不会给评审意见。一行一条 SQL，可以是正则也可以是指纹，填写指纹时注意问号需要加反斜线转义。
    // 'soar_blacklist'                 => './soar.blacklist',
    //
    // // 启发式算法相关配置
    // 'soar_max_join_table_count'      => 5,
    // 'soar_max_group_by_cols_count'   => 5,
    // 'soar_max_distinct_count'        => 5,
    // 'soar_max_index_cols_count'      => 5,
    // 'soar_max_total_rows'            => 9999999,
    // 'soar_spaghetti_query_length'    => 2048,
    // 'soar_allow_drop_index'          => false,
    //
    // // EXPLAIN相关配置
    // 'soar_explain_sql_report_type'   => 'pretty',
    // 'soar_explain_type'              => 'extended',
    // 'soar_explain_format'            => 'traditional',
    // 'soar_explain_warn_select_type'  => [],
    // 'soar_explain_warn_access_type'  => [],
    // 'soar_explain_max_keys'          => 3,
    // 'soar_explain_min_keys'          => 0,
    // 'soar_explain_max_rows'          => 10000,
    // 'soar_explain_warn_extra'        => [],
    // 'soar_explain_max_filtered'      => 100,
    // 'soar_explain_warn_scalability'  => [],
    //
    // 'soar_query'                => "",
    // 'soar_list_heuristic_rules' => false,
    // 'soar_list_test_sqls'       => false,
    // 'soar_verbose'              => true,
];
