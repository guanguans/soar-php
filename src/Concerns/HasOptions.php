<?php

/** @noinspection PhpFullyQualifiedNameUsageInspection */

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
 * @method \Guanguans\SoarPHP\Soar setAllowCharsets(string $allowCharsets) @description AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar setAllowCollates(string $allowCollates) @description AllowCollates
 * @method \Guanguans\SoarPHP\Soar setAllowDropIndex(bool $allowDropIndex) @description AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar setAllowEngines(string $allowEngines) @description AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar setAllowOnlineAsTest(bool $allowOnlineAsTest) @description AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar setBlacklist(string $blacklist) @description 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar setCheckConfig(bool $checkConfig) @description Check configs
 * @method \Guanguans\SoarPHP\Soar setCleanupTestDatabase(bool $cleanupTestDatabase) @description 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar setColumnNotAllowType(string $columnNotAllowType) @description ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar setConfig(string $config) @description Config file path
 * @method \Guanguans\SoarPHP\Soar setDelimiter(string $delimiter) @description Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar setDropTestTemporary(bool $dropTestTemporary) @description DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar setDryRun(bool $dryRun) @description 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar setExplain(bool $explain) @description Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar setExplainFormat(string $explainFormat) @description ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar setExplainMaxFiltered(float $explainMaxFiltered) @description ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar setExplainMaxKeys(int $explainMaxKeys) @description ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar setExplainMaxRows(int $explainMaxRows) @description ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar setExplainMinKeys(int $explainMinKeys) @description ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar setExplainSqlReportType(string $explainSqlReportType) @description ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar setExplainType(string $explainType) @description ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar setExplainWarnAccessType(string $explainWarnAccessType) @description ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar setExplainWarnExtra(string $explainWarnExtra) @description ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar setExplainWarnScalability(string $explainWarnScalability) @description ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar setExplainWarnSelectType(string $explainWarnSelectType) @description ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar setIgnoreRules(string $ignoreRules) @description IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar setIndexPrefix(string $indexPrefix) @description IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar setListHeuristicRules(bool $listHeuristicRules) @description ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar setListReportTypes(bool $listReportTypes) @description ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar setListRewriteRules(bool $listRewriteRules) @description ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar setListTestSqls(bool $listTestSqls) @description ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar setLogLevel(int $logLevel) @description LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar setLogOutput(string $logOutput) @description LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar setLogErrStacks(bool $logErrStacks) @description log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar setLogRotateMaxSize(int $logRotateMaxSize) @description size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar setMarkdownExtensions(int $markdownExtensions) @description MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar setMarkdownHtmlFlags(int $markdownHtmlFlags) @description MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar setMaxColumnCount(int $maxColumnCount) @description MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar setMaxDistinctCount(int $maxDistinctCount) @description MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxGroupByColsCount(int $maxGroupByColsCount) @description MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxInCount(int $maxInCount) @description MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexBytes(int $maxIndexBytes) @description MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn) @description MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexColsCount(int $maxIndexColsCount) @description MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexCount(int $maxIndexCount) @description MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar setMaxJoinTableCount(int $maxJoinTableCount) @description MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxPrettySqlLength(int $maxPrettySqlLength) @description MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar setMaxQueryCost(int $maxQueryCost) @description MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar setMaxSubqueryDepth(int $maxSubqueryDepth) @description MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxTextColsCount(int $maxTextColsCount) @description MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar setMaxTotalRows(int $maxTotalRows) @description MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar setMaxValueCount(int $maxValueCount) @description MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar setMaxVarcharLength(int $maxVarcharLength) @description MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar setMinCardinality(float $minCardinality) @description MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar setOnlineDsn(string $onlineDsn) @description OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar setOnlySyntaxCheck(bool $onlySyntaxCheck) @description OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar setPrintConfig(bool $printConfig) @description Print configs
 * @method \Guanguans\SoarPHP\Soar setProfiling(bool $profiling) @description Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar setQuery(string $query) @description 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar setReportCss(string $reportCss) @description ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar setReportJavascript(string $reportJavascript) @description ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar setReportTitle(string $reportTitle) @description ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar setReportType(string $reportType) @description ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar setRewriteRules(string $rewriteRules) @description RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar setSampling(bool $sampling) @description Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar setSamplingCondition(string $samplingCondition) @description SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar setSamplingStatisticTarget(int $samplingStatisticTarget) @description SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar setShowLastQueryCost(bool $showLastQueryCost) @description ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar setShowWarnings(bool $showWarnings) @description ShowWarnings
 * @method \Guanguans\SoarPHP\Soar setSpaghettiQueryLength(int $spaghettiQueryLength) @description SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar setTestDsn(string $testDsn) @description TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar setTrace(bool $trace) @description Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar setUniqueKeyPrefix(string $uniqueKeyPrefix) @description UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar setVerbose(bool $verbose) @description Verbose
 * @method \Guanguans\SoarPHP\Soar setVersion(bool $version) @description Print version info
 * @method \Guanguans\SoarPHP\Soar setHelp(bool $help) @description Help
 * @method \Guanguans\SoarPHP\Soar withAllowCharsets(string $allowCharsets) @description AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar withAllowCollates(string $allowCollates) @description AllowCollates
 * @method \Guanguans\SoarPHP\Soar withAllowDropIndex(bool $allowDropIndex) @description AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar withAllowEngines(string $allowEngines) @description AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar withAllowOnlineAsTest(bool $allowOnlineAsTest) @description AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar withBlacklist(string $blacklist) @description 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar withCheckConfig(bool $checkConfig) @description Check configs
 * @method \Guanguans\SoarPHP\Soar withCleanupTestDatabase(bool $cleanupTestDatabase) @description 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar withColumnNotAllowType(string $columnNotAllowType) @description ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar withConfig(string $config) @description Config file path
 * @method \Guanguans\SoarPHP\Soar withDelimiter(string $delimiter) @description Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar withDropTestTemporary(bool $dropTestTemporary) @description DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar withDryRun(bool $dryRun) @description 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar withExplain(bool $explain) @description Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar withExplainFormat(string $explainFormat) @description ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar withExplainMaxFiltered(float $explainMaxFiltered) @description ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar withExplainMaxKeys(int $explainMaxKeys) @description ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar withExplainMaxRows(int $explainMaxRows) @description ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar withExplainMinKeys(int $explainMinKeys) @description ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar withExplainSqlReportType(string $explainSqlReportType) @description ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar withExplainType(string $explainType) @description ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar withExplainWarnAccessType(string $explainWarnAccessType) @description ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar withExplainWarnExtra(string $explainWarnExtra) @description ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar withExplainWarnScalability(string $explainWarnScalability) @description ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar withExplainWarnSelectType(string $explainWarnSelectType) @description ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar withIgnoreRules(string $ignoreRules) @description IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar withIndexPrefix(string $indexPrefix) @description IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar withListHeuristicRules(bool $listHeuristicRules) @description ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar withListReportTypes(bool $listReportTypes) @description ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar withListRewriteRules(bool $listRewriteRules) @description ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar withListTestSqls(bool $listTestSqls) @description ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar withLogLevel(int $logLevel) @description LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar withLogOutput(string $logOutput) @description LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar withLogErrStacks(bool $logErrStacks) @description log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar withLogRotateMaxSize(int $logRotateMaxSize) @description size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar withMarkdownExtensions(int $markdownExtensions) @description MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar withMarkdownHtmlFlags(int $markdownHtmlFlags) @description MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar withMaxColumnCount(int $maxColumnCount) @description MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar withMaxDistinctCount(int $maxDistinctCount) @description MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar withMaxGroupByColsCount(int $maxGroupByColsCount) @description MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar withMaxInCount(int $maxInCount) @description MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar withMaxIndexBytes(int $maxIndexBytes) @description MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar withMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn) @description MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar withMaxIndexColsCount(int $maxIndexColsCount) @description MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar withMaxIndexCount(int $maxIndexCount) @description MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar withMaxJoinTableCount(int $maxJoinTableCount) @description MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar withMaxPrettySqlLength(int $maxPrettySqlLength) @description MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar withMaxQueryCost(int $maxQueryCost) @description MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar withMaxSubqueryDepth(int $maxSubqueryDepth) @description MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar withMaxTextColsCount(int $maxTextColsCount) @description MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar withMaxTotalRows(int $maxTotalRows) @description MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar withMaxValueCount(int $maxValueCount) @description MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar withMaxVarcharLength(int $maxVarcharLength) @description MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar withMinCardinality(float $minCardinality) @description MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar withOnlineDsn(string $onlineDsn) @description OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar withOnlySyntaxCheck(bool $onlySyntaxCheck) @description OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar withPrintConfig(bool $printConfig) @description Print configs
 * @method \Guanguans\SoarPHP\Soar withProfiling(bool $profiling) @description Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar withQuery(string $query) @description 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar withReportCss(string $reportCss) @description ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar withReportJavascript(string $reportJavascript) @description ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar withReportTitle(string $reportTitle) @description ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar withReportType(string $reportType) @description ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar withRewriteRules(string $rewriteRules) @description RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar withSampling(bool $sampling) @description Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar withSamplingCondition(string $samplingCondition) @description SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar withSamplingStatisticTarget(int $samplingStatisticTarget) @description SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar withShowLastQueryCost(bool $showLastQueryCost) @description ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar withShowWarnings(bool $showWarnings) @description ShowWarnings
 * @method \Guanguans\SoarPHP\Soar withSpaghettiQueryLength(int $spaghettiQueryLength) @description SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar withTestDsn(string $testDsn) @description TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar withTrace(bool $trace) @description Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar withUniqueKeyPrefix(string $uniqueKeyPrefix) @description UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar withVerbose(bool $verbose) @description Verbose
 * @method \Guanguans\SoarPHP\Soar withVersion(bool $version) @description Print version info
 * @method \Guanguans\SoarPHP\Soar withHelp(bool $help) @description Help
 * @method \Guanguans\SoarPHP\Soar onlyAllowCharsets() @description AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar onlyAllowCollates() @description AllowCollates
 * @method \Guanguans\SoarPHP\Soar onlyAllowDropIndex() @description AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar onlyAllowEngines() @description AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar onlyAllowOnlineAsTest() @description AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar onlyBlacklist() @description 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar onlyCheckConfig() @description Check configs
 * @method \Guanguans\SoarPHP\Soar onlyCleanupTestDatabase() @description 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar onlyColumnNotAllowType() @description ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar onlyConfig() @description Config file path
 * @method \Guanguans\SoarPHP\Soar onlyDelimiter() @description Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar onlyDropTestTemporary() @description DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar onlyDryRun() @description 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar onlyExplain() @description Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar onlyExplainFormat() @description ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar onlyExplainMaxFiltered() @description ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar onlyExplainMaxKeys() @description ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar onlyExplainMaxRows() @description ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar onlyExplainMinKeys() @description ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar onlyExplainSqlReportType() @description ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar onlyExplainType() @description ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnAccessType() @description ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnExtra() @description ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnScalability() @description ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnSelectType() @description ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar onlyIgnoreRules() @description IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar onlyIndexPrefix() @description IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar onlyListHeuristicRules() @description ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar onlyListReportTypes() @description ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar onlyListRewriteRules() @description ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar onlyListTestSqls() @description ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar onlyLogLevel() @description LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar onlyLogOutput() @description LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar onlyLogErrStacks() @description log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar onlyLogRotateMaxSize() @description size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar onlyMarkdownExtensions() @description MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar onlyMarkdownHtmlFlags() @description MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar onlyMaxColumnCount() @description MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar onlyMaxDistinctCount() @description MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxGroupByColsCount() @description MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxInCount() @description MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexBytes() @description MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexBytesPercolumn() @description MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexColsCount() @description MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexCount() @description MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar onlyMaxJoinTableCount() @description MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxPrettySqlLength() @description MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar onlyMaxQueryCost() @description MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar onlyMaxSubqueryDepth() @description MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxTextColsCount() @description MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar onlyMaxTotalRows() @description MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar onlyMaxValueCount() @description MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar onlyMaxVarcharLength() @description MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar onlyMinCardinality() @description MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar onlyOnlineDsn() @description OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar onlyOnlySyntaxCheck() @description OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar onlyPrintConfig() @description Print configs
 * @method \Guanguans\SoarPHP\Soar onlyProfiling() @description Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar onlyQuery() @description 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar onlyReportCss() @description ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar onlyReportJavascript() @description ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar onlyReportTitle() @description ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar onlyReportType() @description ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar onlyRewriteRules() @description RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar onlySampling() @description Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar onlySamplingCondition() @description SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar onlySamplingStatisticTarget() @description SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar onlyShowLastQueryCost() @description ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar onlyShowWarnings() @description ShowWarnings
 * @method \Guanguans\SoarPHP\Soar onlySpaghettiQueryLength() @description SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar onlyTestDsn() @description TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar onlyTrace() @description Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar onlyUniqueKeyPrefix() @description UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar onlyVerbose() @description Verbose
 * @method \Guanguans\SoarPHP\Soar onlyVersion() @description Print version info
 * @method \Guanguans\SoarPHP\Soar onlyHelp() @description Help
 * @method \Guanguans\SoarPHP\Soar exceptAllowCharsets() @description AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar exceptAllowCollates() @description AllowCollates
 * @method \Guanguans\SoarPHP\Soar exceptAllowDropIndex() @description AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar exceptAllowEngines() @description AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar exceptAllowOnlineAsTest() @description AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar exceptBlacklist() @description 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar exceptCheckConfig() @description Check configs
 * @method \Guanguans\SoarPHP\Soar exceptCleanupTestDatabase() @description 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar exceptColumnNotAllowType() @description ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar exceptConfig() @description Config file path
 * @method \Guanguans\SoarPHP\Soar exceptDelimiter() @description Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar exceptDropTestTemporary() @description DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar exceptDryRun() @description 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar exceptExplain() @description Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar exceptExplainFormat() @description ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar exceptExplainMaxFiltered() @description ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar exceptExplainMaxKeys() @description ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar exceptExplainMaxRows() @description ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar exceptExplainMinKeys() @description ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar exceptExplainSqlReportType() @description ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar exceptExplainType() @description ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar exceptExplainWarnAccessType() @description ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar exceptExplainWarnExtra() @description ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar exceptExplainWarnScalability() @description ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar exceptExplainWarnSelectType() @description ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar exceptIgnoreRules() @description IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar exceptIndexPrefix() @description IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar exceptListHeuristicRules() @description ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar exceptListReportTypes() @description ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar exceptListRewriteRules() @description ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar exceptListTestSqls() @description ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar exceptLogLevel() @description LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar exceptLogOutput() @description LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar exceptLogErrStacks() @description log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar exceptLogRotateMaxSize() @description size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar exceptMarkdownExtensions() @description MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar exceptMarkdownHtmlFlags() @description MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar exceptMaxColumnCount() @description MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar exceptMaxDistinctCount() @description MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar exceptMaxGroupByColsCount() @description MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar exceptMaxInCount() @description MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar exceptMaxIndexBytes() @description MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar exceptMaxIndexBytesPercolumn() @description MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar exceptMaxIndexColsCount() @description MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar exceptMaxIndexCount() @description MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar exceptMaxJoinTableCount() @description MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar exceptMaxPrettySqlLength() @description MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar exceptMaxQueryCost() @description MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar exceptMaxSubqueryDepth() @description MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar exceptMaxTextColsCount() @description MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar exceptMaxTotalRows() @description MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar exceptMaxValueCount() @description MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar exceptMaxVarcharLength() @description MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar exceptMinCardinality() @description MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar exceptOnlineDsn() @description OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar exceptOnlySyntaxCheck() @description OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar exceptPrintConfig() @description Print configs
 * @method \Guanguans\SoarPHP\Soar exceptProfiling() @description Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar exceptQuery() @description 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar exceptReportCss() @description ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar exceptReportJavascript() @description ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar exceptReportTitle() @description ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar exceptReportType() @description ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar exceptRewriteRules() @description RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar exceptSampling() @description Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar exceptSamplingCondition() @description SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar exceptSamplingStatisticTarget() @description SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar exceptShowLastQueryCost() @description ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar exceptShowWarnings() @description ShowWarnings
 * @method \Guanguans\SoarPHP\Soar exceptSpaghettiQueryLength() @description SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar exceptTestDsn() @description TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar exceptTrace() @description Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar exceptUniqueKeyPrefix() @description UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar exceptVerbose() @description Verbose
 * @method \Guanguans\SoarPHP\Soar exceptVersion() @description Print version info
 * @method \Guanguans\SoarPHP\Soar exceptHelp() @description Help
 *
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait HasOptions
{
    /** @var array<string, mixed> */
    protected array $options = [];

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\BadMethodCallException
     */
    public function __call(string $method, array $arguments): mixed
    {
        foreach (['set', 'with', 'only', 'except'] as $prefix) {
            if (str_starts_with($method, $prefix)) {
                $name = '-'.str_snake(substr($method, \strlen($prefix)), '-');
                $actionMethod = $prefix.'Option';

                return $this->{$actionMethod}($name, ...$arguments);
            }
        }

        throw new BadMethodCallException(\sprintf('The method [%s::%s] does not exist.', static::class, $method));
    }

    public function flushOptions(): self
    {
        return $this->setOptions([]);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function setOption(string $name, mixed $value): self
    {
        $this->options[$name] = $value;

        return $this;
    }

    /**
     * @param array<string, mixed> $options
     */
    public function withOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function withOption(string $name, mixed $value): self
    {
        $this->withOptions([$name => $value]);

        return $this;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function getDelimiter(string $default = ';'): string
    {
        return $this->options['-delimiter'] ?? $default;
    }

    public function getOption(string $name, mixed $default = null): mixed
    {
        return $this->options[$name] ?? $default;
    }

    public function onlyDsns(): self
    {
        $this->onlyOptions(['-test-dsn', '-online-dsn']);

        return $this;
    }

    public function onlyOptions(array $names): self
    {
        $this->options = array_filter(
            $this->options,
            static fn (string $name): bool => \in_array($name, $names, true),
            \ARRAY_FILTER_USE_KEY
        );

        return $this;
    }

    public function onlyOption(string $name): self
    {
        $this->onlyOptions([$name]);

        return $this;
    }

    public function exceptOptions(array $names): self
    {
        foreach ($names as $name) {
            unset($this->options[$name]);
        }

        return $this;
    }

    public function exceptOption(string $name): self
    {
        $this->exceptOptions([$name]);

        return $this;
    }

    /**
     * @param string $offset
     */
    public function offsetExists(mixed $offset): bool
    {
        return isset($this->options[$offset]);
    }

    /**
     * @param string $offset
     */
    public function offsetGet(mixed $offset): mixed
    {
        return $this->options[$offset];
    }

    /**
     * @param string $offset
     */
    public function offsetSet(mixed $offset, mixed $value): void
    {
        $this->options[$offset] = $value;
    }

    /**
     * @param string $offset
     */
    public function offsetUnset(mixed $offset): void
    {
        unset($this->options[$offset]);
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
    private function normalizeOptions(array $options): array
    {
        return array_reduce_with_keys(
            $options,
            function (array $normalizedOptions, mixed $value, string $name): array {
                $normalizedOptions[$name] = $this->normalizeOption($name, $value);

                return $normalizedOptions;
            },
            []
        );
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    private function normalizeOption(string $name, mixed $value): string
    {
        if (
            \is_array($value)
            && !($value['disable'] ?? false)
            && \in_array($name, ['-test-dsn', '-online-dsn'], true)
        ) {
            $value = "{$value['username']}:{$value['password']}@{$value['host']}:{$value['port']}/{$value['dbname']}";
        }

        return null === ($value = $this->normalizeValue($value)) ? $name : "$name=$value";
    }

    /**
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpDocMissingThrowsInspection
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    private function normalizeValue(mixed $value): ?string
    {
        if (\is_string($value) || null === $value) {
            return $value;
        }

        if (\is_scalar($value)) {
            return json_encode($value, \JSON_THROW_ON_ERROR);
        }

        if (\is_callable($value)) {
            return $this->normalizeValue($value($this));
        }

        if (\is_object($value) && method_exists($value, '__toString')) {
            return (string) $value;
        }

        if (!\is_array($value)) {
            throw new InvalidOptionException(\sprintf('Invalid option type [%s].', \gettype($value)));
        }

        return implode(
            ',',
            array_filter(
                array_map(fn (mixed $val): ?string => $this->normalizeValue($val), $value),
                static fn (?string $v): bool => null !== $v
            )
        );
    }
}
