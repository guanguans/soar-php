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

trait ConcreteScore
{
    public function jsonScore(string $sql)
    {
        /* @var \Guanguans\SoarPHP\Soar $this */
        return $this->setOption('-report-type', 'json')->score($sql);
    }

    public function arrayScore(string $sql)
    {
        /* @var \Guanguans\SoarPHP\Soar $this */
        return json_decode($this->jsonScore($sql), true);
    }

    public function htmlScore(string $sql)
    {
        /* @var \Guanguans\SoarPHP\Soar $this */
        return $this->setOption('-report-type', 'html')->score($sql);
    }

    public function mdScore(string $sql)
    {
        /* @var \Guanguans\SoarPHP\Soar$this */
        return $this->setOption('-report-type', 'markdown')->score($sql);
    }
}
