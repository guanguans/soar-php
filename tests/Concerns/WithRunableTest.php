<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUnhandledExceptionInspection */
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

namespace Guanguans\SoarPHPTests\Concerns;

use Guanguans\SoarPHP\Exceptions\ProcessFailedException;
use Guanguans\SoarPHP\Soar;
use Symfony\Component\Process\Process;

it('will throw ProcessFailedException when sqls is invalid sql', function (): void {
    Soar::create()->setOnlySyntaxCheck(true)->setQuery('invalid sql')->run();
})
    ->group(__DIR__, __FILE__)
    ->throws(ProcessFailedException::class, 'invalid sql');

it('will throw ProcessFailedException when sudo password is empty', function (): void {
    foreach ([
        'Password:Sorry, try again',
        'sudo: no password was provided',
        'sudo: 1 incorrect password attempt',
    ] as $fatalErrorMessage) {
        $this->expectExceptionMessage($fatalErrorMessage);
    }

    (new class extends Soar {
        protected function shouldApplySudoPassword(): bool
        {
            return true;
        }
    })->setSudoPassword('foo')->setQuery('select bar;')->run();
})
    ->group(__DIR__, __FILE__)
    ->throws(
        ProcessFailedException::class,
        'Password:Sorry, try again * sudo: no password was provided * sudo: 1 incorrect password attempt'
    )
    ->skip('This test is skipped. Because is not supported in github actions.');

it('can run soar process with tapper', function (): void {
    expect(Soar::create())
        ->setProcessTapper(static function (Process $process): void {
            $process->setTimeout(30);
        })
        ->run(
            '-version',
            static function (string $type, string $data): void {
                dump($type, $data);
            }
        )
        ->toBeString();
})->group(__DIR__, __FILE__);
