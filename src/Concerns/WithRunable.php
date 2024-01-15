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
    /** @var null|callable */
    protected $processTapper;

    public function setProcessTapper(?callable $processTapper): self
    {
        $this->processTapper = $processTapper;

        return $this;
    }

    /**
     * @param array|string $withOptions
     *
     * @throws InvalidOptionException
     */
    public function run($withOptions = [], ?callable $callback = null): string
    {
        if (! \is_string($withOptions) && ! \is_array($withOptions)) {
            throw new InvalidArgumentException(sprintf('Invalid argument type(%s).', \gettype($withOptions)));
        }

        $process = $this->createProcess($withOptions);
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
     */
    private function createProcess($withOptions = []): Process
    {
        $process = \is_string($withOptions)
            ? Process::fromShellCommandline("{$this->getEscapedSoarBinary()} {$this->getHydratedEscapedNormalizedOptions()} $withOptions")
            : new Process(array_merge([$this->soarBinary], $this->clone()->mergeOptions($withOptions)->getNormalizedOptions()));

        if ($this->shouldApplySudoPassword()) {
            $process = Process::fromShellCommandline(sprintf(
                'echo %s | sudo -S %s',
                $this->getEscapedSudoPassword(),
                $process->getCommandLine()
            ));
        }

        if (\is_callable($this->processTapper)) {
            ($this->processTapper)($process);
        }

        return $process;
    }
}
