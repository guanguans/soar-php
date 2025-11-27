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

use Symfony\Component\Process\Process;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait WithRunable
{
    /** @var null|callable(Process):void */
    protected $tap;

    public function setTap(?callable $tap): self
    {
        $this->tap = $tap;

        return $this;
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    public function run(?callable $callback = null): string
    {
        return $this->toProcess()->mustRun($callback)->getOutput();
    }

    /**
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidOptionException
     */
    protected function toProcess(): Process
    {
        $normalizedOptions = $this->clone()->getNormalizedOptions();

        $process = $this->shouldApplySudoPassword()
            ? new Process(
                command: ['sudo', '-S', $this->soarBinary, ...$normalizedOptions],
                input: $this->getSudoPassword()
            )
            : new Process([$this->soarBinary, ...$normalizedOptions]);

        if (\is_callable($this->tap)) {
            ($this->tap)($process);
        }

        return $process;
    }
}
