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

it('can add option', function (): void {
    expect(Soar::create())
        ->addOption($name = 'foo', $val = 'bar')
        ->getOption($name)->toBe($val)
        ->addOption($name, $name)
        ->getOption($name)->toBe($val);
})->group(__DIR__, __FILE__)->skip();

it('can remove option', function (): void {
    expect(Soar::create([$name = 'foo' => $val = 'bar']))
        ->getOption($name)->toBe($val)
        ->exceptOption($name)->getOption($name)->toBeNull();
})->group(__DIR__, __FILE__);

it('can only option', function (): void {
    expect(Soar::create([
        $name1 = 'key1' => $val = 'val',
        $name2 = 'key2' => $val,
    ]))
        ->onlyOption($name1)
        ->getOption($name1)->toBe($val)
        ->getOption($name2)->toBeNull();
})->group(__DIR__, __FILE__);

it('can only dsn', function (): void {
    expect(Soar::create([
        $name1 = '-test-dsn' => $val = 'val',
        $name2 = 'key2' => $val,
    ]))
        ->onlyDsns()
        ->getOption($name1)->toBe($val)
        ->getOption($name2)->toBeNull();
})->group(__DIR__, __FILE__);

it('can set option', function (): void {
    expect(Soar::create())
        ->setOption($name = 'foo', $str = 'bar')->getOption($name)->toBe($str)
        ->setOption(
            $name = '-online-dsn',
            $arr = [
                'host' => '192.168.10.10',
                'port' => '3306',
                'dbname' => 'laravel',
                'username' => 'homestead',
                'password' => 'secret',
                'disable' => false,
                'options' => [],
            ]
        )->getOption($name)->toBe($arr)
        ->setOption($name = '-foo', $arr = ['a', 'b', 'c'])->getOption($name)->toBe($arr);
})->group(__DIR__, __FILE__);

it('can merge option', function (): void {
    expect(Soar::create([$name = 'foo', 'bar']))
        ->withOption($name, $name)
        ->getOption($name)->toBe($name);
})->group(__DIR__, __FILE__);

it('can get options', function (): void {
    expect(Soar::create($options = ['foo' => 'bar']))->getOptions()->toBe($options);
})->group(__DIR__, __FILE__);

it('will throw BadMethodCallException when call not exist method', function (): void {
    /** @noinspection PhpUndefinedMethodInspection */
    Soar::create()->foo();
})
    ->group(__DIR__, __FILE__)
    ->throws(BadMethodCallException::class, 'foo');

it('can call option methods via magic call', function (): void {
    // $prefixes = ['add', 'except', 'only', 'set', 'with', 'getNormalized', 'get'];
    expect(Soar::create())
        // ->addVersion($val = 'version')->getVersion()->toBe($val)
        ->setVersion($val = 'version')->exceptVersion()->getVersionc()->toBeNull()
        ->onlyVersion()->getVersion()->toBeNull()
        ->setVersion($val)->getVersion()->toBe($val)
        ->withVersion($val)->getVersion()->toBe($val);
})->group(__DIR__, __FILE__)->skip();

it('will throw InvalidOptionException when normalize invalid option', function (): void {
    (fn (): array => $this->getNormalizedOptions())->call(Soar::create(['foo' => $this->createMock(stdClass::class)]));
})
    ->group(__DIR__, __FILE__)
    ->throws(InvalidOptionException::class, 'object');

it('can normalize options', function (): void {
    expect(fn (): array => $this->getNormalizedOptions())
        ->call(Soar::create([
            'foo' => 'bar',
            '-verbose' => true,
            '-test-dsn' => [
                'host' => 'you_host',
                'port' => 'you_port',
                'dbname' => 'you_dbname',
                'username' => 'you_username',
                'password' => 'you_password',
                'disable' => false,
            ],
            '-online-dsn' => [
                'host' => 'you_host',
                'port' => 'you_port',
                'dbname' => 'you_dbname',
                'username' => 'you_username',
                'password' => 'you_password',
                'disable' => true,
            ],
            'arr' => ['foo', 'bar', 'baz'],
            'closure' => static fn (Soar $soar): string => $soar->getOption('foo'),
            'stringable' => new class {
                public function __toString(): string
                {
                    return self::class;
                }
            },
            'invoke' => new class {
                public function __invoke(): string
                {
                    return self::class;
                }
            },
        ]))
        ->toBeArray();
});
