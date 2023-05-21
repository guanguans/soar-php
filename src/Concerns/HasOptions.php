<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHP\Concerns;

use Guanguans\SoarPHP\Exceptions\BadMethodCallException;
use Guanguans\SoarPHP\Exceptions\InvalidOptionException;

/**
 * AllowCharsets (default "utf8,utf8mb4").
 *
 * @method \Guanguans\SoarPHP\Soar addAllowCharsets(string $allowCharsets)
 *
 * AllowCollates
 * @method \Guanguans\SoarPHP\Soar addAllowCollates(string $allowCollates)
 *
 * AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar addAllowDropIndex($allowDropIndex)
 *
 * AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar addAllowEngines(string $allowEngines)
 *
 * AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar addAllowOnlineAsTest($allowOnlineAsTest)
 *
 * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar addBlacklist(string $blacklist)
 *
 * Check configs
 * @method \Guanguans\SoarPHP\Soar addCheckConfig($checkConfig)
 *
 * 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar addCleanupTestDatabase($cleanupTestDatabase)
 *
 * ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar addColumnNotAllowType(string $columnNotAllowType)
 *
 * Config file path
 * @method \Guanguans\SoarPHP\Soar addConfig(string $config)
 *
 * Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar addDelimiter(string $delimiter)
 *
 * DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar addDropTestTemporary($dropTestTemporary)
 *
 * 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar addDryRun($dryRun)
 *
 * Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar addExplain($explain)
 *
 * ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar addExplainFormat(string $explainFormat)
 *
 * ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar addExplainMaxFiltered(float $explainMaxFiltered)
 *
 * ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar addExplainMaxKeys(int $explainMaxKeys)
 *
 * ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar addExplainMaxRows(int $explainMaxRows)
 *
 * ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar addExplainMinKeys(int $explainMinKeys)
 *
 * ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar addExplainSqlReportType(string $explainSqlReportType)
 *
 * ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar addExplainType(string $explainType)
 *
 * ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar addExplainWarnAccessType(string $explainWarnAccessType)
 *
 * ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar addExplainWarnExtra(string $explainWarnExtra)
 *
 * ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar addExplainWarnScalability(string $explainWarnScalability)
 *
 * ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar addExplainWarnSelectType(string $explainWarnSelectType)
 *
 * IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar addIgnoreRules(string $ignoreRules)
 *
 * IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar addIndexPrefix(string $indexPrefix)
 *
 * ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar addListHeuristicRules($listHeuristicRules)
 *
 * ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar addListReportTypes($listReportTypes)
 *
 * ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar addListRewriteRules($listRewriteRules)
 *
 * ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar addListTestSqls($listTestSqls)
 *
 * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar addLogLevel(int $logLevel)
 *
 * LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar addLogOutput(string $logOutput)
 *
 * log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar addLogErrStacks($logErrStacks)
 *
 * size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar addLogRotateMaxSize(int $logRotateMaxSize)
 *
 * MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar addMarkdownExtensions(int $markdownExtensions)
 *
 * MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar addMarkdownHtmlFlags(int $markdownHtmlFlags)
 *
 * MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar addMaxColumnCount(int $maxColumnCount)
 *
 * MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar addMaxDistinctCount(int $maxDistinctCount)
 *
 * MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar addMaxGroupByColsCount(int $maxGroupByColsCount)
 *
 * MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar addMaxInCount(int $maxInCount)
 *
 * MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar addMaxIndexBytes(int $maxIndexBytes)
 *
 * MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar addMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn)
 *
 * MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar addMaxIndexColsCount(int $maxIndexColsCount)
 *
 * MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar addMaxIndexCount(int $maxIndexCount)
 *
 * MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar addMaxJoinTableCount(int $maxJoinTableCount)
 *
 * MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar addMaxPrettySqlLength(int $maxPrettySqlLength)
 *
 * MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar addMaxQueryCost(int $maxQueryCost)
 *
 * MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar addMaxSubqueryDepth(int $maxSubqueryDepth)
 *
 * MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar addMaxTextColsCount(int $maxTextColsCount)
 *
 * MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar addMaxTotalRows(int $maxTotalRows)
 *
 * MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar addMaxValueCount(int $maxValueCount)
 *
 * MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar addMaxVarcharLength(int $maxVarcharLength)
 *
 * MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar addMinCardinality(float $minCardinality)
 *
 * OnlineDSN, 线上环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar addOnlineDsn(string $onlineDsn)
 *
 * OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar addOnlySyntaxCheck($onlySyntaxCheck)
 *
 * Print configs
 * @method \Guanguans\SoarPHP\Soar addPrintConfig($printConfig)
 *
 * Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar addProfiling($profiling)
 *
 * 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar addQuery(string $query)
 *
 * ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar addReportCss(string $reportCss)
 *
 * ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar addReportJavascript(string $reportJavascript)
 *
 * ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar addReportTitle(string $reportTitle)
 *
 * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar addReportType(string $reportType)
 *
 * RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar addRewriteRules(string $rewriteRules)
 *
 * Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar addSampling($sampling)
 *
 * SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar addSamplingCondition(string $samplingCondition)
 *
 * SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar addSamplingStatisticTarget(int $samplingStatisticTarget)
 *
 * ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar addShowLastQueryCost($showLastQueryCost)
 *
 * ShowWarnings
 * @method \Guanguans\SoarPHP\Soar addShowWarnings($showWarnings)
 *
 * SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar addSpaghettiQueryLength(int $spaghettiQueryLength)
 *
 * TestDSN, 测试环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar addTestDsn(string $testDsn)
 *
 * Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar addTrace($trace)
 *
 * UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar addUniqueKeyPrefix(string $uniqueKeyPrefix)
 *
 * Verbose
 * @method \Guanguans\SoarPHP\Soar addVerbose($verbose)
 *
 * Print version info
 * @method \Guanguans\SoarPHP\Soar addVersion($version)
 *
 * Help
 * @method \Guanguans\SoarPHP\Soar addHelp($help)
 *
 * AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar removeAllowCharsets()
 *
 * AllowCollates
 * @method \Guanguans\SoarPHP\Soar removeAllowCollates()
 *
 * AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar removeAllowDropIndex()
 *
 * AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar removeAllowEngines()
 *
 * AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar removeAllowOnlineAsTest()
 *
 * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar removeBlacklist()
 *
 * Check configs
 * @method \Guanguans\SoarPHP\Soar removeCheckConfig()
 *
 * 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar removeCleanupTestDatabase()
 *
 * ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar removeColumnNotAllowType()
 *
 * Config file path
 * @method \Guanguans\SoarPHP\Soar removeConfig()
 *
 * Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar removeDelimiter()
 *
 * DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar removeDropTestTemporary()
 *
 * 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar removeDryRun()
 *
 * Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar removeExplain()
 *
 * ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar removeExplainFormat()
 *
 * ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar removeExplainMaxFiltered()
 *
 * ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar removeExplainMaxKeys()
 *
 * ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar removeExplainMaxRows()
 *
 * ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar removeExplainMinKeys()
 *
 * ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar removeExplainSqlReportType()
 *
 * ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar removeExplainType()
 *
 * ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar removeExplainWarnAccessType()
 *
 * ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar removeExplainWarnExtra()
 *
 * ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar removeExplainWarnScalability()
 *
 * ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar removeExplainWarnSelectType()
 *
 * IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar removeIgnoreRules()
 *
 * IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar removeIndexPrefix()
 *
 * ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar removeListHeuristicRules()
 *
 * ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar removeListReportTypes()
 *
 * ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar removeListRewriteRules()
 *
 * ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar removeListTestSqls()
 *
 * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar removeLogLevel()
 *
 * LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar removeLogOutput()
 *
 * log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar removeLogErrStacks()
 *
 * size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar removeLogRotateMaxSize()
 *
 * MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar removeMarkdownExtensions()
 *
 * MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar removeMarkdownHtmlFlags()
 *
 * MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar removeMaxColumnCount()
 *
 * MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar removeMaxDistinctCount()
 *
 * MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar removeMaxGroupByColsCount()
 *
 * MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar removeMaxInCount()
 *
 * MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar removeMaxIndexBytes()
 *
 * MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar removeMaxIndexBytesPercolumn()
 *
 * MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar removeMaxIndexColsCount()
 *
 * MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar removeMaxIndexCount()
 *
 * MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar removeMaxJoinTableCount()
 *
 * MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar removeMaxPrettySqlLength()
 *
 * MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar removeMaxQueryCost()
 *
 * MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar removeMaxSubqueryDepth()
 *
 * MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar removeMaxTextColsCount()
 *
 * MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar removeMaxTotalRows()
 *
 * MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar removeMaxValueCount()
 *
 * MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar removeMaxVarcharLength()
 *
 * MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar removeMinCardinality()
 *
 * OnlineDSN, 线上环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar removeOnlineDsn()
 *
 * OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar removeOnlySyntaxCheck()
 *
 * Print configs
 * @method \Guanguans\SoarPHP\Soar removePrintConfig()
 *
 * Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar removeProfiling()
 *
 * 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar removeQuery()
 *
 * ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar removeReportCss()
 *
 * ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar removeReportJavascript()
 *
 * ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar removeReportTitle()
 *
 * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar removeReportType()
 *
 * RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar removeRewriteRules()
 *
 * Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar removeSampling()
 *
 * SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar removeSamplingCondition()
 *
 * SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar removeSamplingStatisticTarget()
 *
 * ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar removeShowLastQueryCost()
 *
 * ShowWarnings
 * @method \Guanguans\SoarPHP\Soar removeShowWarnings()
 *
 * SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar removeSpaghettiQueryLength()
 *
 * TestDSN, 测试环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar removeTestDsn()
 *
 * Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar removeTrace()
 *
 * UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar removeUniqueKeyPrefix()
 *
 * Verbose
 * @method \Guanguans\SoarPHP\Soar removeVerbose()
 *
 * Print version info
 * @method \Guanguans\SoarPHP\Soar removeVersion()
 *
 * Help
 * @method \Guanguans\SoarPHP\Soar removeHelp()
 *
 * AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar onlyAllowCharsets()
 *
 * AllowCollates
 * @method \Guanguans\SoarPHP\Soar onlyAllowCollates()
 *
 * AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar onlyAllowDropIndex()
 *
 * AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar onlyAllowEngines()
 *
 * AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar onlyAllowOnlineAsTest()
 *
 * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar onlyBlacklist()
 *
 * Check configs
 * @method \Guanguans\SoarPHP\Soar onlyCheckConfig()
 *
 * 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar onlyCleanupTestDatabase()
 *
 * ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar onlyColumnNotAllowType()
 *
 * Config file path
 * @method \Guanguans\SoarPHP\Soar onlyConfig()
 *
 * Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar onlyDelimiter()
 *
 * DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar onlyDropTestTemporary()
 *
 * 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar onlyDryRun()
 *
 * Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar onlyExplain()
 *
 * ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar onlyExplainFormat()
 *
 * ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar onlyExplainMaxFiltered()
 *
 * ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar onlyExplainMaxKeys()
 *
 * ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar onlyExplainMaxRows()
 *
 * ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar onlyExplainMinKeys()
 *
 * ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar onlyExplainSqlReportType()
 *
 * ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar onlyExplainType()
 *
 * ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnAccessType()
 *
 * ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnExtra()
 *
 * ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnScalability()
 *
 * ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnSelectType()
 *
 * IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar onlyIgnoreRules()
 *
 * IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar onlyIndexPrefix()
 *
 * ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar onlyListHeuristicRules()
 *
 * ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar onlyListReportTypes()
 *
 * ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar onlyListRewriteRules()
 *
 * ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar onlyListTestSqls()
 *
 * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar onlyLogLevel()
 *
 * LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar onlyLogOutput()
 *
 * log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar onlyLogErrStacks()
 *
 * size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar onlyLogRotateMaxSize()
 *
 * MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar onlyMarkdownExtensions()
 *
 * MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar onlyMarkdownHtmlFlags()
 *
 * MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar onlyMaxColumnCount()
 *
 * MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxDistinctCount()
 *
 * MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxGroupByColsCount()
 *
 * MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar onlyMaxInCount()
 *
 * MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexBytes()
 *
 * MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexBytesPercolumn()
 *
 * MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexColsCount()
 *
 * MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexCount()
 *
 * MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxJoinTableCount()
 *
 * MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar onlyMaxPrettySqlLength()
 *
 * MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar onlyMaxQueryCost()
 *
 * MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxSubqueryDepth()
 *
 * MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar onlyMaxTextColsCount()
 *
 * MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar onlyMaxTotalRows()
 *
 * MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar onlyMaxValueCount()
 *
 * MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar onlyMaxVarcharLength()
 *
 * MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar onlyMinCardinality()
 *
 * OnlineDSN, 线上环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar onlyOnlineDsn()
 *
 * OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar onlyOnlySyntaxCheck()
 *
 * Print configs
 * @method \Guanguans\SoarPHP\Soar onlyPrintConfig()
 *
 * Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar onlyProfiling()
 *
 * 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar onlyQuery()
 *
 * ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar onlyReportCss()
 *
 * ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar onlyReportJavascript()
 *
 * ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar onlyReportTitle()
 *
 * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar onlyReportType()
 *
 * RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar onlyRewriteRules()
 *
 * Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar onlySampling()
 *
 * SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar onlySamplingCondition()
 *
 * SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar onlySamplingStatisticTarget()
 *
 * ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar onlyShowLastQueryCost()
 *
 * ShowWarnings
 * @method \Guanguans\SoarPHP\Soar onlyShowWarnings()
 *
 * SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar onlySpaghettiQueryLength()
 *
 * TestDSN, 测试环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar onlyTestDsn()
 *
 * Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar onlyTrace()
 *
 * UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar onlyUniqueKeyPrefix()
 *
 * Verbose
 * @method \Guanguans\SoarPHP\Soar onlyVerbose()
 *
 * Print version info
 * @method \Guanguans\SoarPHP\Soar onlyVersion()
 *
 * Help
 * @method \Guanguans\SoarPHP\Soar onlyHelp()
 *
 * AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar setAllowCharsets(string $allowCharsets)
 *
 * AllowCollates
 * @method \Guanguans\SoarPHP\Soar setAllowCollates(string $allowCollates)
 *
 * AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar setAllowDropIndex($allowDropIndex)
 *
 * AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar setAllowEngines(string $allowEngines)
 *
 * AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar setAllowOnlineAsTest($allowOnlineAsTest)
 *
 * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar setBlacklist(string $blacklist)
 *
 * Check configs
 * @method \Guanguans\SoarPHP\Soar setCheckConfig($checkConfig)
 *
 * 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar setCleanupTestDatabase($cleanupTestDatabase)
 *
 * ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar setColumnNotAllowType(string $columnNotAllowType)
 *
 * Config file path
 * @method \Guanguans\SoarPHP\Soar setConfig(string $config)
 *
 * Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar setDelimiter(string $delimiter)
 *
 * DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar setDropTestTemporary($dropTestTemporary)
 *
 * 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar setDryRun($dryRun)
 *
 * Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar setExplain($explain)
 *
 * ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar setExplainFormat(string $explainFormat)
 *
 * ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar setExplainMaxFiltered(float $explainMaxFiltered)
 *
 * ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar setExplainMaxKeys(int $explainMaxKeys)
 *
 * ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar setExplainMaxRows(int $explainMaxRows)
 *
 * ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar setExplainMinKeys(int $explainMinKeys)
 *
 * ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar setExplainSqlReportType(string $explainSqlReportType)
 *
 * ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar setExplainType(string $explainType)
 *
 * ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar setExplainWarnAccessType(string $explainWarnAccessType)
 *
 * ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar setExplainWarnExtra(string $explainWarnExtra)
 *
 * ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar setExplainWarnScalability(string $explainWarnScalability)
 *
 * ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar setExplainWarnSelectType(string $explainWarnSelectType)
 *
 * IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar setIgnoreRules(string $ignoreRules)
 *
 * IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar setIndexPrefix(string $indexPrefix)
 *
 * ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar setListHeuristicRules($listHeuristicRules)
 *
 * ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar setListReportTypes($listReportTypes)
 *
 * ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar setListRewriteRules($listRewriteRules)
 *
 * ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar setListTestSqls($listTestSqls)
 *
 * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar setLogLevel(int $logLevel)
 *
 * LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar setLogOutput(string $logOutput)
 *
 * log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar setLogErrStacks($logErrStacks)
 *
 * size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar setLogRotateMaxSize(int $logRotateMaxSize)
 *
 * MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar setMarkdownExtensions(int $markdownExtensions)
 *
 * MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar setMarkdownHtmlFlags(int $markdownHtmlFlags)
 *
 * MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar setMaxColumnCount(int $maxColumnCount)
 *
 * MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxDistinctCount(int $maxDistinctCount)
 *
 * MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxGroupByColsCount(int $maxGroupByColsCount)
 *
 * MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar setMaxInCount(int $maxInCount)
 *
 * MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexBytes(int $maxIndexBytes)
 *
 * MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn)
 *
 * MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexColsCount(int $maxIndexColsCount)
 *
 * MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexCount(int $maxIndexCount)
 *
 * MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxJoinTableCount(int $maxJoinTableCount)
 *
 * MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar setMaxPrettySqlLength(int $maxPrettySqlLength)
 *
 * MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar setMaxQueryCost(int $maxQueryCost)
 *
 * MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxSubqueryDepth(int $maxSubqueryDepth)
 *
 * MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar setMaxTextColsCount(int $maxTextColsCount)
 *
 * MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar setMaxTotalRows(int $maxTotalRows)
 *
 * MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar setMaxValueCount(int $maxValueCount)
 *
 * MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar setMaxVarcharLength(int $maxVarcharLength)
 *
 * MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar setMinCardinality(float $minCardinality)
 *
 * OnlineDSN, 线上环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar setOnlineDsn(string $onlineDsn)
 *
 * OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar setOnlySyntaxCheck($onlySyntaxCheck)
 *
 * Print configs
 * @method \Guanguans\SoarPHP\Soar setPrintConfig($printConfig)
 *
 * Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar setProfiling($profiling)
 *
 * 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar setQuery(string $query)
 *
 * ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar setReportCss(string $reportCss)
 *
 * ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar setReportJavascript(string $reportJavascript)
 *
 * ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar setReportTitle(string $reportTitle)
 *
 * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar setReportType(string $reportType)
 *
 * RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar setRewriteRules(string $rewriteRules)
 *
 * Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar setSampling($sampling)
 *
 * SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar setSamplingCondition(string $samplingCondition)
 *
 * SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar setSamplingStatisticTarget(int $samplingStatisticTarget)
 *
 * ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar setShowLastQueryCost($showLastQueryCost)
 *
 * ShowWarnings
 * @method \Guanguans\SoarPHP\Soar setShowWarnings($showWarnings)
 *
 * SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar setSpaghettiQueryLength(int $spaghettiQueryLength)
 *
 * TestDSN, 测试环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar setTestDsn(string $testDsn)
 *
 * Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar setTrace($trace)
 *
 * UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar setUniqueKeyPrefix(string $uniqueKeyPrefix)
 *
 * Verbose
 * @method \Guanguans\SoarPHP\Soar setVerbose($verbose)
 *
 * Print version info
 * @method \Guanguans\SoarPHP\Soar setVersion($version)
 *
 * Help
 * @method \Guanguans\SoarPHP\Soar setHelp($help)
 *
 * AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar mergeAllowCharsets(string $allowCharsets)
 *
 * AllowCollates
 * @method \Guanguans\SoarPHP\Soar mergeAllowCollates(string $allowCollates)
 *
 * AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar mergeAllowDropIndex($allowDropIndex)
 *
 * AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar mergeAllowEngines(string $allowEngines)
 *
 * AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar mergeAllowOnlineAsTest($allowOnlineAsTest)
 *
 * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar mergeBlacklist(string $blacklist)
 *
 * Check configs
 * @method \Guanguans\SoarPHP\Soar mergeCheckConfig($checkConfig)
 *
 * 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar mergeCleanupTestDatabase($cleanupTestDatabase)
 *
 * ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar mergeColumnNotAllowType(string $columnNotAllowType)
 *
 * Config file path
 * @method \Guanguans\SoarPHP\Soar mergeConfig(string $config)
 *
 * Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar mergeDelimiter(string $delimiter)
 *
 * DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar mergeDropTestTemporary($dropTestTemporary)
 *
 * 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar mergeDryRun($dryRun)
 *
 * Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar mergeExplain($explain)
 *
 * ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar mergeExplainFormat(string $explainFormat)
 *
 * ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar mergeExplainMaxFiltered(float $explainMaxFiltered)
 *
 * ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar mergeExplainMaxKeys(int $explainMaxKeys)
 *
 * ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar mergeExplainMaxRows(int $explainMaxRows)
 *
 * ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar mergeExplainMinKeys(int $explainMinKeys)
 *
 * ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar mergeExplainSqlReportType(string $explainSqlReportType)
 *
 * ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar mergeExplainType(string $explainType)
 *
 * ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar mergeExplainWarnAccessType(string $explainWarnAccessType)
 *
 * ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar mergeExplainWarnExtra(string $explainWarnExtra)
 *
 * ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar mergeExplainWarnScalability(string $explainWarnScalability)
 *
 * ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar mergeExplainWarnSelectType(string $explainWarnSelectType)
 *
 * IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar mergeIgnoreRules(string $ignoreRules)
 *
 * IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar mergeIndexPrefix(string $indexPrefix)
 *
 * ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar mergeListHeuristicRules($listHeuristicRules)
 *
 * ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar mergeListReportTypes($listReportTypes)
 *
 * ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar mergeListRewriteRules($listRewriteRules)
 *
 * ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar mergeListTestSqls($listTestSqls)
 *
 * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar mergeLogLevel(int $logLevel)
 *
 * LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar mergeLogOutput(string $logOutput)
 *
 * log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar mergeLogErrStacks($logErrStacks)
 *
 * size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar mergeLogRotateMaxSize(int $logRotateMaxSize)
 *
 * MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar mergeMarkdownExtensions(int $markdownExtensions)
 *
 * MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar mergeMarkdownHtmlFlags(int $markdownHtmlFlags)
 *
 * MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar mergeMaxColumnCount(int $maxColumnCount)
 *
 * MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar mergeMaxDistinctCount(int $maxDistinctCount)
 *
 * MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar mergeMaxGroupByColsCount(int $maxGroupByColsCount)
 *
 * MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar mergeMaxInCount(int $maxInCount)
 *
 * MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar mergeMaxIndexBytes(int $maxIndexBytes)
 *
 * MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar mergeMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn)
 *
 * MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar mergeMaxIndexColsCount(int $maxIndexColsCount)
 *
 * MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar mergeMaxIndexCount(int $maxIndexCount)
 *
 * MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar mergeMaxJoinTableCount(int $maxJoinTableCount)
 *
 * MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar mergeMaxPrettySqlLength(int $maxPrettySqlLength)
 *
 * MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar mergeMaxQueryCost(int $maxQueryCost)
 *
 * MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar mergeMaxSubqueryDepth(int $maxSubqueryDepth)
 *
 * MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar mergeMaxTextColsCount(int $maxTextColsCount)
 *
 * MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar mergeMaxTotalRows(int $maxTotalRows)
 *
 * MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar mergeMaxValueCount(int $maxValueCount)
 *
 * MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar mergeMaxVarcharLength(int $maxVarcharLength)
 *
 * MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar mergeMinCardinality(float $minCardinality)
 *
 * OnlineDSN, 线上环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar mergeOnlineDsn(string $onlineDsn)
 *
 * OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar mergeOnlySyntaxCheck($onlySyntaxCheck)
 *
 * Print configs
 * @method \Guanguans\SoarPHP\Soar mergePrintConfig($printConfig)
 *
 * Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar mergeProfiling($profiling)
 *
 * 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar mergeQuery(string $query)
 *
 * ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar mergeReportCss(string $reportCss)
 *
 * ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar mergeReportJavascript(string $reportJavascript)
 *
 * ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar mergeReportTitle(string $reportTitle)
 *
 * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar mergeReportType(string $reportType)
 *
 * RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar mergeRewriteRules(string $rewriteRules)
 *
 * Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar mergeSampling($sampling)
 *
 * SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar mergeSamplingCondition(string $samplingCondition)
 *
 * SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar mergeSamplingStatisticTarget(int $samplingStatisticTarget)
 *
 * ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar mergeShowLastQueryCost($showLastQueryCost)
 *
 * ShowWarnings
 * @method \Guanguans\SoarPHP\Soar mergeShowWarnings($showWarnings)
 *
 * SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar mergeSpaghettiQueryLength(int $spaghettiQueryLength)
 *
 * TestDSN, 测试环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar mergeTestDsn(string $testDsn)
 *
 * Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar mergeTrace($trace)
 *
 * UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar mergeUniqueKeyPrefix(string $uniqueKeyPrefix)
 *
 * Verbose
 * @method \Guanguans\SoarPHP\Soar mergeVerbose($verbose)
 *
 * Print version info
 * @method \Guanguans\SoarPHP\Soar mergeVersion($version)
 *
 * Help
 * @method \Guanguans\SoarPHP\Soar mergeHelp($help)
 *
 * AllowCharsets (default "utf8,utf8mb4")
 * @method null|string getAllowCharsets($default = null)
 *
 * AllowCollates
 * @method null|string getAllowCollates($default = null)
 *
 * AllowDropIndex, 允许输出删除重复索引的建议
 * @method null|mixed getAllowDropIndex($default = null)
 *
 * AllowEngines (default "innodb")
 * @method null|string getAllowEngines($default = null)
 *
 * AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method null|mixed getAllowOnlineAsTest($default = null)
 *
 * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method null|string getBlacklist($default = null)
 *
 * Check configs
 * @method null|mixed getCheckConfig($default = null)
 *
 * 单次运行清理历史1小时前残余的测试库。
 * @method null|mixed getCleanupTestDatabase($default = null)
 *
 * ColumnNotAllowType (default "boolean")
 * @method null|string getColumnNotAllowType($default = null)
 *
 * Config file path
 * @method null|string getConfig($default = null)
 *
 * Delimiter, SQL分隔符 (default ";")
 * @method null|string getDelimiter($default = null)
 *
 * DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method null|mixed getDropTestTemporary($default = null)
 *
 * 是否在预演环境执行 (default true)
 * @method null|mixed getDryRun($default = null)
 *
 * Explain, 是否开启Explain执行计划分析 (default true)
 * @method null|mixed getExplain($default = null)
 *
 * ExplainFormat [json, traditional] (default "traditional")
 * @method null|string getExplainFormat($default = null)
 *
 * ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method null|float getExplainMaxFiltered($default = null)
 *
 * ExplainMaxKeyLength, 最大key_len (default 3)
 * @method null|int getExplainMaxKeys($default = null)
 *
 * ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method null|int getExplainMaxRows($default = null)
 *
 * ExplainMinPossibleKeys, 最小possible_keys警告
 * @method null|int getExplainMinKeys($default = null)
 *
 * ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method null|string getExplainSqlReportType($default = null)
 *
 * ExplainType [extended, partitions, traditional] (default "extended")
 * @method null|string getExplainType($default = null)
 *
 * ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method null|string getExplainWarnAccessType($default = null)
 *
 * ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method null|string getExplainWarnExtra($default = null)
 *
 * ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method null|string getExplainWarnScalability($default = null)
 *
 * ExplainWarnSelectType, 哪些select_type不建议使用
 * @method null|string getExplainWarnSelectType($default = null)
 *
 * IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method null|string getIgnoreRules($default = null)
 *
 * IdxPrefix (default "idx_")
 * @method null|string getIndexPrefix($default = null)
 *
 * ListHeuristicRules, 打印支持的评审规则列表
 * @method null|mixed getListHeuristicRules($default = null)
 *
 * ListReportTypes, 打印支持的报告输出类型
 * @method null|mixed getListReportTypes($default = null)
 *
 * ListRewriteRules, 打印支持的重写规则列表
 * @method null|mixed getListRewriteRules($default = null)
 *
 * ListTestSqls, 打印测试case用于测试
 * @method null|mixed getListTestSqls($default = null)
 *
 * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method null|int getLogLevel($default = null)
 *
 * LogOutput, 日志输出位置 (default "soar.log")
 * @method null|string getLogOutput($default = null)
 *
 * log stack traces for errors
 * @method null|mixed getLogErrStacks($default = null)
 *
 * size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method null|int getLogRotateMaxSize($default = null)
 *
 * MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method null|int getMarkdownExtensions($default = null)
 *
 * MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method null|int getMarkdownHtmlFlags($default = null)
 *
 * MaxColCount, 单表允许的最大列数 (default 40)
 * @method null|int getMaxColumnCount($default = null)
 *
 * MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method null|int getMaxDistinctCount($default = null)
 *
 * MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method null|int getMaxGroupByColsCount($default = null)
 *
 * MaxInCount, IN()最大数量 (default 10)
 * @method null|int getMaxInCount($default = null)
 *
 * MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method null|int getMaxIndexBytes($default = null)
 *
 * MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method null|int getMaxIndexBytesPercolumn($default = null)
 *
 * MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method null|int getMaxIndexColsCount($default = null)
 *
 * MaxIdxCount, 单表最大索引个数 (default 10)
 * @method null|int getMaxIndexCount($default = null)
 *
 * MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method null|int getMaxJoinTableCount($default = null)
 *
 * MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method null|int getMaxPrettySqlLength($default = null)
 *
 * MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method null|int getMaxQueryCost($default = null)
 *
 * MaxSubqueryDepth (default 5)
 * @method null|int getMaxSubqueryDepth($default = null)
 *
 * MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method null|int getMaxTextColsCount($default = null)
 *
 * MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method null|int getMaxTotalRows($default = null)
 *
 * MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method null|int getMaxValueCount($default = null)
 *
 * MaxVarcharLength (default 1024)
 * @method null|int getMaxVarcharLength($default = null)
 *
 * MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method null|float getMinCardinality($default = null)
 *
 * OnlineDSN, 线上环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method null|string getOnlineDsn($default = null)
 *
 * OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method null|mixed getOnlySyntaxCheck($default = null)
 *
 * Print configs
 * @method null|mixed getPrintConfig($default = null)
 *
 * Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method null|mixed getProfiling($default = null)
 *
 * 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method null|string getQuery($default = null)
 *
 * ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method null|string getReportCss($default = null)
 *
 * ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method null|string getReportJavascript($default = null)
 *
 * ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method null|string getReportTitle($default = null)
 *
 * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method null|string getReportType($default = null)
 *
 * RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method null|string getRewriteRules($default = null)
 *
 * Sampling, 数据采样开关
 * @method null|mixed getSampling($default = null)
 *
 * SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method null|string getSamplingCondition($default = null)
 *
 * SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method null|int getSamplingStatisticTarget($default = null)
 *
 * ShowLastQueryCost
 * @method null|mixed getShowLastQueryCost($default = null)
 *
 * ShowWarnings
 * @method null|mixed getShowWarnings($default = null)
 *
 * SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method null|int getSpaghettiQueryLength($default = null)
 *
 * TestDSN, 测试环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method null|string getTestDsn($default = null)
 *
 * Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method null|mixed getTrace($default = null)
 *
 * UkPrefix (default "uk_")
 * @method null|string getUniqueKeyPrefix($default = null)
 *
 * Verbose
 * @method null|mixed getVerbose($default = null)
 *
 * Print version info
 * @method null|mixed getVersion($default = null)
 *
 * Help
 * @method null|mixed getHelp($default = null)
 *
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait HasOptions
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\BadMethodCallException
     */
    public function __call(string $name, array $arguments)
    {
        foreach (['add', 'remove', 'only', 'set', 'merge', 'get'] as $prefix) {
            if (str_starts_with($name, $prefix)) {
                $key = '-'.str_snake(substr($name, \strlen($prefix)), '-');
                $newName = $prefix.'Option';

                return $this->{$newName}($key, ...$arguments);
            }
        }

        throw new BadMethodCallException("The method($name) does not exist.");
    }

    public function addOptions(array $options): self
    {
        $this->options += $options;

        return $this;
    }

    public function addOption(string $key, $value): self
    {
        $this->addOptions([$key => $value]);

        return $this;
    }

    public function removeOptions(array $keys): self
    {
        foreach ($keys as $key) {
            unset($this->options[$key]);
        }

        return $this;
    }

    public function removeOption(string $key): self
    {
        $this->removeOptions([$key]);

        return $this;
    }

    public function onlyOptions(array $keys = ['-test-dsn', '-online-dsn']): self
    {
        $this->options = array_filter(
            $this->options,
            static function ($key) use ($keys): bool {
                return \in_array($key, $keys, true);
            },
            ARRAY_FILTER_USE_KEY
        );

        return $this;
    }

    public function onlyOption(string $key): self
    {
        $this->onlyOptions([$key]);

        return $this;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function setOption(string $key, $value): self
    {
        $this->options[$key] = $value;

        return $this;
    }

    public function mergeOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function mergeOption(string $key, $value): self
    {
        $this->mergeOptions([$key => $value]);

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getOption(string $key, $default = null)
    {
        return $this->options[$key] ?? $default;
    }

    public function getSerializedNormalizedOptions(): string
    {
        return implode(' ', $this->getNormalizedOptions());
    }

    public function getNormalizedOptions(): array
    {
        return $this->normalizeOptions($this->options);
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    private function normalizeOptions(array $options): array
    {
        return array_reduce_with_keys($options, function (array $normalizedOptions, $value, $key): array {
            if ($normalizedOption = $this->normalizeOption($key, $value)) {
                $normalizedOptions[\is_int($key) ? (string) $value : $key] = $normalizedOption;
            }

            return $normalizedOptions;
        }, []);
    }

    /**
     * @param array-key $key
     * @param mixed     $value
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    private function normalizeOption($key, $value): string
    {
        $converter = function ($value) {
            \is_callable($value) and $value = $value($this);
            true === $value and $value = 'true';
            false === $value and $value = 'false';
            0 === $value and $value = '0';

            return $value;
        };

        $value = $converter($value);
        if (null === $value) {
            return '';
        }

        if (\is_scalar($value) || (\is_object($value) && method_exists($value, '__toString'))) {
            if (\is_int($key)) {
                return (string) $value;
            }

            return "$key=$value";
        }

        if (\is_array($value)) {
            if (\in_array($key, ['-test-dsn', '-online-dsn'], true) && ! ($value['disable'] ?? false)) {
                $dsn = "{$value['username']}:{$value['password']}@{$value['host']}:{$value['port']}/{$value['dbname']}";

                return "$key=$dsn";
            }

            return "$key=".implode(',', array_map($converter, $value));
        }

        throw new InvalidOptionException(sprintf('Invalid configuration type(%s).', \gettype($value)));
    }
}
