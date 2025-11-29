<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection DebugFunctionUsageInspection */
/** @noinspection ForgottenDebugOutputInspection */
/** @noinspection PhpMissingParentCallCommonInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHP\Support\OsHelper;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

it('will throw ProcessFailedException when is a invalid query', function (): void {
    Soar::make()->withOnlySyntaxCheck(true)->withQuery('invalid query')->run();
})->group(__DIR__, __FILE__)->throws(ProcessFailedException::class, 'invalid query');

it('will throw ProcessFailedException when sudo password is error', function (): void {
    foreach (
        [
            'Password:Sorry, try again.',
            'Password:',
            'sudo: no password was provided',
            'sudo: 1 incorrect password attempt',
        ] as $message
    ) {
        $this->expectExceptionMessage($message);
    }

    (new class extends Soar {
        protected function shouldApplySudoPassword(): bool
        {
            return OsHelper::isUnix();
        }
    })->withSudoPassword('foo')->help();
})
    ->group(__DIR__, __FILE__)
    ->throws(ProcessFailedException::class, implode(\PHP_EOL, [
        'Password:Sorry, try again.',
        'Password:',
        'sudo: no password was provided',
        'sudo: 1 incorrect password attempt',
    ]))
    ->skipOnMac()
    ->skip(running_in_github_action());

it('can run soar process with pipe', function (): void {
    expect(Soar::make())
        ->withVersion(true)
        ->withPipe(function (Process $process): Process {
            expect($this)->toBeInstanceOf(Process::class);
            expect($this->commandline)->toBeArray();

            return $process->setTimeout(3);
        })
        ->run(static function (string $type, string $line): void {
            // dump($type, $line);
        })
        ->toBeString();
})->group(__DIR__, __FILE__);

it('can run soar process with tap', function (): void {
    expect(Soar::make())
        ->withVersion(true)
        ->withTap(function (Process $process): void {
            expect($this)->toBeInstanceOf(Process::class);
            expect($this->commandline)->toBeArray();

            $process->setTimeout(3);
        })
        ->run(static function (string $type, string $line): void {
            // dump($type, $line);
        })
        ->toBeString();
})->group(__DIR__, __FILE__);
