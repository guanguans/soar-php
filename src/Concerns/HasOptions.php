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
 * @method \Guanguans\SoarPHP\Soar setAllowCharsets(string $allowCharsets)
 * @method \Guanguans\SoarPHP\Soar setAllowCollates(string $allowCollates)
 * @method \Guanguans\SoarPHP\Soar setAllowDropIndex($allowDropIndex)
 * @method \Guanguans\SoarPHP\Soar setAllowEngines(string $allowEngines)
 * @method \Guanguans\SoarPHP\Soar setAllowOnlineAsTest($allowOnlineAsTest)
 * @method \Guanguans\SoarPHP\Soar setBlacklist(string $blacklist)
 * @method \Guanguans\SoarPHP\Soar setCheckConfig($checkConfig)
 * @method \Guanguans\SoarPHP\Soar setCleanupTestDatabase($cleanupTestDatabase)
 * @method \Guanguans\SoarPHP\Soar setColumnNotAllowType(string $columnNotAllowType)
 * @method \Guanguans\SoarPHP\Soar setConfig(string $config)
 * @method \Guanguans\SoarPHP\Soar setDelimiter(string $delimiter)
 * @method \Guanguans\SoarPHP\Soar setDropTestTemporary($dropTestTemporary)
 * @method \Guanguans\SoarPHP\Soar setDryRun($dryRun)
 * @method \Guanguans\SoarPHP\Soar setExplain($explain)
 * @method \Guanguans\SoarPHP\Soar setExplainFormat(string $explainFormat)
 * @method \Guanguans\SoarPHP\Soar setExplainMaxFiltered(float $explainMaxFiltered)
 * @method \Guanguans\SoarPHP\Soar setExplainMaxKeys(int $explainMaxKeys)
 * @method \Guanguans\SoarPHP\Soar setExplainMaxRows(int $explainMaxRows)
 * @method \Guanguans\SoarPHP\Soar setExplainMinKeys(int $explainMinKeys)
 * @method \Guanguans\SoarPHP\Soar setExplainSqlReportType(string $explainSqlReportType)
 * @method \Guanguans\SoarPHP\Soar setExplainType(string $explainType)
 * @method \Guanguans\SoarPHP\Soar setExplainWarnAccessType(string $explainWarnAccessType)
 * @method \Guanguans\SoarPHP\Soar setExplainWarnExtra(string $explainWarnExtra)
 * @method \Guanguans\SoarPHP\Soar setExplainWarnScalability(string $explainWarnScalability)
 * @method \Guanguans\SoarPHP\Soar setExplainWarnSelectType(string $explainWarnSelectType)
 * @method \Guanguans\SoarPHP\Soar setIgnoreRules(string $ignoreRules)
 * @method \Guanguans\SoarPHP\Soar setIndexPrefix(string $indexPrefix)
 * @method \Guanguans\SoarPHP\Soar setListHeuristicRules($listHeuristicRules)
 * @method \Guanguans\SoarPHP\Soar setListReportTypes($listReportTypes)
 * @method \Guanguans\SoarPHP\Soar setListRewriteRules($listRewriteRules)
 * @method \Guanguans\SoarPHP\Soar setListTestSqls($listTestSqls)
 * @method \Guanguans\SoarPHP\Soar setLogLevel(int $logLevel)
 * @method \Guanguans\SoarPHP\Soar setLogOutput(string $logOutput)
 * @method \Guanguans\SoarPHP\Soar setLogErrStacks($logErrStacks)
 * @method \Guanguans\SoarPHP\Soar setLogRotateMaxSize(int $logRotateMaxSize)
 * @method \Guanguans\SoarPHP\Soar setMarkdownExtensions(int $markdownExtensions)
 * @method \Guanguans\SoarPHP\Soar setMarkdownHtmlFlags(int $markdownHtmlFlags)
 * @method \Guanguans\SoarPHP\Soar setMaxColumnCount(int $maxColumnCount)
 * @method \Guanguans\SoarPHP\Soar setMaxDistinctCount(int $maxDistinctCount)
 * @method \Guanguans\SoarPHP\Soar setMaxGroupByColsCount(int $maxGroupByColsCount)
 * @method \Guanguans\SoarPHP\Soar setMaxInCount(int $maxInCount)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexBytes(int $maxIndexBytes)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexBytesPercolumn(int $maxIndexBytesPercolumn)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexColsCount(int $maxIndexColsCount)
 * @method \Guanguans\SoarPHP\Soar setMaxIndexCount(int $maxIndexCount)
 * @method \Guanguans\SoarPHP\Soar setMaxJoinTableCount(int $maxJoinTableCount)
 * @method \Guanguans\SoarPHP\Soar setMaxPrettySqlLength(int $maxPrettySqlLength)
 * @method \Guanguans\SoarPHP\Soar setMaxQueryCost(int $maxQueryCost)
 * @method \Guanguans\SoarPHP\Soar setMaxSubqueryDepth(int $maxSubqueryDepth)
 * @method \Guanguans\SoarPHP\Soar setMaxTextColsCount(int $maxTextColsCount)
 * @method \Guanguans\SoarPHP\Soar setMaxTotalRows(int $maxTotalRows)
 * @method \Guanguans\SoarPHP\Soar setMaxValueCount(int $maxValueCount)
 * @method \Guanguans\SoarPHP\Soar setMaxVarcharLength(int $maxVarcharLength)
 * @method \Guanguans\SoarPHP\Soar setMinCardinality(float $minCardinality)
 * @method \Guanguans\SoarPHP\Soar setOnlineDsn(string $onlineDsn)
 * @method \Guanguans\SoarPHP\Soar setOnlySyntaxCheck($onlySyntaxCheck)
 * @method \Guanguans\SoarPHP\Soar setPrintConfig($printConfig)
 * @method \Guanguans\SoarPHP\Soar setProfiling($profiling)
 * @method \Guanguans\SoarPHP\Soar setQuery(string $query)
 * @method \Guanguans\SoarPHP\Soar setReportCss(string $reportCss)
 * @method \Guanguans\SoarPHP\Soar setReportJavascript(string $reportJavascript)
 * @method \Guanguans\SoarPHP\Soar setReportTitle(string $reportTitle)
 * @method \Guanguans\SoarPHP\Soar setReportType(string $reportType)
 * @method \Guanguans\SoarPHP\Soar setRewriteRules(string $rewriteRules)
 * @method \Guanguans\SoarPHP\Soar setSampling($sampling)
 * @method \Guanguans\SoarPHP\Soar setSamplingCondition(string $samplingCondition)
 * @method \Guanguans\SoarPHP\Soar setSamplingStatisticTarget(int $samplingStatisticTarget)
 * @method \Guanguans\SoarPHP\Soar setShowLastQueryCost($showLastQueryCost)
 * @method \Guanguans\SoarPHP\Soar setShowWarnings($showWarnings)
 * @method \Guanguans\SoarPHP\Soar setSpaghettiQueryLength(int $spaghettiQueryLength)
 * @method \Guanguans\SoarPHP\Soar setTestDsn(string $testDsn)
 * @method \Guanguans\SoarPHP\Soar setTrace($trace)
 * @method \Guanguans\SoarPHP\Soar setUniqueKeyPrefix(string $uniqueKeyPrefix)
 * @method \Guanguans\SoarPHP\Soar setVerbose($verbose)
 * @method \Guanguans\SoarPHP\Soar setVersion($version)
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
    protected $normalizedOptions = [];

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
