<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
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
    Soar::create()->foo();
})->group(__DIR__, __FILE__)->throws(BadMethodCallException::class, 'foo');

it('can call option methods via magic method __call', function (): void {
    expect(Soar::create([]))
        ->setVersion(true)->getOption('-version')->toBeTrue()
        ->withVersion(false)->getOption('-version')->toBeFalse()
        ->withVerbose(true)->onlyVersion()->getOptions()->toHaveKey('-version')->not->toHaveKey('-verbose')
        ->exceptVersion()->getOptions()->not->toHaveKey('-version');
})->group(__DIR__, __FILE__);

it('can flush options', function (): void {
    expect(Soar::create(['foo' => 'bar']))->flushOptions()->getOptions()->toBeEmpty();
})->group(__DIR__, __FILE__);

it('can only dsn', function (): void {
    expect(Soar::create([
        $name1 = '-test-dsn' => 'bar',
        $name2 = '-foo' => 'bar',
    ]))
        ->onlyDsn()
        ->getOptions()
        ->toHaveKey($name1)
        ->not->toHaveKey($name2);
})->group(__DIR__, __FILE__);

it('can only option', function (): void {
    expect(Soar::create([
        $name1 = '-name1' => $val = 'val',
        $name2 = '-name2' => $val,
    ]))
        ->onlyOption($name1)
        ->getOptions()
        ->toHaveKey($name1)
        ->not->toHaveKey($name2);
})->group(__DIR__, __FILE__);

it('can except option', function (): void {
    expect(Soar::create([
        $name = '-foo' => 'bar',
    ]))
        ->exceptOption($name)
        ->getOptions()
        ->not->toHaveKey($name);
})->group(__DIR__, __FILE__);

it('can array access', function (): void {
    $soar = Soar::create();

    $soar[$name = '-foo'] = $val = 'bar';

    expect(isset($soar[$name]))->toBeTrue()
        ->and($soar[$name])->toBe($val);

    unset($soar[$name]);
    expect($soar)->getOption($name)->toBeNull();
})->group(__DIR__, __FILE__);

it('will throw InvalidOptionException when normalize invalid option', function (): void {
    Soar::create(['-foo' => (object) []])->run();
})->group(__DIR__, __FILE__)->throws(InvalidOptionException::class, 'object');

it('can normalize options', function (): void {
    expect(fn (): array => $this->getNormalizedOptions())
        ->call(Soar::create([
            '-report-type' => 'json',
            '-config' => null,
            '-log-level' => 3,
            '-allow-online-as-test' => false,
            '-explain' => new class {
                public function __invoke(): bool
                {
                    return true;
                }
            },
            '-explain-format' => new class {
                public function __toString(): string
                {
                    return 'traditional';
                }
            },
            '-allow-charsets' => [
                'utf8',
                'utf8mb4',
            ],
            '-test-dsn' => [
                'user' => '',
                'password' => '********',
                'net' => 'tcp',
                // 'addr' => '127.0.0.1:3306',
                'host' => '127.0.0.1',
                'port' => 3306,
                'schema' => 'information_schema',
                'charset' => 'utf8',
                'collation' => 'utf8mb4_general_ci',
                'loc' => 'UTC',
                'tls' => '',
                'server-public-key' => '',
                'max-allowed-packet' => 4194304,
                'params' => [
                    'charset' => 'utf8',
                ],
                'timeout' => '3s',
                'read-timeout' => '0s',
                'write-timeout' => '0s',
                'allow-native-passwords' => true,
                'allow-old-passwords' => false,
                'disable' => false,
            ],
            '-online-dsn' => [
                'user' => '',
                'password' => '********',
                'net' => 'tcp',
                'addr' => '127.0.0.1:3306',
                'schema' => 'information_schema',
                'charset' => 'utf8',
                'collation' => 'utf8mb4_general_ci',
                'loc' => 'UTC',
                'tls' => '',
                'server-public-key' => '',
                'max-allowed-packet' => 4194304,
                'params' => [
                    'charset' => 'utf8',
                ],
                'timeout' => '3s',
                'read-timeout' => '0s',
                'write-timeout' => '0s',
                'allow-native-passwords' => true,
                'allow-old-passwords' => false,
                'disable' => true,
            ],
        ]))
        ->toBeArray();
})->group(__DIR__, __FILE__);

it('will throw InvalidOptionException when normalize invalid dsn', function (): void {
    Soar::create([
        '-test-dsn' => [
            'user' => '',
            // 'password' => '********',
            'net' => 'tcp',
            'addr' => '127.0.0.1:3306',
            'host' => '127.0.0.1',
            'port' => 3306,
            'schema' => 'information_schema',
            'disable' => false,
        ],
    ])->run();
})->group(__DIR__, __FILE__)->throws(InvalidOptionException::class, 'The option [-test-dsn.password] is required.');
