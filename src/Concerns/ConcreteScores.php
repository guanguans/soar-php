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

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Exceptions\InvalidOptionException;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait ConcreteScores
{
    /**
     * @param list<string>|string $sqls
     *
     * @throws InvalidOptionException
     */
    public function arrayScores($sqls, int $depth = 512, int $options = 0): array
    {
        /** @noinspection JsonEncodingApiUsageInspection */
        return (array) json_decode($this->jsonScores($sqls), true, $depth, $options);
    }

    /**
     * @param list<string>|string $sqls
     *
     * @throws InvalidOptionException
     */
    public function jsonScores($sqls): string
    {
        return $this->setReportType('json')->scores($sqls);
    }

    /**
     * @param list<string>|string $sqls
     *
     * @throws InvalidOptionException
     */
    public function htmlScores($sqls): string
    {
        return $this->setReportType('html')->scores($sqls);
    }

    /**
     * @param list<string>|string $sqls
     *
     * @throws InvalidOptionException
     */
    public function markdownScores($sqls): string
    {
        return $this->setReportType('markdown')->scores($sqls);
    }

    /**
     * @param list<string>|string $sqls
     *
     * @throws InvalidOptionException
     */
    public function scores($sqls): string
    {
        if (!\is_string($sqls) && !\is_array($sqls)) {
            throw new InvalidArgumentException(\sprintf('Invalid argument type(%s).', \gettype($sqls)));
        }

        if (\is_array($sqls)) {
            $sqls = implode($this->getDelimiter(';'), $sqls);
        }

        return $this->clone()->setQuery($sqls)->run();
    }
}
