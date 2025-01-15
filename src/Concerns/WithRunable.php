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
     * @param list<string>|string $withOptions
     *
     * @throws InvalidOptionException
     */
    public function run($withOptions = [], ?callable $callback = null): string
    {
        if (!\is_string($withOptions) && !\is_array($withOptions)) {
            throw new InvalidArgumentException(\sprintf('Invalid argument type(%s).', \gettype($withOptions)));
        }

        $process = $this->createProcess($withOptions);
        $process->run($callback);

        if (!$process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    /**
     * @param list<string>|string $withOptions
     *
     * @throws InvalidOptionException
     */
    protected function createProcess($withOptions = []): Process
    {
        $process = \is_string($withOptions)
            ? Process::fromShellCommandline("{$this->getEscapedSoarBinary()} {$this->getHydratedEscapedNormalizedOptions()} $withOptions")
            : new Process(array_merge([$this->soarBinary], $this->clone()->mergeOptions($withOptions)->getNormalizedOptions()));

        if ($this->shouldApplySudoPassword()) {
            $process = Process::fromShellCommandline(\sprintf(
                'echo %s | sudo -S %s',
                $this->getEscapedSudoPassword(),
                $process->getCommandLine()
            ));

            // $process->setInput($this->getSudoPassword());
        }

        if (\is_callable($this->processTapper)) {
            ($this->processTapper)($process);
        }

        return $process;
    }
}
