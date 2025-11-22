<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection DebugFunctionUsageInspection */
/** @noinspection ForgottenDebugOutputInspection */
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
use Guanguans\SoarPHP\Support\OS;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Symfony\Component\Process\Process;

it('will throw ProcessFailedException when is a invalid sql', function (): void {
    Soar::make()->withOnlySyntaxCheck(true)->withQuery('invalid sql')->run();
})->group(__DIR__, __FILE__)->throws(ProcessFailedException::class, 'invalid sql');

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
            return OS::isUnix();
        }
    })->setSudoPassword('foo')->help();
})
    ->group(__DIR__, __FILE__)
    ->throws(ProcessFailedException::class, implode(\PHP_EOL, [
        'Password:Sorry, try again.',
        'Password:',
        'sudo: no password was provided',
        'sudo: 1 incorrect password attempt',
    ]))
    ->skip()
    ->skip(running_in_github_action());

it('can run soar process with tapper', function (): void {
    expect(Soar::make())
        ->withVersion(true)
        ->setProcessTapper(static function (Process $process): void {
            $process->setTimeout(3);
        })
        ->run(static function (string $type, string $line): void {
            dump($type, $line);
        })
        ->toBeString();
})->group(__DIR__, __FILE__);
