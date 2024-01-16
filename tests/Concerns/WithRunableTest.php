<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\SoarPHPTests\Concerns;

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Exceptions\ProcessFailedException;
use Guanguans\SoarPHP\Soar;
use Symfony\Component\Process\Process;

it('will throw an InvalidArgumentException when options is not string', function (): void {
    Soar::create()->run(true);
})
    ->group(__DIR__, __FILE__)
    ->throws(InvalidArgumentException::class, \gettype(true));

it('will throw an ProcessFailedException when query is not sql', function (): void {
    Soar::create()->setOnlySyntaxCheck(true)->setQuery('optionsOfError')->run();
})
    ->group(__DIR__, __FILE__)
    ->throws(ProcessFailedException::class, 'optionsOfError');

it('will throw an ProcessFailedException when sudo password is empty', function (): void {
    foreach ([
        'Password:Sorry, try again',
        'sudo: no password was provided',
        'sudo: 1 incorrect password attempt',
    ] as $fatalErrorMessage) {
        $this->expectExceptionMessage($fatalErrorMessage);
    }

    (new class() extends Soar {
        protected function shouldApplySudoPassword(): bool
        {
            return true;
        }
    })->setSudoPassword('foo')->setQuery('select bar;')->run();
})
    ->group(__DIR__, __FILE__)
    ->throws(ProcessFailedException::class, 'Password:Sorry, try again')
    ->skip('This test is skipped. Because run sudo command is not allowed in github actions.');

it('can run soar process with tapper', function (): void {
    expect(Soar::create())
        ->setProcessTapper(static function (Process $process): void {
            $process->setTimeout(30);
        })
        ->run(
            '-version',
            static function (string $type, string $data): void {
                /** @noinspection ForgottenDebugOutputInspection */
                /** @noinspection DebugFunctionUsageInspection */
                dump($type, $data);
            }
        )
        ->toBeString();
})->group(__DIR__, __FILE__);
