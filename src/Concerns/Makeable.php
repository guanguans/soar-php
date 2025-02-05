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

trait Makeable
{
    public static function create(...$parameters): self
    {
        return static::make(...$parameters);
    }

    public static function make(...$parameters): self
    {
        return new static(...$parameters);
    }
}
