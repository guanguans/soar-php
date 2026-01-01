<?php

declare(strict_types=1);

/**
 * Copyright (c) 2019-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

namespace Guanguans\SoarPHP\Concerns;

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Support\OsHelper;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait HasBinary
{
    protected string $binary;

    public function getBinary(): string
    {
        return $this->binary;
    }

    public function withBinary(string $binary): self
    {
        if (!is_file($binary)) {
            throw new InvalidArgumentException("The [$binary] is not a file.");
        }

        if (!is_executable($binary)) {
            throw new InvalidArgumentException("The file [$binary] is not executable.");
        }

        $this->binary = realpath($binary);

        return $this;
    }

    public function defaultBinary(): string
    {
        if (OsHelper::isWindows()) {
            return __DIR__.'/../../bin/soar.windows-amd64';
        }

        if (OsHelper::isMacOS()) {
            return OsHelper::isArm() ? __DIR__.'/../../bin/soar.darwin-arm64' : __DIR__.'/../../bin/soar.darwin-amd64';
        }

        return OsHelper::isArm() ? __DIR__.'/../../bin/soar.linux-arm64' : __DIR__.'/../../bin/soar.linux-amd64';
    }
}
