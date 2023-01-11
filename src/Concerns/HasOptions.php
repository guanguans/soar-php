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
 * @method self setAllowCharsets(string $allowCharsets)
 * @method self setAllowCollates(string $allowCollates)
 * @method self setAllowDropIndex($allowDropIndex)
 * @method self setAllowEngines(string $allowEngines)
 * @method self setAllowOnlineAsTest($allowOnlineAsTest)
 * @method self setBlacklist(string $blacklist)
 * @method self setCheckConfig($checkConfig)
 * @method self setCleanupTestDatabase($cleanupTestDatabase)
 * @method self setColumnNotAllowType(string $columnNotAllowType)
 * @method self setConfig(string $config)
 * @method self setDelimiter(string $delimiter)
 * @method self setDropTestTemporary($dropTestTemporary)
 * @method self setDryRun($dryRun)
 * @method self setExplain($explain)
 * @method self setExplainFormat(string $explainFormat)
 * @method self setExplainMaxFiltered(float $explainMaxFiltered)
 * @method self setExplainMaxKeys(int $explainMaxKeys)
 * @method self setExplainMaxRows(int $explainMaxRows)
 * @method self setExplainMinKeys(int $explainMinKeys)
 * @method self setExplainSqlReportType(string $explainSqlReportType)
 * @method self setExplainType(string $explainType)
 * @method self setExplainWarnAccessType(string $explainWarnAccessType)
 * @method self setExplainWarnExtra(string $explainWarnExtra)
 * @method self setExplainWarnScalability(string $explainWarnScalability)
 * @method self setExplainWarnSelectType(string $explainWarnSelectType)
 * @method self setIgnoreRules(string $ignoreRules)
 * @method self setIndexPrefix(string $indexPrefix)
 * @method self setListHeuristicRules($listHeuristicRules)
 * @method self setListReportTypes($listReportTypes)
 * @method self setListRewriteRules($listRewriteRules)
 * @method self setListTestSqls($listTestSqls)
 * @method self setLogLevel(int $logLevel)
 * @method self setLogOutput(string $logOutput)
 * @method self setLogErrStacks($logErrStacks)
 * @method self setLogRotateMaxSize(int $logRotateMaxSize)
 * @method self setMarkdownExtensions(int $markdownExtensions)
 * @method self setMarkdownHtmlFlags(int $markdownHtmlFlags)
 * @method self setMaxColumnCount(int $maxColumnCount)
 * @method self setMaxDistinctCount(int $maxDistinctCount)
 * @method self setMaxGroupByColsCount(int $maxGroupByColsCount)
 * @method self setMaxInCount(int $maxInCount)
 * @method self setMaxIndexBytes(int $maxIndexBytes)
 * @method self setMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn)
 * @method self setMaxIndexColsCount(int $maxIndexColsCount)
 * @method self setMaxIndexCount(int $maxIndexCount)
 * @method self setMaxJoinTableCount(int $maxJoinTableCount)
 * @method self setMaxPrettySqlLength(int $maxPrettySqlLength)
 * @method self setMaxQueryCost(int $maxQueryCost)
 * @method self setMaxSubqueryDepth(int $maxSubqueryDepth)
 * @method self setMaxTextColsCount(int $maxTextColsCount)
 * @method self setMaxTotalRows(int $maxTotalRows)
 * @method self setMaxValueCount(int $maxValueCount)
 * @method self setMaxVarcharLength(int $maxVarcharLength)
 * @method self setMinCardinality(float $minCardinality)
 * @method self setOnlineDsn(string $onlineDsn)
 * @method self setOnlySyntaxCheck($onlySyntaxCheck)
 * @method self setPrintConfig($printConfig)
 * @method self setProfiling($profiling)
 * @method self setQuery(string $query)
 * @method self setReportCss(string $reportCss)
 * @method self setReportJavascript(string $reportJavascript)
 * @method self setReportTitle(string $reportTitle)
 * @method self setReportType(string $reportType)
 * @method self setRewriteRules(string $rewriteRules)
 * @method self setSampling($sampling)
 * @method self setSamplingCondition(string $samplingCondition)
 * @method self setSamplingStatisticTarget(int $samplingStatisticTarget)
 * @method self setShowLastQueryCost($showLastQueryCost)
 * @method self setShowWarnings($showWarnings)
 * @method self setSpaghettiQueryLength(int $spaghettiQueryLength)
 * @method self setTestDsn(string $testDsn)
 * @method self setTrace($trace)
 * @method self setUniqueKeyPrefix(string $uniqueKeyPrefix)
 * @method self setVerbose($verbose)
 * @method self setVersion($version)
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
    protected $normalizedOptions = [];

    /**
     * @psalm-suppress UndefinedClass
     */
    public function __call($name, $arguments)
    {
        if (! str_starts_with($name, 'set')) {
            throw new BadMethodCallException("The method($name) does not exist.");
        }

        $key = substr(str_snake($name, '-'), 3);

        return $this->setOption($key, ...$arguments);
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

    public function setOptions(array $options): self
    {
        $this->options = array_merge($this->options, $options);
        $this->normalizedOptions = $this->normalizeOptions($this->options);

        return $this;
    }

    public function setOption(string $key, $value): self
    {
        $this->setOptions([$key => $value]);

        return $this;
    }

    /**
     * @param array<string>|null $keys
     */
    public function getNormalizedOptions(?array $keys = null): array
    {
        if (null === $keys) {
            return $this->getNormalizedOption();
        }

        return array_reduce($keys, function (array $normalizedOptions, string $key): array {
            $normalizedOptions[$key] = $this->getNormalizedOption($key);

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

    protected function getNormalizedStrOptions(): string
    {
        return implode(' ', $this->normalizedOptions);
    }

    /**
     * @psalm-suppress UnnecessaryVarAnnotation
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidConfigException
     */
    protected function normalizeOptions(array $options): array
    {
        return array_reduce_with_keys($options, static function (array $normalizedOptions, $option, $key): array {
            if (! is_scalar($option) && ! is_array($option)) {
                throw new InvalidConfigException(sprintf('Invalid configuration type(%s).', gettype($option)));
            }

            if (is_scalar($option)) {
                is_int($key) ? $normalizedOptions[(string) $option] = "$option" : $normalizedOptions[$key] = "$key=$option";

                return $normalizedOptions;
            }

            /** @var array $option */
            if (in_array($key, ['-test-dsn', '-online-dsn']) && isset($option['disable']) && true !== $option['disable']) {
                /** @var array $option */
                $dsn = "{$option['username']}:{$option['password']}@{$option['host']}:{$option['port']}/{$option['dbname']}";
                $normalizedOptions[$key] = "$key=$dsn";

                return $normalizedOptions;
            }

            $normalizedOptions[$key] = sprintf("$key=%s", implode(',', $option));

            return $normalizedOptions;
        }, []);
    }
}
