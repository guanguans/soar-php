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
trait HasSoarPath
{
    /**
     * @var string
     */
    protected $soarPath;

    public function getSoarPath(): string
    {
        return $this->soarPath;
    }

    public function setSoarPath(string $soarPath): self
    {
        if (! file_exists($soarPath) || ! is_executable($soarPath)) {
            throw new InvalidArgumentException("The file($soarPath) does not exist or cannot executable.");
        }

        $this->soarPath = realpath($soarPath);

        return $this;
    }

    private function getDefaultSoarPath(): string
    {
        if (OS::isWindows()) {
            return __DIR__.'/../../bin/soar.windows-amd64';
        }

        if (OS::isMacOS()) {
            if (OS::isArm()) {
                return __DIR__.'/../../bin/soar.darwin-arm64';
            }

            return __DIR__.'/../../bin/soar.darwin-amd64';
        }

        return __DIR__.'/../../bin/soar.linux-amd64';
    }
}