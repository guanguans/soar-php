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
    public function arrayScores(string $sql, int $depth = 512, int $options = 0): array
    {
        return (array) json_decode($this->jsonScores($sql), true, $depth, $options);
    }

    public function jsonScores(string $sql): string
    {
        return $this->setReportType('json')->scores($sql);
    }

    public function htmlScores(string $sql): string
    {
        return $this->setReportType('html')->scores($sql);
    }

    public function markdownScores(string $sql): string
    {
        return $this->setReportType('markdown')->scores($sql);
    }
}
