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
use Guanguans\SoarPHP\Support\OsHelper;
use Symfony\Component\Process\Process;

trait WithRunable
{
    /**
     * @param array|string|null $command
     */
    public function mustRun($command = null, string $cwd = null, array $env = null, $input = null, ?float $timeout = 60, ?callable $output = null): string
    {
        return $this->exec($command, $cwd, $env, $input, $timeout, true, $output);
    }

    /**
     * @param array|string|null $command
     */
    public function run($command = null, string $cwd = null, array $env = null, $input = null, ?float $timeout = 60, ?callable $output = null): string
    {
        return $this->exec($command, $cwd, $env, $input, $timeout, false, $output);
    }

    /**
     * @param array|string|null $command
     */
    private function exec($command = null, string $cwd = null, array $env = null, $input = null, ?float $timeout = 60, bool $mustRun = true, ?callable $output = null): string
    {
        // OsHelper::isWindows() and $command = "powershell $command";
        if (null !== $command && ! is_string($command) && ! is_array($command)) {
            throw new InvalidArgumentException(sprintf('Invalid argument type(%s).', gettype($command)));
        }

        if (null === $command) {
            $process = new Process(array_merge([$this->soarPath], $this->normalizedOptions), $cwd, $env, $input, $timeout);
        }

        if (is_string($command)) {
            $process = Process::fromShellCommandline("$this->soarPath $command", $cwd, $env, $input, $timeout);
        }

        if (is_array($command)) {
            $process = new Process(array_merge([$this->soarPath], $command), $cwd, $env, $input, $timeout);
        }

        $process->run($output);
        if ($mustRun && ! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }
}
