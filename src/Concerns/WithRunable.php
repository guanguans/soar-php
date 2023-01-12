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
     * @param array|string|null $options
     */
    public function run($options = null): string
    {
        return $this->exec($options);
    }

    /**
     * @param array|string|null $options
     * @param mixed             $input   The input as stream resource, scalar or \Traversable, or null for no input
     *
     * @throws \Guanguans\SoarPHP\Exceptions\InvalidArgumentException
     * @throws \Guanguans\SoarPHP\Exceptions\ProcessFailedException
     */
    public function exec($options = null, string $cwd = null, array $env = null, $input = null, ?float $timeout = 60, ?callable $output = null): string
    {
        if (null !== $options && ! is_string($options) && ! is_array($options)) {
            throw new InvalidArgumentException(sprintf('Invalid argument type(%s).', gettype($options)));
        }

        if (null === $options) {
            $process = new Process(array_merge([$this->soarPath], $this->getNormalizedOptions()), $cwd, $env, $input, $timeout);
        }

        if (is_string($options)) {
            $process = Process::fromShellCommandline("$this->soarPath $options", $cwd, $env, $input, $timeout);
        }

        if (is_array($options)) {
            $process = new Process(array_merge([$this->soarPath], $options), $cwd, $env, $input, $timeout);
        }

        $process->run($output);
        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}