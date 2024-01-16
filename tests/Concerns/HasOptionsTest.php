<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\SoarPHP\Exceptions\BadMethodCallException;
use Guanguans\SoarPHP\Exceptions\InvalidOptionException;
use Guanguans\SoarPHP\Soar;

it('can add option', function (): void {
    expect(Soar::create())
        ->addOption($key = 'foo', $val = 'bar')
        ->getOption($key)->toBe($val)
        ->addOption($key, $key)
        ->getOption($key)->toBe($val);
})->group(__DIR__, __FILE__);

it('can remove option', function (): void {
    expect(Soar::create([$key = 'foo' => $val = 'bar']))
        ->getOption($key)->toBe($val)
        ->removeOption($key)->getOption($key)->toBeNull();
})->group(__DIR__, __FILE__);

it('can only option', function (): void {
    expect(Soar::create([
        $key1 = 'key1' => $val = 'val',
        $key2 = 'key2' => $val,
    ]))
        ->onlyOption($key1)
        ->getOption($key1)->toBe($val)
        ->getOption($key2)->toBeNull();
})->group(__DIR__, __FILE__);

it('can only dsn', function (): void {
    expect(Soar::create([
        $key1 = '-test-dsn' => $val = 'val',
        $key2 = 'key2' => $val,
    ]))
        ->onlyDsn()
        ->getOption($key1)->toBe($val)
        ->getOption($key2)->toBeNull();
})->group(__DIR__, __FILE__);

it('can set option', function (): void {
    expect(Soar::create())
        ->setOption($key = 'foo', $str = 'bar')->getOption($key)->toBe($str)
        ->setOption(
            $key = '-online-dsn',
            $arr = [
                'host' => '192.168.10.10',
                'port' => '3306',
                'dbname' => 'laravel',
                'username' => 'homestead',
                'password' => 'secret',
                'disable' => false,
                'options' => [],
            ]
        )->getOption($key)->toBe($arr)
        ->setOption($key = '-foo', $arr = ['a', 'b', 'c'])->getOption($key)->toBe($arr);
})->group(__DIR__, __FILE__);

it('can merge option', function (): void {
    expect(Soar::create([$key = 'foo', 'bar']))
        ->mergeOption($key, $key)
        ->getOption($key)->toBe($key);
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
    // $prefixes = ['add', 'remove', 'only', 'set', 'merge', 'getNormalized', 'get'];
    expect(Soar::create())
        ->addVersion($val = 'version')->getVersion()->toBe($val)
        ->setVersion($val)->removeVersion()->getVersion()->toBeNull()
        ->onlyVersion()->getVersion()->toBeNull()
        ->setVersion($val)->getVersion()->toBe($val)
        ->mergeVersion($val)->getVersion()->toBe($val);
})->group(__DIR__, __FILE__);

it('will throw InvalidOptionException when normalize invalid option', function (): void {
    (function (): array {
        return $this->getNormalizedOptions();
    })->call(Soar::create(['foo' => $this->createMock(stdClass::class)]));
})
    ->group(__DIR__, __FILE__)
    ->throws(InvalidOptionException::class, 'object');

it('can normalize options', function (): void {
    expect(function (): array {
        return $this->getNormalizedOptions();
    })
        ->call(Soar::create([
            'foo' => 'bar',
            '-verbose',
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
            'closure' => static function (Soar $soar): string {
                return $soar->getOption('foo');
            },
            'stringable' => new class() {
                public function __toString(): string
                {
                    return self::class;
                }
            },
            'invoke' => new class() {
                public function __invoke(): string
                {
                    return self::class;
                }
            },
        ]))
        ->toBeArray();
});
