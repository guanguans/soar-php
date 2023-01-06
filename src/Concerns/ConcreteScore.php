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
    public function jsonScore(string $sql): string
    {
        return $this->setOption('-report-type', 'json')->score($sql);
    }

    public function arrayScore(string $sql, int $depth = 512, int $options = 0): array
    {
        return (array) json_decode($this->jsonScore($sql), true, $depth, $options);
    }

    public function htmlScore(string $sql): string
    {
        return $this->setOption('-report-type', 'html')->score($sql);
    }

    public function mdScore(string $sql): string
    {
        return $this->setOption('-report-type', 'markdown')->score($sql);
    }
}
