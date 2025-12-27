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

namespace Guanguans\SoarPHP;

use Guanguans\SoarPHP\Concerns\ConcreteMagic;
use Guanguans\SoarPHP\Concerns\ConcreteScores;
use Guanguans\SoarPHP\Concerns\HasBinary;
use Guanguans\SoarPHP\Concerns\HasOptions;
use Guanguans\SoarPHP\Concerns\HasSudoPassword;
use Guanguans\SoarPHP\Concerns\Makeable;
use Guanguans\SoarPHP\Concerns\WithDumpable;
use Guanguans\SoarPHP\Concerns\WithRunable;
use Symfony\Component\Process\Process;

class Soar implements \ArrayAccess, \Stringable, Contracts\Soar
{
    use ConcreteMagic;
    use ConcreteScores;
    use HasBinary;
    use HasOptions;
    use HasSudoPassword;
    use Makeable;
    use WithDumpable;
    use WithRunable;

    public function __construct(array $options = [], ?string $binary = null)
    {
        $this->setOptions($options);
        $this->withBinary($binary ?? $this->defaultBinary());
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function help(?callable $callback = null): string
    {
        return $this->clone()->setHelp(true)->run(
            static function (string $type, string $line) use (&$errorOutput, $callback): void {
                Process::ERR === $type and $errorOutput .= $line;
                $callback and $callback($type, $line);
            }
        ) ?: $errorOutput;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function version(?callable $callback = null): string
    {
        return $this->clone()->setVersion(true)->run($callback);
    }

    public function clone(): self
    {
        return clone $this;
    }
}
