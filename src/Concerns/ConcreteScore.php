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
trait ConcreteScore
{
    public function arrayScore(string $sql, int $depth = 512, int $options = 0): array
    {
        return (array) json_decode($this->jsonScore($sql), true, $depth, $options);
    }

    public function jsonScore(string $sql): string
    {
        return $this->setReportType('json')->score($sql);
    }

    public function htmlScore(string $sql): string
    {
        return $this->setReportType('html')->score($sql);
    }

    public function markdownScore(string $sql): string
    {
        return $this->setReportType('markdown')->score($sql);
    }
}
