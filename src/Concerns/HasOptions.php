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
use Guanguans\SoarPHP\Exceptions\InvalidConfigException;

/**
 * AllowCharsets (default "utf8,utf8mb4").
 *
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
 * OnlineDSN, 线上环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 *
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
 * TestDSN, 测试环境数据库配置, username:********@tcp(ip:port)/schema (default "tcp/information_schema?timeout=3s&charset=utf8")
 *
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
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait HasOptions
{
    /**
     * @var array<array-key, scalar|array>
     */
    protected $options = [];

    /**
     * @var array<string, string>
     */
    private $normalizedOptions = [];

    public function setOptions(array $options): self
    {
        $this->options = $options;
        $this->normalizedOptions = $this->normalizeOptions($this->options);

        return $this;
    }

    public function setOption(string $key, $value): self
    {
        $this->options[$key] = $value;
        $this->normalizedOptions = $this->normalizeOptions($this->options);

        return $this;
    }

    public function mergeOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);
        $this->normalizedOptions = $this->normalizeOptions($this->options);

        return $this;
    }

    public function resetOptions(array $except = ['-test-dsn', '-online-dsn']): self
    {
        $this->options = array_reduce_with_keys($this->options, function (array $options, $option, $key) use ($except): array {
            if (in_array($key, $except, true)) {
                $options[$key] = $option;
            }

            return $options;
        }, []);

        $this->normalizedOptions = $this->normalizeOptions($this->options);

        return $this;
    }

    public function getOptions(): array
    {
        return $this->getOption();
    }

    public function getOption(?string $key = null, $value = null)
    {
        if (null === $key) {
            return $this->options;
        }

        return $this->options[$key] ?? $value;
    }

    /**
     * @param array<string>|null $keys
     */
    public function getNormalizedOptions(?array $keys = null): array
    {
        if (null === $keys) {
            return array_values($this->getNormalizedOption());
        }

        return array_reduce($keys, function (array $normalizedOptions, string $key): array {
            $normalizedOptions[] = $this->getNormalizedOption($key);

            return $normalizedOptions;
        }, []);
    }

    public function getNormalizedOption(?string $key = null, $value = null)
    {
        if (null === $key) {
            return $this->normalizedOptions;
        }

        return $this->normalizedOptions[$key] ?? $value;
    }

    /**
     * @param array<string>|null $keys
     */
    public function getNormalizedStrOptions(?array $keys = null): string
    {
        return implode(' ', $this->getNormalizedOptions($keys));
    }

    /**
     * @param string $name
     * @param array  $arguments
     *
     * @return $this
     *
     * @throws \Guanguans\SoarPHP\Exceptions\BadMethodCallException
     */
    public function __call($name, $arguments)
    {
        if (! str_starts_with($name, 'set')) {
            throw new BadMethodCallException("The method($name) does not exist.");
        }

        $key = substr(str_snake($name, '-'), 3);
        $this->setOption($key, ...$arguments);

        return $this;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    protected function normalizeOptions(array $options): array
    {
        $filteredOptions = array_filter($options, static function ($option): bool {
            if (! is_scalar($option) && ! is_array($option)) {
                throw new InvalidConfigException(sprintf('Invalid configuration type(%s).', gettype($option)));
            }

            return null !== $option;
        });

        $converter = function ($filteredOption) {
            true === $filteredOption and $filteredOption = 'true';
            false === $filteredOption and $filteredOption = 'false';
            0 === $filteredOption and $filteredOption = '0';

            return $filteredOption;
        };

        return array_reduce_with_keys(array_map($converter, $filteredOptions), static function (array $normalizedOptions, $option, $key) use ($converter): array {
            if (is_scalar($option)) {
                is_int($key) ? $normalizedOptions[(string) $option] = (string) $option : $normalizedOptions[$key] = "$key=$option";

                return $normalizedOptions;
            }

            /** @var array $option */
            if (in_array($key, ['-test-dsn', '-online-dsn']) && isset($option['disable']) && true !== $option['disable']) {
                /** @var array $option */
                $dsn = "{$option['username']}:{$option['password']}@{$option['host']}:{$option['port']}/{$option['dbname']}";
                $normalizedOptions[$key] = "$key=$dsn";

                return $normalizedOptions;
            }

            $normalizedOptions[$key] = sprintf("$key=%s", implode(',', array_map($converter, $option)));

            return $normalizedOptions;
        }, []);
    }
}
