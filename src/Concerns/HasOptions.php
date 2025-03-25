<?php

/** @noinspection MissingParameterTypeDeclarationInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

namespace Guanguans\SoarPHP\Concerns;

use Guanguans\SoarPHP\Exceptions\BadMethodCallException;
use Guanguans\SoarPHP\Exceptions\InvalidOptionException;
use function Guanguans\SoarPHP\Support\array_reduce_with_keys;
use function Guanguans\SoarPHP\Support\str_snake;

/**
 * AllowCharsets (default "utf8,utf8mb4").
 *
 * @method self addAllowCharsets(string $allowCharsets)
 *
 * AllowCollates
 * @method self addAllowCollates(string $allowCollates)
 *
 * AllowDropIndex, 允许输出删除重复索引的建议
 * @method self addAllowDropIndex( $allowDropIndex)
 *
 * AllowEngines (default "innodb")
 * @method self addAllowEngines(string $allowEngines)
 *
 * AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method self addAllowOnlineAsTest( $allowOnlineAsTest)
 *
 * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method self addBlacklist(string $blacklist)
 *
 * Check configs
 * @method self addCheckConfig( $checkConfig)
 *
 * 单次运行清理历史1小时前残余的测试库。
 * @method self addCleanupTestDatabase( $cleanupTestDatabase)
 *
 * ColumnNotAllowType (default "boolean")
 * @method self addColumnNotAllowType(string $columnNotAllowType)
 *
 * Config file path
 * @method self addConfig(string $config)
 *
 * Delimiter, SQL分隔符 (default ";")
 * @method self addDelimiter(string $delimiter)
 *
 * DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method self addDropTestTemporary( $dropTestTemporary)
 *
 * 是否在预演环境执行 (default true)
 * @method self addDryRun( $dryRun)
 *
 * Explain, 是否开启Explain执行计划分析 (default true)
 * @method self addExplain( $explain)
 *
 * ExplainFormat [json, traditional] (default "traditional")
 * @method self addExplainFormat(string $explainFormat)
 *
 * ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method self addExplainMaxFiltered(float $explainMaxFiltered)
 *
 * ExplainMaxKeyLength, 最大key_len (default 3)
 * @method self addExplainMaxKeys(int $explainMaxKeys)
 *
 * ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method self addExplainMaxRows(int $explainMaxRows)
 *
 * ExplainMinPossibleKeys, 最小possible_keys警告
 * @method self addExplainMinKeys(int $explainMinKeys)
 *
 * ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method self addExplainSqlReportType(string $explainSqlReportType)
 *
 * ExplainType [extended, partitions, traditional] (default "extended")
 * @method self addExplainType(string $explainType)
 *
 * ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method self addExplainWarnAccessType(string $explainWarnAccessType)
 *
 * ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method self addExplainWarnExtra(string $explainWarnExtra)
 *
 * ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method self addExplainWarnScalability(string $explainWarnScalability)
 *
 * ExplainWarnSelectType, 哪些select_type不建议使用
 * @method self addExplainWarnSelectType(string $explainWarnSelectType)
 *
 * IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method self addIgnoreRules(string $ignoreRules)
 *
 * IdxPrefix (default "idx_")
 * @method self addIndexPrefix(string $indexPrefix)
 *
 * ListHeuristicRules, 打印支持的评审规则列表
 * @method self addListHeuristicRules( $listHeuristicRules)
 *
 * ListReportTypes, 打印支持的报告输出类型
 * @method self addListReportTypes( $listReportTypes)
 *
 * ListRewriteRules, 打印支持的重写规则列表
 * @method self addListRewriteRules( $listRewriteRules)
 *
 * ListTestSqls, 打印测试case用于测试
 * @method self addListTestSqls( $listTestSqls)
 *
 * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method self addLogLevel(int $logLevel)
 *
 * LogOutput, 日志输出位置 (default "soar.log")
 * @method self addLogOutput(string $logOutput)
 *
 * log stack traces for errors
 * @method self addLogErrStacks( $logErrStacks)
 *
 * size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method self addLogRotateMaxSize(int $logRotateMaxSize)
 *
 * MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method self addMarkdownExtensions(int $markdownExtensions)
 *
 * MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method self addMarkdownHtmlFlags(int $markdownHtmlFlags)
 *
 * MaxColCount, 单表允许的最大列数 (default 40)
 * @method self addMaxColumnCount(int $maxColumnCount)
 *
 * MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method self addMaxDistinctCount(int $maxDistinctCount)
 *
 * MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method self addMaxGroupByColsCount(int $maxGroupByColsCount)
 *
 * MaxInCount, IN()最大数量 (default 10)
 * @method self addMaxInCount(int $maxInCount)
 *
 * MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method self addMaxIndexBytes(int $maxIndexBytes)
 *
 * MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method self addMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn)
 *
 * MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method self addMaxIndexColsCount(int $maxIndexColsCount)
 *
 * MaxIdxCount, 单表最大索引个数 (default 10)
 * @method self addMaxIndexCount(int $maxIndexCount)
 *
 * MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method self addMaxJoinTableCount(int $maxJoinTableCount)
 *
 * MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method self addMaxPrettySqlLength(int $maxPrettySqlLength)
 *
 * MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method self addMaxQueryCost(int $maxQueryCost)
 *
 * MaxSubqueryDepth (default 5)
 * @method self addMaxSubqueryDepth(int $maxSubqueryDepth)
 *
 * MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method self addMaxTextColsCount(int $maxTextColsCount)
 *
 * MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method self addMaxTotalRows(int $maxTotalRows)
 *
 * MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method self addMaxValueCount(int $maxValueCount)
 *
 * MaxVarcharLength (default 1024)
 * @method self addMaxVarcharLength(int $maxVarcharLength)
 *
 * MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method self addMinCardinality(float $minCardinality)
 *
 * OnlineDSN, 线上环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self addOnlineDsn(string $onlineDsn)
 *
 * OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method self addOnlySyntaxCheck( $onlySyntaxCheck)
 *
 * Print configs
 * @method self addPrintConfig( $printConfig)
 *
 * Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method self addProfiling( $profiling)
 *
 * 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method self addQuery(string $query)
 *
 * ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method self addReportCss(string $reportCss)
 *
 * ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method self addReportJavascript(string $reportJavascript)
 *
 * ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method self addReportTitle(string $reportTitle)
 *
 * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method self addReportType(string $reportType)
 *
 * RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method self addRewriteRules(string $rewriteRules)
 *
 * Sampling, 数据采样开关
 * @method self addSampling( $sampling)
 *
 * SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method self addSamplingCondition(string $samplingCondition)
 *
 * SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method self addSamplingStatisticTarget(int $samplingStatisticTarget)
 *
 * ShowLastQueryCost
 * @method self addShowLastQueryCost( $showLastQueryCost)
 *
 * ShowWarnings
 * @method self addShowWarnings( $showWarnings)
 *
 * SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method self addSpaghettiQueryLength(int $spaghettiQueryLength)
 *
 * TestDSN, 测试环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self addTestDsn(string $testDsn)
 *
 * Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method self addTrace( $trace)
 *
 * UkPrefix (default "uk_")
 * @method self addUniqueKeyPrefix(string $uniqueKeyPrefix)
 *
 * Verbose
 * @method self addVerbose( $verbose)
 *
 * Print version info
 * @method self addVersion( $version)
 *
 * Help
 * @method self addHelp( $help)
 *
 * AllowCharsets (default "utf8,utf8mb4")
 * @method self removeAllowCharsets()
 *
 * AllowCollates
 * @method self removeAllowCollates()
 *
 * AllowDropIndex, 允许输出删除重复索引的建议
 * @method self removeAllowDropIndex()
 *
 * AllowEngines (default "innodb")
 * @method self removeAllowEngines()
 *
 * AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method self removeAllowOnlineAsTest()
 *
 * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method self removeBlacklist()
 *
 * Check configs
 * @method self removeCheckConfig()
 *
 * 单次运行清理历史1小时前残余的测试库。
 * @method self removeCleanupTestDatabase()
 *
 * ColumnNotAllowType (default "boolean")
 * @method self removeColumnNotAllowType()
 *
 * Config file path
 * @method self removeConfig()
 *
 * Delimiter, SQL分隔符 (default ";")
 * @method self removeDelimiter()
 *
 * DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method self removeDropTestTemporary()
 *
 * 是否在预演环境执行 (default true)
 * @method self removeDryRun()
 *
 * Explain, 是否开启Explain执行计划分析 (default true)
 * @method self removeExplain()
 *
 * ExplainFormat [json, traditional] (default "traditional")
 * @method self removeExplainFormat()
 *
 * ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method self removeExplainMaxFiltered()
 *
 * ExplainMaxKeyLength, 最大key_len (default 3)
 * @method self removeExplainMaxKeys()
 *
 * ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method self removeExplainMaxRows()
 *
 * ExplainMinPossibleKeys, 最小possible_keys警告
 * @method self removeExplainMinKeys()
 *
 * ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method self removeExplainSqlReportType()
 *
 * ExplainType [extended, partitions, traditional] (default "extended")
 * @method self removeExplainType()
 *
 * ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method self removeExplainWarnAccessType()
 *
 * ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method self removeExplainWarnExtra()
 *
 * ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method self removeExplainWarnScalability()
 *
 * ExplainWarnSelectType, 哪些select_type不建议使用
 * @method self removeExplainWarnSelectType()
 *
 * IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method self removeIgnoreRules()
 *
 * IdxPrefix (default "idx_")
 * @method self removeIndexPrefix()
 *
 * ListHeuristicRules, 打印支持的评审规则列表
 * @method self removeListHeuristicRules()
 *
 * ListReportTypes, 打印支持的报告输出类型
 * @method self removeListReportTypes()
 *
 * ListRewriteRules, 打印支持的重写规则列表
 * @method self removeListRewriteRules()
 *
 * ListTestSqls, 打印测试case用于测试
 * @method self removeListTestSqls()
 *
 * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method self removeLogLevel()
 *
 * LogOutput, 日志输出位置 (default "soar.log")
 * @method self removeLogOutput()
 *
 * log stack traces for errors
 * @method self removeLogErrStacks()
 *
 * size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method self removeLogRotateMaxSize()
 *
 * MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method self removeMarkdownExtensions()
 *
 * MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method self removeMarkdownHtmlFlags()
 *
 * MaxColCount, 单表允许的最大列数 (default 40)
 * @method self removeMaxColumnCount()
 *
 * MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method self removeMaxDistinctCount()
 *
 * MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method self removeMaxGroupByColsCount()
 *
 * MaxInCount, IN()最大数量 (default 10)
 * @method self removeMaxInCount()
 *
 * MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method self removeMaxIndexBytes()
 *
 * MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method self removeMaxIndexBytesPercolumn()
 *
 * MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method self removeMaxIndexColsCount()
 *
 * MaxIdxCount, 单表最大索引个数 (default 10)
 * @method self removeMaxIndexCount()
 *
 * MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method self removeMaxJoinTableCount()
 *
 * MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method self removeMaxPrettySqlLength()
 *
 * MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method self removeMaxQueryCost()
 *
 * MaxSubqueryDepth (default 5)
 * @method self removeMaxSubqueryDepth()
 *
 * MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method self removeMaxTextColsCount()
 *
 * MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method self removeMaxTotalRows()
 *
 * MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method self removeMaxValueCount()
 *
 * MaxVarcharLength (default 1024)
 * @method self removeMaxVarcharLength()
 *
 * MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method self removeMinCardinality()
 *
 * OnlineDSN, 线上环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self removeOnlineDsn()
 *
 * OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method self removeOnlySyntaxCheck()
 *
 * Print configs
 * @method self removePrintConfig()
 *
 * Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method self removeProfiling()
 *
 * 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method self removeQuery()
 *
 * ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method self removeReportCss()
 *
 * ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method self removeReportJavascript()
 *
 * ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method self removeReportTitle()
 *
 * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method self removeReportType()
 *
 * RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method self removeRewriteRules()
 *
 * Sampling, 数据采样开关
 * @method self removeSampling()
 *
 * SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method self removeSamplingCondition()
 *
 * SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method self removeSamplingStatisticTarget()
 *
 * ShowLastQueryCost
 * @method self removeShowLastQueryCost()
 *
 * ShowWarnings
 * @method self removeShowWarnings()
 *
 * SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method self removeSpaghettiQueryLength()
 *
 * TestDSN, 测试环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self removeTestDsn()
 *
 * Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method self removeTrace()
 *
 * UkPrefix (default "uk_")
 * @method self removeUniqueKeyPrefix()
 *
 * Verbose
 * @method self removeVerbose()
 *
 * Print version info
 * @method self removeVersion()
 *
 * Help
 * @method self removeHelp()
 *
 * AllowCharsets (default "utf8,utf8mb4")
 * @method self onlyAllowCharsets()
 *
 * AllowCollates
 * @method self onlyAllowCollates()
 *
 * AllowDropIndex, 允许输出删除重复索引的建议
 * @method self onlyAllowDropIndex()
 *
 * AllowEngines (default "innodb")
 * @method self onlyAllowEngines()
 *
 * AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method self onlyAllowOnlineAsTest()
 *
 * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method self onlyBlacklist()
 *
 * Check configs
 * @method self onlyCheckConfig()
 *
 * 单次运行清理历史1小时前残余的测试库。
 * @method self onlyCleanupTestDatabase()
 *
 * ColumnNotAllowType (default "boolean")
 * @method self onlyColumnNotAllowType()
 *
 * Config file path
 * @method self onlyConfig()
 *
 * Delimiter, SQL分隔符 (default ";")
 * @method self onlyDelimiter()
 *
 * DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method self onlyDropTestTemporary()
 *
 * 是否在预演环境执行 (default true)
 * @method self onlyDryRun()
 *
 * Explain, 是否开启Explain执行计划分析 (default true)
 * @method self onlyExplain()
 *
 * ExplainFormat [json, traditional] (default "traditional")
 * @method self onlyExplainFormat()
 *
 * ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method self onlyExplainMaxFiltered()
 *
 * ExplainMaxKeyLength, 最大key_len (default 3)
 * @method self onlyExplainMaxKeys()
 *
 * ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method self onlyExplainMaxRows()
 *
 * ExplainMinPossibleKeys, 最小possible_keys警告
 * @method self onlyExplainMinKeys()
 *
 * ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method self onlyExplainSqlReportType()
 *
 * ExplainType [extended, partitions, traditional] (default "extended")
 * @method self onlyExplainType()
 *
 * ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method self onlyExplainWarnAccessType()
 *
 * ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method self onlyExplainWarnExtra()
 *
 * ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method self onlyExplainWarnScalability()
 *
 * ExplainWarnSelectType, 哪些select_type不建议使用
 * @method self onlyExplainWarnSelectType()
 *
 * IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method self onlyIgnoreRules()
 *
 * IdxPrefix (default "idx_")
 * @method self onlyIndexPrefix()
 *
 * ListHeuristicRules, 打印支持的评审规则列表
 * @method self onlyListHeuristicRules()
 *
 * ListReportTypes, 打印支持的报告输出类型
 * @method self onlyListReportTypes()
 *
 * ListRewriteRules, 打印支持的重写规则列表
 * @method self onlyListRewriteRules()
 *
 * ListTestSqls, 打印测试case用于测试
 * @method self onlyListTestSqls()
 *
 * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method self onlyLogLevel()
 *
 * LogOutput, 日志输出位置 (default "soar.log")
 * @method self onlyLogOutput()
 *
 * log stack traces for errors
 * @method self onlyLogErrStacks()
 *
 * size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method self onlyLogRotateMaxSize()
 *
 * MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method self onlyMarkdownExtensions()
 *
 * MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method self onlyMarkdownHtmlFlags()
 *
 * MaxColCount, 单表允许的最大列数 (default 40)
 * @method self onlyMaxColumnCount()
 *
 * MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method self onlyMaxDistinctCount()
 *
 * MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method self onlyMaxGroupByColsCount()
 *
 * MaxInCount, IN()最大数量 (default 10)
 * @method self onlyMaxInCount()
 *
 * MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method self onlyMaxIndexBytes()
 *
 * MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method self onlyMaxIndexBytesPercolumn()
 *
 * MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method self onlyMaxIndexColsCount()
 *
 * MaxIdxCount, 单表最大索引个数 (default 10)
 * @method self onlyMaxIndexCount()
 *
 * MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method self onlyMaxJoinTableCount()
 *
 * MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method self onlyMaxPrettySqlLength()
 *
 * MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method self onlyMaxQueryCost()
 *
 * MaxSubqueryDepth (default 5)
 * @method self onlyMaxSubqueryDepth()
 *
 * MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method self onlyMaxTextColsCount()
 *
 * MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method self onlyMaxTotalRows()
 *
 * MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method self onlyMaxValueCount()
 *
 * MaxVarcharLength (default 1024)
 * @method self onlyMaxVarcharLength()
 *
 * MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method self onlyMinCardinality()
 *
 * OnlineDSN, 线上环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self onlyOnlineDsn()
 *
 * OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method self onlyOnlySyntaxCheck()
 *
 * Print configs
 * @method self onlyPrintConfig()
 *
 * Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method self onlyProfiling()
 *
 * 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method self onlyQuery()
 *
 * ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method self onlyReportCss()
 *
 * ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method self onlyReportJavascript()
 *
 * ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method self onlyReportTitle()
 *
 * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method self onlyReportType()
 *
 * RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method self onlyRewriteRules()
 *
 * Sampling, 数据采样开关
 * @method self onlySampling()
 *
 * SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method self onlySamplingCondition()
 *
 * SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method self onlySamplingStatisticTarget()
 *
 * ShowLastQueryCost
 * @method self onlyShowLastQueryCost()
 *
 * ShowWarnings
 * @method self onlyShowWarnings()
 *
 * SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method self onlySpaghettiQueryLength()
 *
 * TestDSN, 测试环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self onlyTestDsn()
 *
 * Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method self onlyTrace()
 *
 * UkPrefix (default "uk_")
 * @method self onlyUniqueKeyPrefix()
 *
 * Verbose
 * @method self onlyVerbose()
 *
 * Print version info
 * @method self onlyVersion()
 *
 * Help
 * @method self onlyHelp()
 *
 * AllowCharsets (default "utf8,utf8mb4")
 * @method self setAllowCharsets(string $allowCharsets)
 *
 * AllowCollates
 * @method self setAllowCollates(string $allowCollates)
 *
 * AllowDropIndex, 允许输出删除重复索引的建议
 * @method self setAllowDropIndex( $allowDropIndex)
 *
 * AllowEngines (default "innodb")
 * @method self setAllowEngines(string $allowEngines)
 *
 * AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method self setAllowOnlineAsTest( $allowOnlineAsTest)
 *
 * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method self setBlacklist(string $blacklist)
 *
 * Check configs
 * @method self setCheckConfig( $checkConfig)
 *
 * 单次运行清理历史1小时前残余的测试库。
 * @method self setCleanupTestDatabase( $cleanupTestDatabase)
 *
 * ColumnNotAllowType (default "boolean")
 * @method self setColumnNotAllowType(string $columnNotAllowType)
 *
 * Config file path
 * @method self setConfig(string $config)
 *
 * Delimiter, SQL分隔符 (default ";")
 * @method self setDelimiter(string $delimiter)
 *
 * DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method self setDropTestTemporary( $dropTestTemporary)
 *
 * 是否在预演环境执行 (default true)
 * @method self setDryRun( $dryRun)
 *
 * Explain, 是否开启Explain执行计划分析 (default true)
 * @method self setExplain( $explain)
 *
 * ExplainFormat [json, traditional] (default "traditional")
 * @method self setExplainFormat(string $explainFormat)
 *
 * ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method self setExplainMaxFiltered(float $explainMaxFiltered)
 *
 * ExplainMaxKeyLength, 最大key_len (default 3)
 * @method self setExplainMaxKeys(int $explainMaxKeys)
 *
 * ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method self setExplainMaxRows(int $explainMaxRows)
 *
 * ExplainMinPossibleKeys, 最小possible_keys警告
 * @method self setExplainMinKeys(int $explainMinKeys)
 *
 * ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method self setExplainSqlReportType(string $explainSqlReportType)
 *
 * ExplainType [extended, partitions, traditional] (default "extended")
 * @method self setExplainType(string $explainType)
 *
 * ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method self setExplainWarnAccessType(string $explainWarnAccessType)
 *
 * ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method self setExplainWarnExtra(string $explainWarnExtra)
 *
 * ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method self setExplainWarnScalability(string $explainWarnScalability)
 *
 * ExplainWarnSelectType, 哪些select_type不建议使用
 * @method self setExplainWarnSelectType(string $explainWarnSelectType)
 *
 * IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method self setIgnoreRules(string $ignoreRules)
 *
 * IdxPrefix (default "idx_")
 * @method self setIndexPrefix(string $indexPrefix)
 *
 * ListHeuristicRules, 打印支持的评审规则列表
 * @method self setListHeuristicRules( $listHeuristicRules)
 *
 * ListReportTypes, 打印支持的报告输出类型
 * @method self setListReportTypes( $listReportTypes)
 *
 * ListRewriteRules, 打印支持的重写规则列表
 * @method self setListRewriteRules( $listRewriteRules)
 *
 * ListTestSqls, 打印测试case用于测试
 * @method self setListTestSqls( $listTestSqls)
 *
 * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method self setLogLevel(int $logLevel)
 *
 * LogOutput, 日志输出位置 (default "soar.log")
 * @method self setLogOutput(string $logOutput)
 *
 * log stack traces for errors
 * @method self setLogErrStacks( $logErrStacks)
 *
 * size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method self setLogRotateMaxSize(int $logRotateMaxSize)
 *
 * MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method self setMarkdownExtensions(int $markdownExtensions)
 *
 * MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method self setMarkdownHtmlFlags(int $markdownHtmlFlags)
 *
 * MaxColCount, 单表允许的最大列数 (default 40)
 * @method self setMaxColumnCount(int $maxColumnCount)
 *
 * MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method self setMaxDistinctCount(int $maxDistinctCount)
 *
 * MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method self setMaxGroupByColsCount(int $maxGroupByColsCount)
 *
 * MaxInCount, IN()最大数量 (default 10)
 * @method self setMaxInCount(int $maxInCount)
 *
 * MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method self setMaxIndexBytes(int $maxIndexBytes)
 *
 * MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method self setMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn)
 *
 * MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method self setMaxIndexColsCount(int $maxIndexColsCount)
 *
 * MaxIdxCount, 单表最大索引个数 (default 10)
 * @method self setMaxIndexCount(int $maxIndexCount)
 *
 * MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method self setMaxJoinTableCount(int $maxJoinTableCount)
 *
 * MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method self setMaxPrettySqlLength(int $maxPrettySqlLength)
 *
 * MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method self setMaxQueryCost(int $maxQueryCost)
 *
 * MaxSubqueryDepth (default 5)
 * @method self setMaxSubqueryDepth(int $maxSubqueryDepth)
 *
 * MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method self setMaxTextColsCount(int $maxTextColsCount)
 *
 * MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method self setMaxTotalRows(int $maxTotalRows)
 *
 * MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method self setMaxValueCount(int $maxValueCount)
 *
 * MaxVarcharLength (default 1024)
 * @method self setMaxVarcharLength(int $maxVarcharLength)
 *
 * MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method self setMinCardinality(float $minCardinality)
 *
 * OnlineDSN, 线上环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self setOnlineDsn(string $onlineDsn)
 *
 * OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method self setOnlySyntaxCheck( $onlySyntaxCheck)
 *
 * Print configs
 * @method self setPrintConfig( $printConfig)
 *
 * Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method self setProfiling( $profiling)
 *
 * 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method self setQuery(string $query)
 *
 * ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method self setReportCss(string $reportCss)
 *
 * ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method self setReportJavascript(string $reportJavascript)
 *
 * ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method self setReportTitle(string $reportTitle)
 *
 * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method self setReportType(string $reportType)
 *
 * RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method self setRewriteRules(string $rewriteRules)
 *
 * Sampling, 数据采样开关
 * @method self setSampling( $sampling)
 *
 * SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method self setSamplingCondition(string $samplingCondition)
 *
 * SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method self setSamplingStatisticTarget(int $samplingStatisticTarget)
 *
 * ShowLastQueryCost
 * @method self setShowLastQueryCost( $showLastQueryCost)
 *
 * ShowWarnings
 * @method self setShowWarnings( $showWarnings)
 *
 * SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method self setSpaghettiQueryLength(int $spaghettiQueryLength)
 *
 * TestDSN, 测试环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self setTestDsn(string $testDsn)
 *
 * Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method self setTrace( $trace)
 *
 * UkPrefix (default "uk_")
 * @method self setUniqueKeyPrefix(string $uniqueKeyPrefix)
 *
 * Verbose
 * @method self setVerbose( $verbose)
 *
 * Print version info
 * @method self setVersion( $version)
 *
 * Help
 * @method self setHelp( $help)
 *
 * AllowCharsets (default "utf8,utf8mb4")
 * @method self mergeAllowCharsets(string $allowCharsets)
 *
 * AllowCollates
 * @method self mergeAllowCollates(string $allowCollates)
 *
 * AllowDropIndex, 允许输出删除重复索引的建议
 * @method self mergeAllowDropIndex( $allowDropIndex)
 *
 * AllowEngines (default "innodb")
 * @method self mergeAllowEngines(string $allowEngines)
 *
 * AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method self mergeAllowOnlineAsTest( $allowOnlineAsTest)
 *
 * 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method self mergeBlacklist(string $blacklist)
 *
 * Check configs
 * @method self mergeCheckConfig( $checkConfig)
 *
 * 单次运行清理历史1小时前残余的测试库。
 * @method self mergeCleanupTestDatabase( $cleanupTestDatabase)
 *
 * ColumnNotAllowType (default "boolean")
 * @method self mergeColumnNotAllowType(string $columnNotAllowType)
 *
 * Config file path
 * @method self mergeConfig(string $config)
 *
 * Delimiter, SQL分隔符 (default ";")
 * @method self mergeDelimiter(string $delimiter)
 *
 * DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method self mergeDropTestTemporary( $dropTestTemporary)
 *
 * 是否在预演环境执行 (default true)
 * @method self mergeDryRun( $dryRun)
 *
 * Explain, 是否开启Explain执行计划分析 (default true)
 * @method self mergeExplain( $explain)
 *
 * ExplainFormat [json, traditional] (default "traditional")
 * @method self mergeExplainFormat(string $explainFormat)
 *
 * ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method self mergeExplainMaxFiltered(float $explainMaxFiltered)
 *
 * ExplainMaxKeyLength, 最大key_len (default 3)
 * @method self mergeExplainMaxKeys(int $explainMaxKeys)
 *
 * ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method self mergeExplainMaxRows(int $explainMaxRows)
 *
 * ExplainMinPossibleKeys, 最小possible_keys警告
 * @method self mergeExplainMinKeys(int $explainMinKeys)
 *
 * ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method self mergeExplainSqlReportType(string $explainSqlReportType)
 *
 * ExplainType [extended, partitions, traditional] (default "extended")
 * @method self mergeExplainType(string $explainType)
 *
 * ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method self mergeExplainWarnAccessType(string $explainWarnAccessType)
 *
 * ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method self mergeExplainWarnExtra(string $explainWarnExtra)
 *
 * ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method self mergeExplainWarnScalability(string $explainWarnScalability)
 *
 * ExplainWarnSelectType, 哪些select_type不建议使用
 * @method self mergeExplainWarnSelectType(string $explainWarnSelectType)
 *
 * IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method self mergeIgnoreRules(string $ignoreRules)
 *
 * IdxPrefix (default "idx_")
 * @method self mergeIndexPrefix(string $indexPrefix)
 *
 * ListHeuristicRules, 打印支持的评审规则列表
 * @method self mergeListHeuristicRules( $listHeuristicRules)
 *
 * ListReportTypes, 打印支持的报告输出类型
 * @method self mergeListReportTypes( $listReportTypes)
 *
 * ListRewriteRules, 打印支持的重写规则列表
 * @method self mergeListRewriteRules( $listRewriteRules)
 *
 * ListTestSqls, 打印测试case用于测试
 * @method self mergeListTestSqls( $listTestSqls)
 *
 * LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method self mergeLogLevel(int $logLevel)
 *
 * LogOutput, 日志输出位置 (default "soar.log")
 * @method self mergeLogOutput(string $logOutput)
 *
 * log stack traces for errors
 * @method self mergeLogErrStacks( $logErrStacks)
 *
 * size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method self mergeLogRotateMaxSize(int $logRotateMaxSize)
 *
 * MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method self mergeMarkdownExtensions(int $markdownExtensions)
 *
 * MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method self mergeMarkdownHtmlFlags(int $markdownHtmlFlags)
 *
 * MaxColCount, 单表允许的最大列数 (default 40)
 * @method self mergeMaxColumnCount(int $maxColumnCount)
 *
 * MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method self mergeMaxDistinctCount(int $maxDistinctCount)
 *
 * MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method self mergeMaxGroupByColsCount(int $maxGroupByColsCount)
 *
 * MaxInCount, IN()最大数量 (default 10)
 * @method self mergeMaxInCount(int $maxInCount)
 *
 * MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method self mergeMaxIndexBytes(int $maxIndexBytes)
 *
 * MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method self mergeMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn)
 *
 * MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method self mergeMaxIndexColsCount(int $maxIndexColsCount)
 *
 * MaxIdxCount, 单表最大索引个数 (default 10)
 * @method self mergeMaxIndexCount(int $maxIndexCount)
 *
 * MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method self mergeMaxJoinTableCount(int $maxJoinTableCount)
 *
 * MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method self mergeMaxPrettySqlLength(int $maxPrettySqlLength)
 *
 * MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method self mergeMaxQueryCost(int $maxQueryCost)
 *
 * MaxSubqueryDepth (default 5)
 * @method self mergeMaxSubqueryDepth(int $maxSubqueryDepth)
 *
 * MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method self mergeMaxTextColsCount(int $maxTextColsCount)
 *
 * MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method self mergeMaxTotalRows(int $maxTotalRows)
 *
 * MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method self mergeMaxValueCount(int $maxValueCount)
 *
 * MaxVarcharLength (default 1024)
 * @method self mergeMaxVarcharLength(int $maxVarcharLength)
 *
 * MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method self mergeMinCardinality(float $minCardinality)
 *
 * OnlineDSN, 线上环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self mergeOnlineDsn(string $onlineDsn)
 *
 * OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method self mergeOnlySyntaxCheck( $onlySyntaxCheck)
 *
 * Print configs
 * @method self mergePrintConfig( $printConfig)
 *
 * Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method self mergeProfiling( $profiling)
 *
 * 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method self mergeQuery(string $query)
 *
 * ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method self mergeReportCss(string $reportCss)
 *
 * ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method self mergeReportJavascript(string $reportJavascript)
 *
 * ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method self mergeReportTitle(string $reportTitle)
 *
 * ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method self mergeReportType(string $reportType)
 *
 * RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method self mergeRewriteRules(string $rewriteRules)
 *
 * Sampling, 数据采样开关
 * @method self mergeSampling( $sampling)
 *
 * SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method self mergeSamplingCondition(string $samplingCondition)
 *
 * SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method self mergeSamplingStatisticTarget(int $samplingStatisticTarget)
 *
 * ShowLastQueryCost
 * @method self mergeShowLastQueryCost( $showLastQueryCost)
 *
 * ShowWarnings
 * @method self mergeShowWarnings( $showWarnings)
 *
 * SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method self mergeSpaghettiQueryLength(int $spaghettiQueryLength)
 *
 * TestDSN, 测试环境数据库配置, username:********tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self mergeTestDsn(string $testDsn)
 *
 * Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method self mergeTrace( $trace)
 *
 * UkPrefix (default "uk_")
 * @method self mergeUniqueKeyPrefix(string $uniqueKeyPrefix)
 *
 * Verbose
 * @method self mergeVerbose( $verbose)
 *
 * Print version info
 * @method self mergeVersion( $version)
 *
 * Help
 * @method self mergeHelp( $help)
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
    protected array $options = [];

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\BadMethodCallException
     */
    public function __call(string $name, array $arguments): mixed
    {
        foreach (['add', 'remove', 'only', 'set', 'merge', 'get'] as $prefix) {
            if (str_starts_with($name, $prefix)) {
                $key = '-'.str_snake(substr($name, \strlen($prefix)), '-');
                $newName = $prefix.'Option';

                return $this->{$newName}($key, ...$arguments);
            }
        }

        throw new BadMethodCallException("The method [$name] does not exist.");
    }

    public function addOptions(array $options): self
    {
        $this->options += $options;

        return $this;
    }

    public function addOption(string $key, mixed $value): self
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

    public function onlyOptions(array $keys): self
    {
        $this->options = array_filter(
            $this->options,
            static fn (string $key): bool => \in_array($key, $keys, true),
            \ARRAY_FILTER_USE_KEY
        );

        return $this;
    }

    public function onlyOption(string $key): self
    {
        $this->onlyOptions([$key]);

        return $this;
    }

    public function onlyDsn(): self
    {
        $this->onlyOptions(['-test-dsn', '-online-dsn']);

        return $this;
    }

    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function setOption(string $key, mixed $value): self
    {
        $this->options[$key] = $value;

        return $this;
    }

    public function mergeOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function mergeOption(string $key, mixed $value): self
    {
        $this->mergeOptions([$key => $value]);

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getOption(string $key, mixed $default = null): mixed
    {
        return $this->options[$key] ?? $default;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    protected function getHydratedEscapedNormalizedOptions(): string
    {
        return implode(' ', $this->getEscapedNormalizedOptions());
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    protected function getEscapedNormalizedOptions(): array
    {
        return array_map('Guanguans\SoarPHP\Support\escape_argument', $this->getNormalizedOptions());
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    protected function getNormalizedOptions(): array
    {
        return $this->normalizeOptions($this->options);
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    protected function normalizeOptions(array $options): array
    {
        return array_reduce_with_keys($options, function (array $normalizedOptions, mixed $value, int|string $key): array {
            if ($normalizedOption = $this->normalizeOption($key, $value)) {
                $normalizedOptions[\is_int($key) ? (string) $value : $key] = $normalizedOption;
            }

            return $normalizedOptions;
        }, []);
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    protected function normalizeOption(int|string $key, mixed $value): string
    {
        $converter = function (mixed $value) {
            /** @noinspection UselessIsComparisonInspection */
            \is_callable($value) and !(\is_string($value) && \function_exists($value)) and $value = $value($this);
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
            if (!($value['disable'] ?? false) && \in_array($key, ['-test-dsn', '-online-dsn'], true)) {
                $dsn = "{$value['username']}:{$value['password']}@{$value['host']}:{$value['port']}/{$value['dbname']}";

                return "$key=$dsn";
            }

            return "$key=".implode(',', array_map($converter, $value));
        }

        throw new InvalidOptionException(\sprintf('Invalid configuration type(%s).', \gettype($value)));
    }
}
