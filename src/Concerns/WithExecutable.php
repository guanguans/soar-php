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

use Guanguans\SoarPHP\Exceptions\ProcessFailedException;
use Guanguans\SoarPHP\Support\OsHelper;
use Symfony\Component\Process\Process;

trait WithExecutable
{
    public function exec(string $command): string
    {
        // OsHelper::isWindows() and $command = "powershell $command";
        return $this->mustRunProcess(Process::fromShellCommandline($command));
    }

    protected function mustRun(array $command, string $cwd = null, array $env = null, $input = null, ?float $timeout = 60, ?callable $output = null): string
    {
        return $this->mustRunProcess(new Process($command, $cwd, $env, $input, $timeout), $output);
    }

    protected function run(array $command, string $cwd = null, array $env = null, $input = null, ?float $timeout = 60, ?callable $output = null): string
    {
        return $this->runProcess(new Process($command, $cwd, $env, $input, $timeout), $output);
    }

    private function mustRunProcess(Process $process, ?callable $output = null): string
    {
        $process->run($output);

        if (! $process->isSuccessful()) {
            throw new ProcessFailedException($process);
        }

        return $process->getOutput();
    }

    private function runProcess(Process $process, ?callable $output = null): string
    {
        $process->run($output);

        return $process->getOutput();
    }
}
