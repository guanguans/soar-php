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

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait ConcreteScores
{
    /**
     * @param string|array<string> $sqls
     */
    public function arrayScores($sqls, int $depth = 512, int $options = 0): array
    {
        return (array) json_decode($this->jsonScores($sqls), true, $depth, $options);
    }

    /**
     * @param string|array<string> $sqls
     */
    public function jsonScores($sqls): string
    {
        return $this->setReportType('json')->scores($sqls);
    }

    /**
     * @param string|array<string> $sqls
     */
    public function htmlScores($sqls): string
    {
        return $this->setReportType('html')->scores($sqls);
    }

    /**
     * @param string|array<string> $sqls
     */
    public function markdownScores($sqls): string
    {
        return $this->setReportType('markdown')->scores($sqls);
    }
}
