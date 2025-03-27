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

namespace Guanguans\SoarPHP\Concerns;

use Guanguans\SoarPHP\Exceptions\BadMethodCallException;
use Guanguans\SoarPHP\Exceptions\InvalidOptionException;
use function Guanguans\SoarPHP\Support\array_reduce_with_keys;
use function Guanguans\SoarPHP\Support\str_snake;

/**
 * @method self setAllowCharsets(string $allowCharsets) @description AllowCharsets (default "utf8,utf8mb4")
 * @method self setAllowCollates(string $allowCollates) @description AllowCollates
 * @method self setAllowDropIndex(bool $allowDropIndex) @description AllowDropIndex, 允许输出删除重复索引的建议
 * @method self setAllowEngines(string $allowEngines) @description AllowEngines (default "innodb")
 * @method self setAllowOnlineAsTest(bool $allowOnlineAsTest) @description AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method self setBlacklist(string $blacklist) @description 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method self setCheckConfig(bool $checkConfig) @description Check configs
 * @method self setCleanupTestDatabase(bool $cleanupTestDatabase) @description 单次运行清理历史1小时前残余的测试库。
 * @method self setColumnNotAllowType(string $columnNotAllowType) @description ColumnNotAllowType (default "boolean")
 * @method self setConfig(string $config) @description Config file path
 * @method self setDelimiter(string $delimiter) @description Delimiter, SQL分隔符 (default ";")
 * @method self setDropTestTemporary(bool $dropTestTemporary) @description DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method self setDryRun(bool $dryRun) @description 是否在预演环境执行 (default true)
 * @method self setExplain(bool $explain) @description Explain, 是否开启Explain执行计划分析 (default true)
 * @method self setExplainFormat(string $explainFormat) @description ExplainFormat [json, traditional] (default "traditional")
 * @method self setExplainMaxFiltered(float $explainMaxFiltered) @description ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method self setExplainMaxKeys(int $explainMaxKeys) @description ExplainMaxKeyLength, 最大key_len (default 3)
 * @method self setExplainMaxRows(int $explainMaxRows) @description ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method self setExplainMinKeys(int $explainMinKeys) @description ExplainMinPossibleKeys, 最小possible_keys警告
 * @method self setExplainSqlReportType(string $explainSqlReportType) @description ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method self setExplainType(string $explainType) @description ExplainType [extended, partitions, traditional] (default "extended")
 * @method self setExplainWarnAccessType(string $explainWarnAccessType) @description ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method self setExplainWarnExtra(string $explainWarnExtra) @description ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method self setExplainWarnScalability(string $explainWarnScalability) @description ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method self setExplainWarnSelectType(string $explainWarnSelectType) @description ExplainWarnSelectType, 哪些select_type不建议使用
 * @method self setIgnoreRules(string $ignoreRules) @description IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method self setIndexPrefix(string $indexPrefix) @description IdxPrefix (default "idx_")
 * @method self setListHeuristicRules(bool $listHeuristicRules) @description ListHeuristicRules, 打印支持的评审规则列表
 * @method self setListReportTypes(bool $listReportTypes) @description ListReportTypes, 打印支持的报告输出类型
 * @method self setListRewriteRules(bool $listRewriteRules) @description ListRewriteRules, 打印支持的重写规则列表
 * @method self setListTestSqls(bool $listTestSqls) @description ListTestSqls, 打印测试case用于测试
 * @method self setLogLevel(int $logLevel) @description LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method self setLogOutput(string $logOutput) @description LogOutput, 日志输出位置 (default "soar.log")
 * @method self setLogErrStacks(bool $logErrStacks) @description log stack traces for errors
 * @method self setLogRotateMaxSize(int $logRotateMaxSize) @description size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method self setMarkdownExtensions(int $markdownExtensions) @description MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method self setMarkdownHtmlFlags(int $markdownHtmlFlags) @description MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method self setMaxColumnCount(int $maxColumnCount) @description MaxColCount, 单表允许的最大列数 (default 40)
 * @method self setMaxDistinctCount(int $maxDistinctCount) @description MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method self setMaxGroupByColsCount(int $maxGroupByColsCount) @description MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method self setMaxInCount(int $maxInCount) @description MaxInCount, IN()最大数量 (default 10)
 * @method self setMaxIndexBytes(int $maxIndexBytes) @description MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method self setMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn) @description MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method self setMaxIndexColsCount(int $maxIndexColsCount) @description MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method self setMaxIndexCount(int $maxIndexCount) @description MaxIdxCount, 单表最大索引个数 (default 10)
 * @method self setMaxJoinTableCount(int $maxJoinTableCount) @description MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method self setMaxPrettySqlLength(int $maxPrettySqlLength) @description MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method self setMaxQueryCost(int $maxQueryCost) @description MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method self setMaxSubqueryDepth(int $maxSubqueryDepth) @description MaxSubqueryDepth (default 5)
 * @method self setMaxTextColsCount(int $maxTextColsCount) @description MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method self setMaxTotalRows(int $maxTotalRows) @description MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method self setMaxValueCount(int $maxValueCount) @description MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method self setMaxVarcharLength(int $maxVarcharLength) @description MaxVarcharLength (default 1024)
 * @method self setMinCardinality(float $minCardinality) @description MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method self setOnlineDsn(string $onlineDsn) @description OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self setOnlySyntaxCheck(bool $onlySyntaxCheck) @description OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method self setPrintConfig(bool $printConfig) @description Print configs
 * @method self setProfiling(bool $profiling) @description Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method self setQuery(string $query) @description 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method self setReportCss(string $reportCss) @description ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method self setReportJavascript(string $reportJavascript) @description ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method self setReportTitle(string $reportTitle) @description ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method self setReportType(string $reportType) @description ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method self setRewriteRules(string $rewriteRules) @description RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method self setSampling(bool $sampling) @description Sampling, 数据采样开关
 * @method self setSamplingCondition(string $samplingCondition) @description SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method self setSamplingStatisticTarget(int $samplingStatisticTarget) @description SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method self setShowLastQueryCost(bool $showLastQueryCost) @description ShowLastQueryCost
 * @method self setShowWarnings(bool $showWarnings) @description ShowWarnings
 * @method self setSpaghettiQueryLength(int $spaghettiQueryLength) @description SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method self setTestDsn(string $testDsn) @description TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self setTrace(bool $trace) @description Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method self setUniqueKeyPrefix(string $uniqueKeyPrefix) @description UkPrefix (default "uk_")
 * @method self setVerbose(bool $verbose) @description Verbose
 * @method self setVersion(bool $version) @description Print version info
 * @method self setHelp(bool $help) @description Help
 * @method self withAllowCharsets(string $allowCharsets) @description AllowCharsets (default "utf8,utf8mb4")
 * @method self withAllowCollates(string $allowCollates) @description AllowCollates
 * @method self withAllowDropIndex(bool $allowDropIndex) @description AllowDropIndex, 允许输出删除重复索引的建议
 * @method self withAllowEngines(string $allowEngines) @description AllowEngines (default "innodb")
 * @method self withAllowOnlineAsTest(bool $allowOnlineAsTest) @description AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method self withBlacklist(string $blacklist) @description 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method self withCheckConfig(bool $checkConfig) @description Check configs
 * @method self withCleanupTestDatabase(bool $cleanupTestDatabase) @description 单次运行清理历史1小时前残余的测试库。
 * @method self withColumnNotAllowType(string $columnNotAllowType) @description ColumnNotAllowType (default "boolean")
 * @method self withConfig(string $config) @description Config file path
 * @method self withDelimiter(string $delimiter) @description Delimiter, SQL分隔符 (default ";")
 * @method self withDropTestTemporary(bool $dropTestTemporary) @description DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method self withDryRun(bool $dryRun) @description 是否在预演环境执行 (default true)
 * @method self withExplain(bool $explain) @description Explain, 是否开启Explain执行计划分析 (default true)
 * @method self withExplainFormat(string $explainFormat) @description ExplainFormat [json, traditional] (default "traditional")
 * @method self withExplainMaxFiltered(float $explainMaxFiltered) @description ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method self withExplainMaxKeys(int $explainMaxKeys) @description ExplainMaxKeyLength, 最大key_len (default 3)
 * @method self withExplainMaxRows(int $explainMaxRows) @description ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method self withExplainMinKeys(int $explainMinKeys) @description ExplainMinPossibleKeys, 最小possible_keys警告
 * @method self withExplainSqlReportType(string $explainSqlReportType) @description ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method self withExplainType(string $explainType) @description ExplainType [extended, partitions, traditional] (default "extended")
 * @method self withExplainWarnAccessType(string $explainWarnAccessType) @description ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method self withExplainWarnExtra(string $explainWarnExtra) @description ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method self withExplainWarnScalability(string $explainWarnScalability) @description ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method self withExplainWarnSelectType(string $explainWarnSelectType) @description ExplainWarnSelectType, 哪些select_type不建议使用
 * @method self withIgnoreRules(string $ignoreRules) @description IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method self withIndexPrefix(string $indexPrefix) @description IdxPrefix (default "idx_")
 * @method self withListHeuristicRules(bool $listHeuristicRules) @description ListHeuristicRules, 打印支持的评审规则列表
 * @method self withListReportTypes(bool $listReportTypes) @description ListReportTypes, 打印支持的报告输出类型
 * @method self withListRewriteRules(bool $listRewriteRules) @description ListRewriteRules, 打印支持的重写规则列表
 * @method self withListTestSqls(bool $listTestSqls) @description ListTestSqls, 打印测试case用于测试
 * @method self withLogLevel(int $logLevel) @description LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method self withLogOutput(string $logOutput) @description LogOutput, 日志输出位置 (default "soar.log")
 * @method self withLogErrStacks(bool $logErrStacks) @description log stack traces for errors
 * @method self withLogRotateMaxSize(int $logRotateMaxSize) @description size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method self withMarkdownExtensions(int $markdownExtensions) @description MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method self withMarkdownHtmlFlags(int $markdownHtmlFlags) @description MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method self withMaxColumnCount(int $maxColumnCount) @description MaxColCount, 单表允许的最大列数 (default 40)
 * @method self withMaxDistinctCount(int $maxDistinctCount) @description MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method self withMaxGroupByColsCount(int $maxGroupByColsCount) @description MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method self withMaxInCount(int $maxInCount) @description MaxInCount, IN()最大数量 (default 10)
 * @method self withMaxIndexBytes(int $maxIndexBytes) @description MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method self withMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn) @description MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method self withMaxIndexColsCount(int $maxIndexColsCount) @description MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method self withMaxIndexCount(int $maxIndexCount) @description MaxIdxCount, 单表最大索引个数 (default 10)
 * @method self withMaxJoinTableCount(int $maxJoinTableCount) @description MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method self withMaxPrettySqlLength(int $maxPrettySqlLength) @description MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method self withMaxQueryCost(int $maxQueryCost) @description MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method self withMaxSubqueryDepth(int $maxSubqueryDepth) @description MaxSubqueryDepth (default 5)
 * @method self withMaxTextColsCount(int $maxTextColsCount) @description MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method self withMaxTotalRows(int $maxTotalRows) @description MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method self withMaxValueCount(int $maxValueCount) @description MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method self withMaxVarcharLength(int $maxVarcharLength) @description MaxVarcharLength (default 1024)
 * @method self withMinCardinality(float $minCardinality) @description MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method self withOnlineDsn(string $onlineDsn) @description OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self withOnlySyntaxCheck(bool $onlySyntaxCheck) @description OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method self withPrintConfig(bool $printConfig) @description Print configs
 * @method self withProfiling(bool $profiling) @description Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method self withQuery(string $query) @description 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method self withReportCss(string $reportCss) @description ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method self withReportJavascript(string $reportJavascript) @description ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method self withReportTitle(string $reportTitle) @description ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method self withReportType(string $reportType) @description ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method self withRewriteRules(string $rewriteRules) @description RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method self withSampling(bool $sampling) @description Sampling, 数据采样开关
 * @method self withSamplingCondition(string $samplingCondition) @description SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method self withSamplingStatisticTarget(int $samplingStatisticTarget) @description SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method self withShowLastQueryCost(bool $showLastQueryCost) @description ShowLastQueryCost
 * @method self withShowWarnings(bool $showWarnings) @description ShowWarnings
 * @method self withSpaghettiQueryLength(int $spaghettiQueryLength) @description SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method self withTestDsn(string $testDsn) @description TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self withTrace(bool $trace) @description Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method self withUniqueKeyPrefix(string $uniqueKeyPrefix) @description UkPrefix (default "uk_")
 * @method self withVerbose(bool $verbose) @description Verbose
 * @method self withVersion(bool $version) @description Print version info
 * @method self withHelp(bool $help) @description Help
 * @method null|string getAllowCharsets(mixed $default = null) @description AllowCharsets (default "utf8,utf8mb4")
 * @method null|string getAllowCollates(mixed $default = null) @description AllowCollates
 * @method null|bool getAllowDropIndex(mixed $default = null) @description AllowDropIndex, 允许输出删除重复索引的建议
 * @method null|string getAllowEngines(mixed $default = null) @description AllowEngines (default "innodb")
 * @method null|bool getAllowOnlineAsTest(mixed $default = null) @description AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method null|string getBlacklist(mixed $default = null) @description 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method null|bool getCheckConfig(mixed $default = null) @description Check configs
 * @method null|bool getCleanupTestDatabase(mixed $default = null) @description 单次运行清理历史1小时前残余的测试库。
 * @method null|string getColumnNotAllowType(mixed $default = null) @description ColumnNotAllowType (default "boolean")
 * @method null|string getConfig(mixed $default = null) @description Config file path
 * @method null|string getDelimiter(mixed $default = null) @description Delimiter, SQL分隔符 (default ";")
 * @method null|bool getDropTestTemporary(mixed $default = null) @description DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method null|bool getDryRun(mixed $default = null) @description 是否在预演环境执行 (default true)
 * @method null|bool getExplain(mixed $default = null) @description Explain, 是否开启Explain执行计划分析 (default true)
 * @method null|string getExplainFormat(mixed $default = null) @description ExplainFormat [json, traditional] (default "traditional")
 * @method null|float getExplainMaxFiltered(mixed $default = null) @description ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method null|int getExplainMaxKeys(mixed $default = null) @description ExplainMaxKeyLength, 最大key_len (default 3)
 * @method null|int getExplainMaxRows(mixed $default = null) @description ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method null|int getExplainMinKeys(mixed $default = null) @description ExplainMinPossibleKeys, 最小possible_keys警告
 * @method null|string getExplainSqlReportType(mixed $default = null) @description ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method null|string getExplainType(mixed $default = null) @description ExplainType [extended, partitions, traditional] (default "extended")
 * @method null|string getExplainWarnAccessType(mixed $default = null) @description ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method null|string getExplainWarnExtra(mixed $default = null) @description ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method null|string getExplainWarnScalability(mixed $default = null) @description ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method null|string getExplainWarnSelectType(mixed $default = null) @description ExplainWarnSelectType, 哪些select_type不建议使用
 * @method null|string getIgnoreRules(mixed $default = null) @description IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method null|string getIndexPrefix(mixed $default = null) @description IdxPrefix (default "idx_")
 * @method null|bool getListHeuristicRules(mixed $default = null) @description ListHeuristicRules, 打印支持的评审规则列表
 * @method null|bool getListReportTypes(mixed $default = null) @description ListReportTypes, 打印支持的报告输出类型
 * @method null|bool getListRewriteRules(mixed $default = null) @description ListRewriteRules, 打印支持的重写规则列表
 * @method null|bool getListTestSqls(mixed $default = null) @description ListTestSqls, 打印测试case用于测试
 * @method null|int getLogLevel(mixed $default = null) @description LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method null|string getLogOutput(mixed $default = null) @description LogOutput, 日志输出位置 (default "soar.log")
 * @method null|bool getLogErrStacks(mixed $default = null) @description log stack traces for errors
 * @method null|int getLogRotateMaxSize(mixed $default = null) @description size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method null|int getMarkdownExtensions(mixed $default = null) @description MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method null|int getMarkdownHtmlFlags(mixed $default = null) @description MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method null|int getMaxColumnCount(mixed $default = null) @description MaxColCount, 单表允许的最大列数 (default 40)
 * @method null|int getMaxDistinctCount(mixed $default = null) @description MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method null|int getMaxGroupByColsCount(mixed $default = null) @description MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method null|int getMaxInCount(mixed $default = null) @description MaxInCount, IN()最大数量 (default 10)
 * @method null|int getMaxIndexBytes(mixed $default = null) @description MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method null|int getMaxIndexBytesPercolumn(mixed $default = null) @description MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method null|int getMaxIndexColsCount(mixed $default = null) @description MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method null|int getMaxIndexCount(mixed $default = null) @description MaxIdxCount, 单表最大索引个数 (default 10)
 * @method null|int getMaxJoinTableCount(mixed $default = null) @description MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method null|int getMaxPrettySqlLength(mixed $default = null) @description MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method null|int getMaxQueryCost(mixed $default = null) @description MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method null|int getMaxSubqueryDepth(mixed $default = null) @description MaxSubqueryDepth (default 5)
 * @method null|int getMaxTextColsCount(mixed $default = null) @description MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method null|int getMaxTotalRows(mixed $default = null) @description MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method null|int getMaxValueCount(mixed $default = null) @description MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method null|int getMaxVarcharLength(mixed $default = null) @description MaxVarcharLength (default 1024)
 * @method null|float getMinCardinality(mixed $default = null) @description MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method null|string getOnlineDsn(mixed $default = null) @description OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method null|bool getOnlySyntaxCheck(mixed $default = null) @description OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method null|bool getPrintConfig(mixed $default = null) @description Print configs
 * @method null|bool getProfiling(mixed $default = null) @description Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method null|string getQuery(mixed $default = null) @description 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method null|string getReportCss(mixed $default = null) @description ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method null|string getReportJavascript(mixed $default = null) @description ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method null|string getReportTitle(mixed $default = null) @description ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method null|string getReportType(mixed $default = null) @description ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method null|string getRewriteRules(mixed $default = null) @description RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method null|bool getSampling(mixed $default = null) @description Sampling, 数据采样开关
 * @method null|string getSamplingCondition(mixed $default = null) @description SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method null|int getSamplingStatisticTarget(mixed $default = null) @description SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method null|bool getShowLastQueryCost(mixed $default = null) @description ShowLastQueryCost
 * @method null|bool getShowWarnings(mixed $default = null) @description ShowWarnings
 * @method null|int getSpaghettiQueryLength(mixed $default = null) @description SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method null|string getTestDsn(mixed $default = null) @description TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method null|bool getTrace(mixed $default = null) @description Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method null|string getUniqueKeyPrefix(mixed $default = null) @description UkPrefix (default "uk_")
 * @method null|bool getVerbose(mixed $default = null) @description Verbose
 * @method null|bool getVersion(mixed $default = null) @description Print version info
 * @method null|bool getHelp(mixed $default = null) @description Help
 * @method self onlyAllowCharsets() @description AllowCharsets (default "utf8,utf8mb4")
 * @method self onlyAllowCollates() @description AllowCollates
 * @method self onlyAllowDropIndex() @description AllowDropIndex, 允许输出删除重复索引的建议
 * @method self onlyAllowEngines() @description AllowEngines (default "innodb")
 * @method self onlyAllowOnlineAsTest() @description AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method self onlyBlacklist() @description 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method self onlyCheckConfig() @description Check configs
 * @method self onlyCleanupTestDatabase() @description 单次运行清理历史1小时前残余的测试库。
 * @method self onlyColumnNotAllowType() @description ColumnNotAllowType (default "boolean")
 * @method self onlyConfig() @description Config file path
 * @method self onlyDelimiter() @description Delimiter, SQL分隔符 (default ";")
 * @method self onlyDropTestTemporary() @description DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method self onlyDryRun() @description 是否在预演环境执行 (default true)
 * @method self onlyExplain() @description Explain, 是否开启Explain执行计划分析 (default true)
 * @method self onlyExplainFormat() @description ExplainFormat [json, traditional] (default "traditional")
 * @method self onlyExplainMaxFiltered() @description ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method self onlyExplainMaxKeys() @description ExplainMaxKeyLength, 最大key_len (default 3)
 * @method self onlyExplainMaxRows() @description ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method self onlyExplainMinKeys() @description ExplainMinPossibleKeys, 最小possible_keys警告
 * @method self onlyExplainSqlReportType() @description ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method self onlyExplainType() @description ExplainType [extended, partitions, traditional] (default "extended")
 * @method self onlyExplainWarnAccessType() @description ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method self onlyExplainWarnExtra() @description ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method self onlyExplainWarnScalability() @description ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method self onlyExplainWarnSelectType() @description ExplainWarnSelectType, 哪些select_type不建议使用
 * @method self onlyIgnoreRules() @description IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method self onlyIndexPrefix() @description IdxPrefix (default "idx_")
 * @method self onlyListHeuristicRules() @description ListHeuristicRules, 打印支持的评审规则列表
 * @method self onlyListReportTypes() @description ListReportTypes, 打印支持的报告输出类型
 * @method self onlyListRewriteRules() @description ListRewriteRules, 打印支持的重写规则列表
 * @method self onlyListTestSqls() @description ListTestSqls, 打印测试case用于测试
 * @method self onlyLogLevel() @description LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method self onlyLogOutput() @description LogOutput, 日志输出位置 (default "soar.log")
 * @method self onlyLogErrStacks() @description log stack traces for errors
 * @method self onlyLogRotateMaxSize() @description size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method self onlyMarkdownExtensions() @description MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method self onlyMarkdownHtmlFlags() @description MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method self onlyMaxColumnCount() @description MaxColCount, 单表允许的最大列数 (default 40)
 * @method self onlyMaxDistinctCount() @description MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method self onlyMaxGroupByColsCount() @description MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method self onlyMaxInCount() @description MaxInCount, IN()最大数量 (default 10)
 * @method self onlyMaxIndexBytes() @description MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method self onlyMaxIndexBytesPercolumn() @description MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method self onlyMaxIndexColsCount() @description MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method self onlyMaxIndexCount() @description MaxIdxCount, 单表最大索引个数 (default 10)
 * @method self onlyMaxJoinTableCount() @description MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method self onlyMaxPrettySqlLength() @description MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method self onlyMaxQueryCost() @description MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method self onlyMaxSubqueryDepth() @description MaxSubqueryDepth (default 5)
 * @method self onlyMaxTextColsCount() @description MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method self onlyMaxTotalRows() @description MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method self onlyMaxValueCount() @description MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method self onlyMaxVarcharLength() @description MaxVarcharLength (default 1024)
 * @method self onlyMinCardinality() @description MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method self onlyOnlineDsn() @description OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self onlyOnlySyntaxCheck() @description OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method self onlyPrintConfig() @description Print configs
 * @method self onlyProfiling() @description Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method self onlyQuery() @description 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method self onlyReportCss() @description ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method self onlyReportJavascript() @description ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method self onlyReportTitle() @description ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method self onlyReportType() @description ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method self onlyRewriteRules() @description RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method self onlySampling() @description Sampling, 数据采样开关
 * @method self onlySamplingCondition() @description SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method self onlySamplingStatisticTarget() @description SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method self onlyShowLastQueryCost() @description ShowLastQueryCost
 * @method self onlyShowWarnings() @description ShowWarnings
 * @method self onlySpaghettiQueryLength() @description SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method self onlyTestDsn() @description TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self onlyTrace() @description Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method self onlyUniqueKeyPrefix() @description UkPrefix (default "uk_")
 * @method self onlyVerbose() @description Verbose
 * @method self onlyVersion() @description Print version info
 * @method self onlyHelp() @description Help
 * @method self exceptAllowCharsets() @description AllowCharsets (default "utf8,utf8mb4")
 * @method self exceptAllowCollates() @description AllowCollates
 * @method self exceptAllowDropIndex() @description AllowDropIndex, 允许输出删除重复索引的建议
 * @method self exceptAllowEngines() @description AllowEngines (default "innodb")
 * @method self exceptAllowOnlineAsTest() @description AllowOnlineAsTest, 允许线上环境也可以当作测试环境
 * @method self exceptBlacklist() @description 指定 blacklist 配置文件的位置，文件中的 SQL 不会被评审。一行一条SQL，可以是指纹，也可以是正则
 * @method self exceptCheckConfig() @description Check configs
 * @method self exceptCleanupTestDatabase() @description 单次运行清理历史1小时前残余的测试库。
 * @method self exceptColumnNotAllowType() @description ColumnNotAllowType (default "boolean")
 * @method self exceptConfig() @description Config file path
 * @method self exceptDelimiter() @description Delimiter, SQL分隔符 (default ";")
 * @method self exceptDropTestTemporary() @description DropTestTemporary, 是否清理测试环境产生的临时库表 (default true)
 * @method self exceptDryRun() @description 是否在预演环境执行 (default true)
 * @method self exceptExplain() @description Explain, 是否开启Explain执行计划分析 (default true)
 * @method self exceptExplainFormat() @description ExplainFormat [json, traditional] (default "traditional")
 * @method self exceptExplainMaxFiltered() @description ExplainMaxFiltered, filtered大于该配置给出警告 (default 100)
 * @method self exceptExplainMaxKeys() @description ExplainMaxKeyLength, 最大key_len (default 3)
 * @method self exceptExplainMaxRows() @description ExplainMaxRows, 最大扫描行数警告 (default 10000)
 * @method self exceptExplainMinKeys() @description ExplainMinPossibleKeys, 最小possible_keys警告
 * @method self exceptExplainSqlReportType() @description ExplainSQLReportType [pretty, sample, fingerprint] (default "pretty")
 * @method self exceptExplainType() @description ExplainType [extended, partitions, traditional] (default "extended")
 * @method self exceptExplainWarnAccessType() @description ExplainWarnAccessType, 哪些access type不建议使用 (default "ALL")
 * @method self exceptExplainWarnExtra() @description ExplainWarnExtra, 哪些extra信息会给警告 (default "Using temporary,Using filesort")
 * @method self exceptExplainWarnScalability() @description ExplainWarnScalability, 复杂度警告名单, 支持O(n),O(log n),O(1),O(?) (default "O(n)")
 * @method self exceptExplainWarnSelectType() @description ExplainWarnSelectType, 哪些select_type不建议使用
 * @method self exceptIgnoreRules() @description IgnoreRules, 忽略的优化建议规则 (default "COL.011")
 * @method self exceptIndexPrefix() @description IdxPrefix (default "idx_")
 * @method self exceptListHeuristicRules() @description ListHeuristicRules, 打印支持的评审规则列表
 * @method self exceptListReportTypes() @description ListReportTypes, 打印支持的报告输出类型
 * @method self exceptListRewriteRules() @description ListRewriteRules, 打印支持的重写规则列表
 * @method self exceptListTestSqls() @description ListTestSqls, 打印测试case用于测试
 * @method self exceptLogLevel() @description LogLevel, 日志级别, [0:Emergency, 1:Alert, 2:Critical, 3:Error, 4:Warning, 5:Notice, 6:Informational, 7:Debug] (default 3)
 * @method self exceptLogOutput() @description LogOutput, 日志输出位置 (default "soar.log")
 * @method self exceptLogErrStacks() @description log stack traces for errors
 * @method self exceptLogRotateMaxSize() @description size in bytes at which logs are rotated (glog.MaxSize) (default 1887436800)
 * @method self exceptMarkdownExtensions() @description MarkdownExtensions, markdown 转 html支持的扩展包, 参考blackfriday (default 94)
 * @method self exceptMarkdownHtmlFlags() @description MarkdownHTMLFlags, markdown 转 html 支持的 flag, 参考blackfriday
 * @method self exceptMaxColumnCount() @description MaxColCount, 单表允许的最大列数 (default 40)
 * @method self exceptMaxDistinctCount() @description MaxDistinctCount, 单条 SQL 中 Distinct 的最大数量 (default 5)
 * @method self exceptMaxGroupByColsCount() @description MaxGroupByColsCount, 单条 SQL 中 GroupBy 包含列的最大数量 (default 5)
 * @method self exceptMaxInCount() @description MaxInCount, IN()最大数量 (default 10)
 * @method self exceptMaxIndexBytes() @description MaxIdxBytes, 索引总长度限制 (default 3072)
 * @method self exceptMaxIndexBytesPercolumn() @description MaxIdxBytesPerColumn, 索引中单列最大字节数 (default 767)
 * @method self exceptMaxIndexColsCount() @description MaxIdxColsCount, 复合索引中包含列的最大数量 (default 5)
 * @method self exceptMaxIndexCount() @description MaxIdxCount, 单表最大索引个数 (default 10)
 * @method self exceptMaxJoinTableCount() @description MaxJoinTableCount, 单条 SQL 中 JOIN 表的最大数量 (default 5)
 * @method self exceptMaxPrettySqlLength() @description MaxPrettySQLLength, 超出该长度的SQL会转换成指纹输出 (default 1024)
 * @method self exceptMaxQueryCost() @description MaxQueryCost, last_query_cost 超过该值时将给予警告 (default 9999)
 * @method self exceptMaxSubqueryDepth() @description MaxSubqueryDepth (default 5)
 * @method self exceptMaxTextColsCount() @description MaxTextColsCount, 表中含有的 text/blob 列的最大数量 (default 2)
 * @method self exceptMaxTotalRows() @description MaxTotalRows, 计算散粒度时，当数据行数大于MaxTotalRows即开启数据库保护模式，不计算散粒度 (default 9999999)
 * @method self exceptMaxValueCount() @description MaxValueCount, INSERT/REPLACE 单次批量写入允许的行数 (default 100)
 * @method self exceptMaxVarcharLength() @description MaxVarcharLength (default 1024)
 * @method self exceptMinCardinality() @description MinCardinality，索引列散粒度最低阈值，散粒度低于该值的列不添加索引，建议范围0.0 ~ 100.0
 * @method self exceptOnlineDsn() @description OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self exceptOnlySyntaxCheck() @description OnlySyntaxCheck, 只做语法检查不输出优化建议
 * @method self exceptPrintConfig() @description Print configs
 * @method self exceptProfiling() @description Profiling, 开启数据采样的情况下在测试环境执行Profile
 * @method self exceptQuery() @description 待评审的 SQL 或 SQL 文件，如 SQL 中包含特殊字符建议使用文件名。
 * @method self exceptReportCss() @description ReportCSS, 当 ReportType 为 html 格式时使用的 css 风格，如不指定会提供一个默认风格。CSS可以是本地文件，也可以是一个URL
 * @method self exceptReportJavascript() @description ReportJavascript, 当 ReportType 为 html 格式时使用的javascript脚本，如不指定默认会加载SQL pretty 使用的 javascript。像CSS一样可以是本地文件，也可以是一个URL
 * @method self exceptReportTitle() @description ReportTitle, 当 ReportType 为 html 格式时，HTML 的 title (default "SQL优化分析报告")
 * @method self exceptReportType() @description ReportType, 优化建议输出格式，目前支持: json, text, markdown, html等 (default "markdown")
 * @method self exceptRewriteRules() @description RewriteRules, 生效的重写规则 (default "delimiter,orderbynull,groupbyconst,dmlorderby,having,star2columns,insertcolumns,distinctstar")
 * @method self exceptSampling() @description Sampling, 数据采样开关
 * @method self exceptSamplingCondition() @description SamplingCondition, 数据采样条件，如： WHERE xxx LIMIT xxx
 * @method self exceptSamplingStatisticTarget() @description SamplingStatisticTarget, 数据采样因子，对应 PostgreSQL 的 default_statistics_target (default 100)
 * @method self exceptShowLastQueryCost() @description ShowLastQueryCost
 * @method self exceptShowWarnings() @description ShowWarnings
 * @method self exceptSpaghettiQueryLength() @description SpaghettiQueryLength, SQL最大长度警告，超过该长度会给警告 (default 2048)
 * @method self exceptTestDsn() @description TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 * @method self exceptTrace() @description Trace, 开启数据采样的情况下在测试环境执行Trace
 * @method self exceptUniqueKeyPrefix() @description UkPrefix (default "uk_")
 * @method self exceptVerbose() @description Verbose
 * @method self exceptVersion() @description Print version info
 * @method self exceptHelp() @description Help
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
     * @throws \JsonException
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    protected function getNormalizedOptions(): array
    {
        return $this->normalizeOptions($this->options);
    }

    /**
     * @throws \JsonException
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    protected function normalizeOptions(array $options): array
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
     * @throws \JsonException
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    protected function normalizeOption(string $name, mixed $value): string
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
     * @throws \JsonException
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
