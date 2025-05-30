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
use Guanguans\SoarPHP\Support\OS;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait HasSoarBinary
{
    protected string $soarBinary;

    public function getSoarBinary(): string
    {
        return $this->soarBinary;
    }

    public function setSoarBinary(string $soarBinary): self
    {
        if (!is_file($soarBinary)) {
            throw new InvalidArgumentException("The [$soarBinary] is not a file.");
        }

        if (!is_executable($soarBinary)) {
            throw new InvalidArgumentException("The file [$soarBinary] is not executable.");
        }

        $this->soarBinary = realpath($soarBinary);

        return $this;
    }

    public function defaultSoarBinary(): string
    {
        if (OS::isWindows()) {
            return __DIR__.'/../../bin/soar.windows-amd64';
        }

        if (OS::isMacOS()) {
            return OS::isArm() ? __DIR__.'/../../bin/soar.darwin-arm64' : __DIR__.'/../../bin/soar.darwin-amd64';
        }

        return OS::isArm() ? __DIR__.'/../../bin/soar.linux-arm64' : __DIR__.'/../../bin/soar.linux-amd64';
    }
}
