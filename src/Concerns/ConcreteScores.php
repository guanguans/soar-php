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
     * @param list<string>|string $sqls
     * @param int<1, 512> $depth
     * @param int<0, 4194304> $options
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function arrayScores(array|string $sqls, int $depth = 512, int $options = 0): array
    {
        /** @noinspection JsonEncodingApiUsageInspection */
        return (array) json_decode($this->jsonScores($sqls), true, $depth, $options);
    }

    /**
     * @param list<string>|string $sqls
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function jsonScores(array|string $sqls): string
    {
        return $this->setReportType('json')->scores($sqls);
    }

    /**
     * @param list<string>|string $sqls
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function htmlScores(array|string $sqls): string
    {
        return $this->setReportType('html')->scores($sqls);
    }

    /**
     * @param list<string>|string $sqls
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function markdownScores(array|string $sqls): string
    {
        return $this->setReportType('markdown')->scores($sqls);
    }

    /**
     * @param list<string>|string $sqls
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function scores(array|string $sqls): string
    {
        if (\is_array($sqls)) {
            $sqls = implode($this->getDelimiter(';'), $sqls);
        }

        return $this->clone()->setQuery($sqls)->run();
    }
}
