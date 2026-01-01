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

use Symfony\Component\Process\Process;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait WithRunable
{
    /** @var null|\Closure(Process): Process */
    protected ?\Closure $pipe = null;

    /** @var null|\Closure(Process): void */
    protected ?\Closure $tap = null;

    public function withPipe(?\Closure $pipe): self
    {
        $this->pipe = $pipe;

        return $this;
    }

    public function withTap(?\Closure $tap): self
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
        $command = [$this->binary, ...$this->clone()->getNormalizedOptions()];

        $process = $this->shouldApplySudoPassword()
            ? new Process(command: ['sudo', '-S', ...$command], input: $this->getSudoPassword())
            : new Process($command);

        if ($this->tap instanceof \Closure) {
            $this->tap->call($process, $process);
        }

        return $this->pipe instanceof \Closure ? $this->pipe->call($process, $process) : $process;
    }
}
