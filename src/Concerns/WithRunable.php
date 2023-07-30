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
use Guanguans\SoarPHP\Exceptions\InvalidOptionException;
use Guanguans\SoarPHP\Exceptions\ProcessFailedException;
use Symfony\Component\Process\Process;

/**
 * @mixin \Guanguans\SoarPHP\Soar
 */
trait WithRunable
{
    /**
     * @param array|string $withOptions
     *
     * @throws InvalidOptionException
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
     *
     * @throws InvalidOptionException
     *
     * @deprecated The method is deprecated and will be removed in version 4.0.
     *             Please use the {@see run} instead.
     */
    protected function exec($withOptions = [], ?callable $processTapper = null, ?callable $callback = null): string
    {
        @trigger_error(
            sprintf(
                'Since guanguans/soar-php 3.0: The "%s" method is deprecated and will be removed in version 4.0. Please use the "run" method instead.',
                __METHOD__
            ),
            E_USER_DEPRECATED
        );

        return $this->run($withOptions, $processTapper, $callback);
    }

    /**
     * @param array|string $withOptions
     *
     * @throws InvalidOptionException
     */
    private function createProcess($withOptions = [], ?callable $processTapper = null): Process
    {
        $process = \is_string($withOptions)
            ? Process::fromShellCommandline("{$this->getEscapedSoarPath()} {$this->getHydratedEscapedNormalizedOptions()} $withOptions")
            : new Process(array_merge([$this->soarPath], $this->clone()->mergeOptions($withOptions)->getNormalizedOptions()));

        if ($this->shouldApplySudoPassword()) {
            $process = Process::fromShellCommandline(sprintf(
                'echo %s | sudo -S %s',
                $this->getEscapedSudoPassword(),
                $process->getCommandLine()
            ));
        }

        if (\is_callable($processTapper)) {
            $processTapper($process);
        }

        return $process;
    }
}
