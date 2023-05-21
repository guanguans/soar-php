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
    public function run($withOptions = [], ?callable $processTapper = null, ?callable $callback = null): string
    {
        if (! \is_string($withOptions) && ! \is_array($withOptions)) {
            throw new InvalidArgumentException(sprintf('Invalid argument type(%s).', \gettype($withOptions)));
        }

        $process = $this->createProcess($withOptions, $processTapper);
        $process->run($callback);
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    /**
     * @param array|string $withOptions
     */
    protected function exec($withOptions = [], ?callable $processTapper = null, ?callable $callback = null): string
    {
        return $this->run($withOptions, $processTapper, $callback);
    }

    /**
     * @param array|string $withOptions
     */
    private function createProcess($withOptions = [], ?callable $processTapper = null): Process
    {
        $process = \is_string($withOptions)
            ? Process::fromShellCommandline("$this->soarPath {$this->getSerializedNormalizedOptions()} $withOptions")
            : new Process(array_merge([$this->soarPath], $this->clone()->mergeOptions($withOptions)->getNormalizedOptions()));

        return (static function (Process $process) use ($processTapper): Process {
            if (\is_callable($processTapper)) {
                $processTapper($process);
            }

            return $process;
        })($process);
    }
}
