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
use Guanguans\SoarPHP\Exceptions\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait WithRunable
{
    /**
     * @param array|string $withOptions
     */
    public function run($withOptions = []): string
    {
        return $this->exec($withOptions);
    }

    /**
     * @param array|string $withOptions
     * @param mixed        $input       The input as stream resource, scalar or \Traversable, or null for no input
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     * @throws \Guanguans\SoarPHP\Exceptions\ProcessFailedException
     */
    protected function exec($withOptions = [], string $cwd = null, array $env = null, $input = null, ?float $timeout = 60, ?callable $output = null): string
    {
        if (! \is_string($withOptions) && ! \is_array($withOptions)) {
            throw new InvalidArgumentException(sprintf('Invalid argument type(%s).', \gettype($withOptions)));
        }

        if (\is_string($withOptions)) {
            $process = Process::fromShellCommandline(
                "$this->soarPath {$this->getSerializedNormalizedOptions()} $withOptions",
                $cwd,
                $env,
                $input,
                $timeout
            );
        }

        if (\is_array($withOptions)) {
            $process = new Process(
                array_merge([$this->soarPath], $this->clone()->mergeOptions($withOptions)->getNormalizedOptions()),
                $cwd,
                $env,
                $input,
                $timeout
            );
        }

        $process->run($output);
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
