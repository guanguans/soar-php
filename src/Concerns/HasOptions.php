<?php

/** @noinspection LongLine */
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
use function Guanguans\SoarPHP\Support\str_snake;

/**
 * @method \Guanguans\SoarPHP\Soar setConfig(null|string $config) // Config file path
 * @method \Guanguans\SoarPHP\Soar setTestDsn(array|string $testDsn) // TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar setOnlineDsn(array|string $onlineDsn) // OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar setAllowOnlineAsTest(bool $allowOnlineAsTest) // AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar setBlacklist(string $blacklist) // 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar setExplain(bool $explain) // Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar setIgnoreRules(array|string $ignoreRules) // IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar setLogLevel(int $logLevel) // LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar setLogOutput(string $logOutput) // LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar setReportType(string $reportType) // ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar setAllowCharsets(array|string $allowCharsets) // AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar setAllowCollates(array|string $allowCollates) // AllowCollates
 * @method \Guanguans\SoarPHP\Soar setAllowDropIndex(bool $allowDropIndex) // AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar setAllowEngines(array|string $allowEngines) // AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar setCheckConfig(null|bool $checkConfig) // Check configs
 * @method \Guanguans\SoarPHP\Soar setCleanupTestDatabase(bool $cleanupTestDatabase) // 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar setColumnNotAllowType(array|string $columnNotAllowType) // ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar setDelimiter(string $delimiter) // Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar setDropTestTemporary(bool $dropTestTemporary) // DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar setDryRun(bool $dryRun) // 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar setExplainFormat(string $explainFormat) // ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar setExplainMaxFiltered(float|int $explainMaxFiltered) // ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar setExplainMaxKeys(int $explainMaxKeys) // ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar setExplainMaxRows(int $explainMaxRows) // ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar setExplainMinKeys(int $explainMinKeys) // ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar setExplainSqlReportType(string $explainSqlReportType) // ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar setExplainType(string $explainType) // ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar setExplainWarnAccessType(array|string $explainWarnAccessType) // ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar setExplainWarnExtra(array|string $explainWarnExtra) // ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar setExplainWarnScalability(array|string $explainWarnScalability) // ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar setExplainWarnSelectType(array|string $explainWarnSelectType) // ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar setHelp(null|bool $help) // Help
 * @method \Guanguans\SoarPHP\Soar setIndexPrefix(string $indexPrefix) // IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar setListHeuristicRules(bool $listHeuristicRules) // ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar setListReportTypes(bool $listReportTypes) // ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar setListRewriteRules(bool $listRewriteRules) // ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar setListTestSqls(bool $listTestSqls) // ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar setLogErrStacks(null|bool $logErrStacks) // log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar setLogRotateMaxSize(int|string $logRotateMaxSize) // size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar setMarkdownExtensions(int $markdownExtensions) // MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar setMarkdownHtmlFlags(int $markdownHtmlFlags) // MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar setMaxColumnCount(int $maxColumnCount) // MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar setMaxDistinctCount(int $maxDistinctCount) // MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxGroupByColsCount(int $maxGroupByColsCount) // MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxInCount(int $maxInCount) // MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexBytes(int $maxIndexBytes) // MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn) // MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexColsCount(int $maxIndexColsCount) // MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexCount(int $maxIndexCount) // MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar setMaxJoinTableCount(int $maxJoinTableCount) // MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxPrettySqlLength(int $maxPrettySqlLength) // MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar setMaxQueryCost(int $maxQueryCost) // MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar setMaxSubqueryDepth(int $maxSubqueryDepth) // MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar setMaxTextColsCount(int $maxTextColsCount) // MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar setMaxTotalRows(int $maxTotalRows) // MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar setMaxValueCount(int $maxValueCount) // MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar setMaxVarcharLength(int $maxVarcharLength) // MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar setMinCardinality(float|int $minCardinality) // MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar setOnlySyntaxCheck(bool $onlySyntaxCheck) // OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar setPrintConfig(null|bool $printConfig) // Print configs
 * @method \Guanguans\SoarPHP\Soar setProfiling(bool $profiling) // Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar setQuery(string $query) // 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar setReportCss(string $reportCss) // ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar setReportJavascript(string $reportJavascript) // ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar setReportTitle(string $reportTitle) // ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar setRewriteRules(array|string $rewriteRules) // RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar setSampling(bool $sampling) // Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar setSamplingCondition(string $samplingCondition) // SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar setSamplingStatisticTarget(int $samplingStatisticTarget) // SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar setShowLastQueryCost(bool $showLastQueryCost) // ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar setShowWarnings(bool $showWarnings) // ShowWarnings
 * @method \Guanguans\SoarPHP\Soar setSpaghettiQueryLength(int $spaghettiQueryLength) // SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar setTrace(bool $trace) // Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar setUniqueKeyPrefix(string $uniqueKeyPrefix) // UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar setVerbose(bool $verbose) // Verbose
 * @method \Guanguans\SoarPHP\Soar setVersion(null|bool $version) // Print version info
 * @method \Guanguans\SoarPHP\Soar withConfig(null|string $config) // Config file path
 * @method \Guanguans\SoarPHP\Soar withTestDsn(array|string $testDsn) // TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar withOnlineDsn(array|string $onlineDsn) // OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar withAllowOnlineAsTest(bool $allowOnlineAsTest) // AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar withBlacklist(string $blacklist) // 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar withExplain(bool $explain) // Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar withIgnoreRules(array|string $ignoreRules) // IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar withLogLevel(int $logLevel) // LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar withLogOutput(string $logOutput) // LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar withReportType(string $reportType) // ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar withAllowCharsets(array|string $allowCharsets) // AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar withAllowCollates(array|string $allowCollates) // AllowCollates
 * @method \Guanguans\SoarPHP\Soar withAllowDropIndex(bool $allowDropIndex) // AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar withAllowEngines(array|string $allowEngines) // AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar withCheckConfig(null|bool $checkConfig) // Check configs
 * @method \Guanguans\SoarPHP\Soar withCleanupTestDatabase(bool $cleanupTestDatabase) // 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar withColumnNotAllowType(array|string $columnNotAllowType) // ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar withDelimiter(string $delimiter) // Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar withDropTestTemporary(bool $dropTestTemporary) // DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar withDryRun(bool $dryRun) // 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar withExplainFormat(string $explainFormat) // ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar withExplainMaxFiltered(float|int $explainMaxFiltered) // ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar withExplainMaxKeys(int $explainMaxKeys) // ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar withExplainMaxRows(int $explainMaxRows) // ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar withExplainMinKeys(int $explainMinKeys) // ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar withExplainSqlReportType(string $explainSqlReportType) // ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar withExplainType(string $explainType) // ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar withExplainWarnAccessType(array|string $explainWarnAccessType) // ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar withExplainWarnExtra(array|string $explainWarnExtra) // ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar withExplainWarnScalability(array|string $explainWarnScalability) // ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar withExplainWarnSelectType(array|string $explainWarnSelectType) // ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar withHelp(null|bool $help) // Help
 * @method \Guanguans\SoarPHP\Soar withIndexPrefix(string $indexPrefix) // IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar withListHeuristicRules(bool $listHeuristicRules) // ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar withListReportTypes(bool $listReportTypes) // ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar withListRewriteRules(bool $listRewriteRules) // ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar withListTestSqls(bool $listTestSqls) // ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar withLogErrStacks(null|bool $logErrStacks) // log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar withLogRotateMaxSize(int|string $logRotateMaxSize) // size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar withMarkdownExtensions(int $markdownExtensions) // MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar withMarkdownHtmlFlags(int $markdownHtmlFlags) // MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar withMaxColumnCount(int $maxColumnCount) // MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar withMaxDistinctCount(int $maxDistinctCount) // MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar withMaxGroupByColsCount(int $maxGroupByColsCount) // MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar withMaxInCount(int $maxInCount) // MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar withMaxIndexBytes(int $maxIndexBytes) // MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar withMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn) // MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar withMaxIndexColsCount(int $maxIndexColsCount) // MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar withMaxIndexCount(int $maxIndexCount) // MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar withMaxJoinTableCount(int $maxJoinTableCount) // MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar withMaxPrettySqlLength(int $maxPrettySqlLength) // MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar withMaxQueryCost(int $maxQueryCost) // MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar withMaxSubqueryDepth(int $maxSubqueryDepth) // MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar withMaxTextColsCount(int $maxTextColsCount) // MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar withMaxTotalRows(int $maxTotalRows) // MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar withMaxValueCount(int $maxValueCount) // MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar withMaxVarcharLength(int $maxVarcharLength) // MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar withMinCardinality(float|int $minCardinality) // MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar withOnlySyntaxCheck(bool $onlySyntaxCheck) // OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar withPrintConfig(null|bool $printConfig) // Print configs
 * @method \Guanguans\SoarPHP\Soar withProfiling(bool $profiling) // Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar withQuery(string $query) // 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar withReportCss(string $reportCss) // ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar withReportJavascript(string $reportJavascript) // ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar withReportTitle(string $reportTitle) // ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar withRewriteRules(array|string $rewriteRules) // RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar withSampling(bool $sampling) // Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar withSamplingCondition(string $samplingCondition) // SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar withSamplingStatisticTarget(int $samplingStatisticTarget) // SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar withShowLastQueryCost(bool $showLastQueryCost) // ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar withShowWarnings(bool $showWarnings) // ShowWarnings
 * @method \Guanguans\SoarPHP\Soar withSpaghettiQueryLength(int $spaghettiQueryLength) // SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar withTrace(bool $trace) // Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar withUniqueKeyPrefix(string $uniqueKeyPrefix) // UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar withVerbose(bool $verbose) // Verbose
 * @method \Guanguans\SoarPHP\Soar withVersion(null|bool $version) // Print version info
 * @method null|string getConfig(mixed $default = null) // Config file path
 * @method null|array|string getTestDsn(mixed $default = null) // TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method null|array|string getOnlineDsn(mixed $default = null) // OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method null|bool getAllowOnlineAsTest(mixed $default = null) // AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method null|string getBlacklist(mixed $default = null) // 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method null|bool getExplain(mixed $default = null) // Explain, 是否开启Explain执行计划分析 (default true)
 * @method null|array|string getIgnoreRules(mixed $default = null) // IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method null|int getLogLevel(mixed $default = null) // LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method null|string getLogOutput(mixed $default = null) // LogOutput, 日志输出位置 (default "soar.log")
 * @method null|string getReportType(mixed $default = null) // ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method null|array|string getAllowCharsets(mixed $default = null) // AllowCharsets (default "utf8,utf8mb4")
 * @method null|array|string getAllowCollates(mixed $default = null) // AllowCollates
 * @method null|bool getAllowDropIndex(mixed $default = null) // AllowDropIndex, 允许输出删除重复索引的建议
 * @method null|array|string getAllowEngines(mixed $default = null) // AllowEngines (default "innodb")
 * @method null|bool getCheckConfig(mixed $default = null) // Check configs
 * @method null|bool getCleanupTestDatabase(mixed $default = null) // 单次运行清理历史1小时前残余的测试库。
 * @method null|array|string getColumnNotAllowType(mixed $default = null) // ColumnNotAllowType (default "boolean")
 * @method null|string getDelimiter(mixed $default = null) // Delimiter, SQL分隔符 (default ";")
 * @method null|bool getDropTestTemporary(mixed $default = null) // DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method null|bool getDryRun(mixed $default = null) // 是否在预演环境执行 (default true)
 * @method null|string getExplainFormat(mixed $default = null) // ExplainFormat [json, traditional] (default "traditional")
 * @method null|float|int getExplainMaxFiltered(mixed $default = null) // ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method null|int getExplainMaxKeys(mixed $default = null) // ExplainMaxKeyLength, 最大key_len (default 3)
 * @method null|int getExplainMaxRows(mixed $default = null) // ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method null|int getExplainMinKeys(mixed $default = null) // ExplainMinPossibleKeys, 最小possible_keys警告
 * @method null|string getExplainSqlReportType(mixed $default = null) // ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method null|string getExplainType(mixed $default = null) // ExplainType [extended, partitions, traditional] (default "extended")
 * @method null|array|string getExplainWarnAccessType(mixed $default = null) // ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method null|array|string getExplainWarnExtra(mixed $default = null) // ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method null|array|string getExplainWarnScalability(mixed $default = null) // ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method null|array|string getExplainWarnSelectType(mixed $default = null) // ExplainWarnSelectType, 哪些select_type不建议使用
 * @method null|bool getHelp(mixed $default = null) // Help
 * @method null|string getIndexPrefix(mixed $default = null) // IdxPrefix (default "idx_")
 * @method null|bool getListHeuristicRules(mixed $default = null) // ListHeuristicRules, 打印支持的评审规则列表
 * @method null|bool getListReportTypes(mixed $default = null) // ListReportTypes, 打印支持的报告输出类型
 * @method null|bool getListRewriteRules(mixed $default = null) // ListRewriteRules, 打印支持的重写规则列表
 * @method null|bool getListTestSqls(mixed $default = null) // ListTestSqls, 打印测试case用于测试
 * @method null|bool getLogErrStacks(mixed $default = null) // log stack traces for errors
 * @method null|int|string getLogRotateMaxSize(mixed $default = null) // size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method null|int getMarkdownExtensions(mixed $default = null) // MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method null|int getMarkdownHtmlFlags(mixed $default = null) // MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method null|int getMaxColumnCount(mixed $default = null) // MaxColCount, 单表允许的最大列数 (default 40)
 * @method null|int getMaxDistinctCount(mixed $default = null) // MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method null|int getMaxGroupByColsCount(mixed $default = null) // MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method null|int getMaxInCount(mixed $default = null) // MaxInCount, IN()最大数量 (default 10)
 * @method null|int getMaxIndexBytes(mixed $default = null) // MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method null|int getMaxIndexBytesPercolumn(mixed $default = null) // MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method null|int getMaxIndexColsCount(mixed $default = null) // MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method null|int getMaxIndexCount(mixed $default = null) // MaxIdxCount, 单表最大索引个数 (default 10)
 * @method null|int getMaxJoinTableCount(mixed $default = null) // MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method null|int getMaxPrettySqlLength(mixed $default = null) // MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method null|int getMaxQueryCost(mixed $default = null) // MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method null|int getMaxSubqueryDepth(mixed $default = null) // MaxSubqueryDepth (default 5)
 * @method null|int getMaxTextColsCount(mixed $default = null) // MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method null|int getMaxTotalRows(mixed $default = null) // MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method null|int getMaxValueCount(mixed $default = null) // MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method null|int getMaxVarcharLength(mixed $default = null) // MaxVarcharLength (default 1024)
 * @method null|float|int getMinCardinality(mixed $default = null) // MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method null|bool getOnlySyntaxCheck(mixed $default = null) // OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method null|bool getPrintConfig(mixed $default = null) // Print configs
 * @method null|bool getProfiling(mixed $default = null) // Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method null|string getQuery(mixed $default = null) // 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method null|string getReportCss(mixed $default = null) // ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method null|string getReportJavascript(mixed $default = null) // ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method null|string getReportTitle(mixed $default = null) // ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method null|array|string getRewriteRules(mixed $default = null) // RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method null|bool getSampling(mixed $default = null) // Sampling, 数据采样开关
 * @method null|string getSamplingCondition(mixed $default = null) // SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method null|int getSamplingStatisticTarget(mixed $default = null) // SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method null|bool getShowLastQueryCost(mixed $default = null) // ShowLastQueryCost
 * @method null|bool getShowWarnings(mixed $default = null) // ShowWarnings
 * @method null|int getSpaghettiQueryLength(mixed $default = null) // SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method null|bool getTrace(mixed $default = null) // Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method null|string getUniqueKeyPrefix(mixed $default = null) // UkPrefix (default "uk_")
 * @method null|bool getVerbose(mixed $default = null) // Verbose
 * @method null|bool getVersion(mixed $default = null) // Print version info
 * @method \Guanguans\SoarPHP\Soar onlyConfig() // Config file path
 * @method \Guanguans\SoarPHP\Soar onlyTestDsn() // TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar onlyOnlineDsn() // OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar onlyAllowOnlineAsTest() // AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar onlyBlacklist() // 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar onlyExplain() // Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar onlyIgnoreRules() // IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar onlyLogLevel() // LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar onlyLogOutput() // LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar onlyReportType() // ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar onlyAllowCharsets() // AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar onlyAllowCollates() // AllowCollates
 * @method \Guanguans\SoarPHP\Soar onlyAllowDropIndex() // AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar onlyAllowEngines() // AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar onlyCheckConfig() // Check configs
 * @method \Guanguans\SoarPHP\Soar onlyCleanupTestDatabase() // 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar onlyColumnNotAllowType() // ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar onlyDelimiter() // Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar onlyDropTestTemporary() // DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar onlyDryRun() // 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar onlyExplainFormat() // ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar onlyExplainMaxFiltered() // ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar onlyExplainMaxKeys() // ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar onlyExplainMaxRows() // ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar onlyExplainMinKeys() // ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar onlyExplainSqlReportType() // ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar onlyExplainType() // ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnAccessType() // ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnExtra() // ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnScalability() // ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar onlyExplainWarnSelectType() // ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar onlyHelp() // Help
 * @method \Guanguans\SoarPHP\Soar onlyIndexPrefix() // IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar onlyListHeuristicRules() // ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar onlyListReportTypes() // ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar onlyListRewriteRules() // ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar onlyListTestSqls() // ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar onlyLogErrStacks() // log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar onlyLogRotateMaxSize() // size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar onlyMarkdownExtensions() // MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar onlyMarkdownHtmlFlags() // MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar onlyMaxColumnCount() // MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar onlyMaxDistinctCount() // MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxGroupByColsCount() // MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxInCount() // MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexBytes() // MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexBytesPercolumn() // MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexColsCount() // MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxIndexCount() // MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar onlyMaxJoinTableCount() // MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxPrettySqlLength() // MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar onlyMaxQueryCost() // MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar onlyMaxSubqueryDepth() // MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar onlyMaxTextColsCount() // MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar onlyMaxTotalRows() // MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar onlyMaxValueCount() // MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar onlyMaxVarcharLength() // MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar onlyMinCardinality() // MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar onlyOnlySyntaxCheck() // OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar onlyPrintConfig() // Print configs
 * @method \Guanguans\SoarPHP\Soar onlyProfiling() // Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar onlyQuery() // 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar onlyReportCss() // ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar onlyReportJavascript() // ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar onlyReportTitle() // ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar onlyRewriteRules() // RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar onlySampling() // Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar onlySamplingCondition() // SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar onlySamplingStatisticTarget() // SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar onlyShowLastQueryCost() // ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar onlyShowWarnings() // ShowWarnings
 * @method \Guanguans\SoarPHP\Soar onlySpaghettiQueryLength() // SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar onlyTrace() // Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar onlyUniqueKeyPrefix() // UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar onlyVerbose() // Verbose
 * @method \Guanguans\SoarPHP\Soar onlyVersion() // Print version info
 * @method \Guanguans\SoarPHP\Soar exceptConfig() // Config file path
 * @method \Guanguans\SoarPHP\Soar exceptTestDsn() // TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar exceptOnlineDsn() // OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method \Guanguans\SoarPHP\Soar exceptAllowOnlineAsTest() // AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method \Guanguans\SoarPHP\Soar exceptBlacklist() // 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method \Guanguans\SoarPHP\Soar exceptExplain() // Explain, 是否开启Explain执行计划分析 (default true)
 * @method \Guanguans\SoarPHP\Soar exceptIgnoreRules() // IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method \Guanguans\SoarPHP\Soar exceptLogLevel() // LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method \Guanguans\SoarPHP\Soar exceptLogOutput() // LogOutput, 日志输出位置 (default "soar.log")
 * @method \Guanguans\SoarPHP\Soar exceptReportType() // ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method \Guanguans\SoarPHP\Soar exceptAllowCharsets() // AllowCharsets (default "utf8,utf8mb4")
 * @method \Guanguans\SoarPHP\Soar exceptAllowCollates() // AllowCollates
 * @method \Guanguans\SoarPHP\Soar exceptAllowDropIndex() // AllowDropIndex, 允许输出删除重复索引的建议
 * @method \Guanguans\SoarPHP\Soar exceptAllowEngines() // AllowEngines (default "innodb")
 * @method \Guanguans\SoarPHP\Soar exceptCheckConfig() // Check configs
 * @method \Guanguans\SoarPHP\Soar exceptCleanupTestDatabase() // 单次运行清理历史1小时前残余的测试库。
 * @method \Guanguans\SoarPHP\Soar exceptColumnNotAllowType() // ColumnNotAllowType (default "boolean")
 * @method \Guanguans\SoarPHP\Soar exceptDelimiter() // Delimiter, SQL分隔符 (default ";")
 * @method \Guanguans\SoarPHP\Soar exceptDropTestTemporary() // DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method \Guanguans\SoarPHP\Soar exceptDryRun() // 是否在预演环境执行 (default true)
 * @method \Guanguans\SoarPHP\Soar exceptExplainFormat() // ExplainFormat [json, traditional] (default "traditional")
 * @method \Guanguans\SoarPHP\Soar exceptExplainMaxFiltered() // ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method \Guanguans\SoarPHP\Soar exceptExplainMaxKeys() // ExplainMaxKeyLength, 最大key_len (default 3)
 * @method \Guanguans\SoarPHP\Soar exceptExplainMaxRows() // ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method \Guanguans\SoarPHP\Soar exceptExplainMinKeys() // ExplainMinPossibleKeys, 最小possible_keys警告
 * @method \Guanguans\SoarPHP\Soar exceptExplainSqlReportType() // ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method \Guanguans\SoarPHP\Soar exceptExplainType() // ExplainType [extended, partitions, traditional] (default "extended")
 * @method \Guanguans\SoarPHP\Soar exceptExplainWarnAccessType() // ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method \Guanguans\SoarPHP\Soar exceptExplainWarnExtra() // ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method \Guanguans\SoarPHP\Soar exceptExplainWarnScalability() // ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method \Guanguans\SoarPHP\Soar exceptExplainWarnSelectType() // ExplainWarnSelectType, 哪些select_type不建议使用
 * @method \Guanguans\SoarPHP\Soar exceptHelp() // Help
 * @method \Guanguans\SoarPHP\Soar exceptIndexPrefix() // IdxPrefix (default "idx_")
 * @method \Guanguans\SoarPHP\Soar exceptListHeuristicRules() // ListHeuristicRules, 打印支持的评审规则列表
 * @method \Guanguans\SoarPHP\Soar exceptListReportTypes() // ListReportTypes, 打印支持的报告输出类型
 * @method \Guanguans\SoarPHP\Soar exceptListRewriteRules() // ListRewriteRules, 打印支持的重写规则列表
 * @method \Guanguans\SoarPHP\Soar exceptListTestSqls() // ListTestSqls, 打印测试case用于测试
 * @method \Guanguans\SoarPHP\Soar exceptLogErrStacks() // log stack traces for errors
 * @method \Guanguans\SoarPHP\Soar exceptLogRotateMaxSize() // size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method \Guanguans\SoarPHP\Soar exceptMarkdownExtensions() // MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method \Guanguans\SoarPHP\Soar exceptMarkdownHtmlFlags() // MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method \Guanguans\SoarPHP\Soar exceptMaxColumnCount() // MaxColCount, 单表允许的最大列数 (default 40)
 * @method \Guanguans\SoarPHP\Soar exceptMaxDistinctCount() // MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar exceptMaxGroupByColsCount() // MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar exceptMaxInCount() // MaxInCount, IN()最大数量 (default 10)
 * @method \Guanguans\SoarPHP\Soar exceptMaxIndexBytes() // MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method \Guanguans\SoarPHP\Soar exceptMaxIndexBytesPercolumn() // MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method \Guanguans\SoarPHP\Soar exceptMaxIndexColsCount() // MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar exceptMaxIndexCount() // MaxIdxCount, 单表最大索引个数 (default 10)
 * @method \Guanguans\SoarPHP\Soar exceptMaxJoinTableCount() // MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method \Guanguans\SoarPHP\Soar exceptMaxPrettySqlLength() // MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method \Guanguans\SoarPHP\Soar exceptMaxQueryCost() // MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method \Guanguans\SoarPHP\Soar exceptMaxSubqueryDepth() // MaxSubqueryDepth (default 5)
 * @method \Guanguans\SoarPHP\Soar exceptMaxTextColsCount() // MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method \Guanguans\SoarPHP\Soar exceptMaxTotalRows() // MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method \Guanguans\SoarPHP\Soar exceptMaxValueCount() // MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method \Guanguans\SoarPHP\Soar exceptMaxVarcharLength() // MaxVarcharLength (default 1024)
 * @method \Guanguans\SoarPHP\Soar exceptMinCardinality() // MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method \Guanguans\SoarPHP\Soar exceptOnlySyntaxCheck() // OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method \Guanguans\SoarPHP\Soar exceptPrintConfig() // Print configs
 * @method \Guanguans\SoarPHP\Soar exceptProfiling() // Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method \Guanguans\SoarPHP\Soar exceptQuery() // 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method \Guanguans\SoarPHP\Soar exceptReportCss() // ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar exceptReportJavascript() // ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method \Guanguans\SoarPHP\Soar exceptReportTitle() // ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method \Guanguans\SoarPHP\Soar exceptRewriteRules() // RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method \Guanguans\SoarPHP\Soar exceptSampling() // Sampling, 数据采样开关
 * @method \Guanguans\SoarPHP\Soar exceptSamplingCondition() // SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method \Guanguans\SoarPHP\Soar exceptSamplingStatisticTarget() // SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method \Guanguans\SoarPHP\Soar exceptShowLastQueryCost() // ShowLastQueryCost
 * @method \Guanguans\SoarPHP\Soar exceptShowWarnings() // ShowWarnings
 * @method \Guanguans\SoarPHP\Soar exceptSpaghettiQueryLength() // SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method \Guanguans\SoarPHP\Soar exceptTrace() // Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method \Guanguans\SoarPHP\Soar exceptUniqueKeyPrefix() // UkPrefix (default "uk_")
 * @method \Guanguans\SoarPHP\Soar exceptVerbose() // Verbose
 * @method \Guanguans\SoarPHP\Soar exceptVersion() // Print version info
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
        foreach (['set', 'with', 'get', 'only', 'except'] as $prefix) {
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

    public function setOption(string $name, mixed $value): self
    {
        return $this->setOptions([$name => $value]);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function setOptions(array $options): self
    {
        $this->options = $options;

        return $this;
    }

    public function withOption(string $name, mixed $value): self
    {
        return $this->withOptions([$name => $value]);
    }

    /**
     * @param array<string, mixed> $options
     */
    public function withOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);

        return $this;
    }

    public function getOption(string $name, mixed $default = null): mixed
    {
        return $this->getOptions()[$name] ?? $default;
    }

    public function getOptions(): array
    {
        return $this->options;
    }

    public function onlyDsn(): self
    {
        $this->onlyOptions(['-test-dsn', '-online-dsn']);

        return $this;
    }

    public function onlyOption(string $name): self
    {
        $this->onlyOptions([$name]);

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

    public function exceptOption(string $name): self
    {
        $this->exceptOptions([$name]);

        return $this;
    }

    /**
     * @param list<string> $names
     */
    public function exceptOptions(array $names): self
    {
        foreach ($names as $name) {
            unset($this->options[$name]);
        }

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
     * @param array<string, mixed> $options
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    private function normalizeOptions(array $options): array
    {
        $normalizedOptions = [];

        foreach ($options as $name => $value) {
            $normalizedOptions[$name] = $this->normalizeOption($name, $value);
        }

        return $normalizedOptions;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    private function normalizeOption(string $name, mixed $value): string
    {
        $normalizedValue = $this->normalizeValue($name, $value);

        return null === $normalizedValue ? $name : "$name=$normalizedValue";
    }

    /**
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection PhpDocMissingThrowsInspection
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    private function normalizeValue(string $name, mixed $value): ?string
    {
        if (\is_string($value) || null === $value) {
            return $value;
        }

        if (\is_scalar($value)) {
            return json_encode($value, \JSON_THROW_ON_ERROR);
        }

        if (\is_callable($value)) {
            return $this->normalizeValue($name, $value($this));
        }

        if (\is_object($value) && method_exists($value, '__toString')) {
            return (string) $value;
        }

        if (!\is_array($value)) {
            throw new InvalidOptionException(\sprintf('Invalid option [%s] type [%s].', $name, \gettype($value)));
        }

        if (\in_array($name, ['-test-dsn', '-online-dsn'], true)) {
            return $this->normalizeDsn($name, $value);
        }

        return implode(',', array_map(fn (mixed $val): ?string => $this->normalizeValue($name, $val), $value));
    }

    /**
     * @see https://github.com/XiaoMi/soar/blob/master/doc/config.md
     * @see https://github.com/XiaoMi/soar/blob/dev/common/config.go#L296-L333
     * @see https://github.com/XiaoMi/soar/blob/dev/common/config.go#L446-L453
     * @see https://github.com/go-sql-driver/mysql/blob/master/dsn.go#L397-L475
     * @see https://github.com/spatie/url
     * @see https://github.com/thephpleague/uri
     *
     * ```
     * user:password@addr/dbname?param1=value1&paramN=valueN
     * ```
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    private function normalizeDsn(string $name, array $dsn): ?string
    {
        $dsn += $default = [
            // 'user' => '',
            // 'password' => '',
            // 'addr' => '127.0.0.1:3306',
            'host' => '127.0.0.1',
            'port' => 3306,
            // 'schema' => 'dbname',
            'disable' => false,
        ];

        if ($dsn['disable']) {
            return null;
        }

        if (!isset($dsn['addr'])) {
            $dsn['addr'] = "{$dsn['host']}:{$dsn['port']}";
        }

        foreach ($required = ['user', 'password', 'addr', 'schema'] as $key) {
            if (!isset($dsn[$key])) {
                throw new InvalidOptionException("The option [$name.$key] is required.");
            }
        }

        $url = "{$dsn['user']}:{$dsn['password']}@{$dsn['addr']}/{$dsn['schema']}";

        $query = urldecode(http_build_query(array_filter(
            $dsn,
            static fn (string $key): bool => !\in_array($key, [...$required, ...array_keys($default)], true),
            \ARRAY_FILTER_USE_KEY
        )));

        return $query ? "$url?$query" : $url;
    }
}
