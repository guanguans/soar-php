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

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait ConcreteScores
{
    /**
     * @param list<string>|string $queries
     * @param int<1, 512> $depth
     * @param int<0, 4194304> $options
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     * @throws \JsonException
     *
     * @return list<array<string, mixed>>
     */
    public function arrayScores(array|string $queries, int $depth = 512, int $options = 0): array
    {
        return json_decode($this->jsonScores($queries), true, $depth, $options | \JSON_THROW_ON_ERROR);
    }

    /**
     * @param list<string>|string $queries
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function jsonScores(array|string $queries): string
    {
        return $this->withReportType('json')->scores($queries);
    }

    /**
     * @param list<string>|string $queries
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function htmlScores(array|string $queries): string
    {
        return $this->withReportType('html')->scores($queries);
    }

    /**
     * @param list<string>|string $queries
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function markdownScores(array|string $queries): string
    {
        return $this->withReportType('markdown')->scores($queries);
    }

    /**
     * @param list<string>|string $queries
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function scores(array|string $queries, ?callable $callback = null): string
    {
        if (\is_array($queries)) {
            $queries = implode($this->getDelimiter(';'), $queries);
        }

        return $this->clone()->withQuery($queries)->run($callback);
    }
}
