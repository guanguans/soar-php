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
trait ConcreteExplain
{
    public function mdExplain(string $sql): string
    {
        return $this->explain($sql);
    }

    public function htmlExplain(string $sql): string
    {
        return $this->md2html($this->explain($sql));
    }
}
