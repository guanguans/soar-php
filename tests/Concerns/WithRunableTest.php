<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests\Concerns;

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Exceptions\ProcessFailedException;
use Guanguans\SoarPHP\Soar;
use Guanguans\Tests\TestCase;
use Symfony\Component\Process\Process;

/**
 * @internal
 *
 * @small
 */
class WithRunableTest extends TestCase
{
    public function testInvalidArgumentExceptionForRun(): void
    {
        $soar = Soar::create();
        $optionsOfError = true;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(\gettype($optionsOfError));
        $soar->run($optionsOfError);
    }

    public function testProcessFailedExceptionForRun(): void
    {
        $soar = Soar::create();
        $optionsOfError = 'optionsOfError';

        $this->expectException(ProcessFailedException::class);
        $this->expectExceptionMessage($optionsOfError);
        $soar->setOnlySyntaxCheck(true)->setQuery($optionsOfError)->run();
    }

    /**
     * @noinspection PhpUnreachableStatementInspection
     */
    public function testMisuseOfShellBuiltinsProcessFailedExceptionForRun(): void
    {
        $this->markTestSkipped(
            __METHOD__.'is skipped. Because run sudo command is not allowed in github actions.'
        );

        $soar = new class() extends Soar {
            protected function shouldApplySudoPassword(): bool
            {
                return true;
            }
        };
        $fatalErrorMessages = [
            'Password:Sorry, try again',
            'sudo: no password was provided',
            'sudo: 1 incorrect password attempt',
        ];

        $this->expectException(ProcessFailedException::class);
        foreach ($fatalErrorMessages as $fatalErrorMessage) {
            $this->expectExceptionMessage($fatalErrorMessage);
        }

        $soar->setSudoPassword('foo')->setQuery('select bar;')->run();
    }

    /**
     * @noinspection ForgottenDebugOutputInspection
     * @noinspection DebugFunctionUsageInspection
     */
    public function testRun(): void
    {
        $soar = Soar::create();
        $run = $soar->run(
            '-version',
            static function (Process $process): void {
                $process->setTimeout(30);
            },
            static function (string $type, string $data): void {
                dump($type, $data);
            }
        );

        $this->assertIsString($run);
    }

    public function testExec(): void
    {
        $soar = Soar::create();
        $exec = (function (Soar $soar): string {
            return $soar->exec('-version');
        })->call($soar, $soar);

        $this->assertIsString($exec);
    }
}
