<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUndefinedClassInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection PhpVoidFunctionResultUsedInspection */
/** @noinspection SqlResolve */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection NestedAssignmentsUsageInspection */
declare(strict_types=1);

/**
 * Copyright (c) 2019-2026 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

use Guanguans\SoarPHP\Exceptions\BadMethodCallException;
use Guanguans\SoarPHP\Exceptions\InvalidOptionException;
use Guanguans\SoarPHP\Soar;

it('will throw BadMethodCallException when call not exist method', function (): void {
    /** @noinspection PhpUndefinedMethodInspection */
    Soar::make()->foo();
})->group(__DIR__, __FILE__)->throws(BadMethodCallException::class, 'foo');

it('can call option methods via magic method __call', function (): void {
    expect(Soar::make([]))
        ->setVersion(true)->getOption('-version')->toBeTrue()
        ->withVersion(false)->getOption('-version')->toBeFalse()
        ->withVerbose(true)->onlyVersion()->getOptions()->toHaveKey('-version')->not->toHaveKey('-verbose')
        ->exceptVersion()->getOptions()->not->toHaveKey('-version');
})->group(__DIR__, __FILE__);

it('can flush options', function (): void {
    expect(Soar::make(['foo' => 'bar']))->flushOptions()->getOptions()->toBeEmpty();
})->group(__DIR__, __FILE__);

it('can only dsn', function (): void {
    expect(Soar::make([
        $name1 = '-test-dsn' => 'bar',
        $name2 = '-foo' => 'bar',
    ]))
        ->onlyDsn()
        ->getOptions()
        ->toHaveKey($name1)
        ->not->toHaveKey($name2);
})->group(__DIR__, __FILE__);

it('can only option', function (): void {
    expect(Soar::make([
        $name1 = '-name1' => $val = 'val',
        $name2 = '-name2' => $val,
    ]))
        ->onlyOption($name1)
        ->getOptions()
        ->toHaveKey($name1)
        ->not->toHaveKey($name2);
})->group(__DIR__, __FILE__);

it('can except option', function (): void {
    expect(Soar::make([
        $name = '-foo' => 'bar',
    ]))
        ->exceptOption($name)
        ->getOptions()
        ->not->toHaveKey($name);
})->group(__DIR__, __FILE__);

it('can array access', function (): void {
    $soar = Soar::make();

    $soar[$name = '-foo'] = $val = 'bar';

    expect(isset($soar[$name]))->toBeTrue()
        ->and($soar[$name])->toBe($val);

    unset($soar[$name]);
    expect($soar)->getOption($name)->toBeNull();
})->group(__DIR__, __FILE__);

it('will throw InvalidOptionException when normalize invalid option', function (): void {
    Soar::make(['-foo' => (object) []])->run();
})->group(__DIR__, __FILE__)->throws(InvalidOptionException::class, 'object');

it('can normalize options', function (): void {
    $normalizedOptions = (fn (): array => $this->getNormalizedOptions())->call(Soar::make([
        ... require __DIR__.'/../../examples/options.php',
        '-explain-format' => new class {
            public function __invoke(): string
            {
                return 'traditional';
            }
        },
        '-explain-type' => new class implements Stringable {
            public function __toString(): string
            {
                return 'extended';
            }
        },
        '-test-dsn' => [
            'user' => 'you_user',
            'password' => 'you_password',
            // 'addr' => '127.0.0.1:3306',
            'host' => 'you_host',
            'port' => 'you_port',
            'schema' => 'you_dbname',
            'disable' => false,
        ],
    ]));

    expect($normalizedOptions)->toMatchSnapshot()->each->toBeString();
})->group(__DIR__, __FILE__);

it('will throw InvalidOptionException when normalize invalid dsn', function (): void {
    Soar::make([
        '-test-dsn' => [
            'user' => 'you_user',
            // 'password' => 'you_password',
            // 'addr' => '127.0.0.1:3306',
            'host' => 'you_host',
            'port' => 'you_port',
            'schema' => 'you_dbname',
            'disable' => false,
        ],
    ])->run();
})->group(__DIR__, __FILE__)->throws(InvalidOptionException::class, 'The option [-test-dsn.password] is required.');
