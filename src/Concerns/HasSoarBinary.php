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

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Support\OS;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait HasSoarBinary
{
    /** @var string */
    protected $soarBinary;

    public function getSoarBinary(): string
    {
        return $this->soarBinary;
    }

    public function setSoarBinary(string $soarBinary): self
    {
        if (! file_exists($soarBinary) || ! is_executable($soarBinary)) {
            throw new InvalidArgumentException("The file($soarBinary) does not exist or cannot executable.");
        }

        $this->soarBinary = realpath($soarBinary);

        return $this;
    }

    protected function getEscapedSoarBinary(): string
    {
        return escape_argument($this->soarBinary);
    }

    protected function getDefaultSoarBinary(): string
    {
        if (OS::isWindows()) {
            return __DIR__.'/../../bin/soar.windows-amd64'; // @codeCoverageIgnore
        }

        if (OS::isMacOS()) {
            return OS::isArm() ? __DIR__.'/../../bin/soar.darwin-arm64' : __DIR__.'/../../bin/soar.darwin-amd64';
        }

        return OS::isArm() ? __DIR__.'/../../bin/soar.linux-arm64' : __DIR__.'/../../bin/soar.linux-amd64'; // @codeCoverageIgnore
    }
}
