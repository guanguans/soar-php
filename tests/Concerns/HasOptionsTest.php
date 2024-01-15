<?php

/** @noinspection AnonymousFunctionStaticInspection */
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
    $options = [$key = 'foo' => $val = 'bar'];
    $soar = Soar::create($options);
    $option = $soar->addOption($key, $addVal = 'foo')->getOption($key);

    expect($val)->toBe($option)
        ->and($addVal)->not->toBe($option);
});

it('can remove option', function (): void {
    $options = [$key = 'foo' => $val = 'bar'];
    $soar = Soar::create($options);
    $option = $soar->removeOption($key)->getOption($key);

    expect($option)->toBeNull()->not->toBe($val);
});

it('can only option', function (): void {
    $soar = Soar::create([
        $key1 = 'key1' => $val = 'val',
        $key2 = 'key2' => $val,
    ]);
    $soar = $soar->onlyOption($key1);

    expect($val)->toBe($soar->getOption($key1))
        ->not->toBe($soar->getOption($key2))
        ->and($soar->getOption($key2))->toBeNull();
});

it('can only dsn', function (): void {
    $soar = Soar::create([
        $key1 = '-test-dsn' => $val = 'val',
        $key2 = 'key2' => $val,
    ]);
    $soar = $soar->onlyDsn();

    expect($val)->toBe($soar->getOption($key1))
        ->not->toBe($soar->getOption($key2))
        ->and($soar->getOption($key2))->toBeNull();
});

it('can set option', function (): void {
    $soar = Soar::create();

    expect($soar->setOption($key = 'foo', $str = 'bar')->getOption($key))->toBe($str)
        ->and($soar->setOption($key = '-online-dsn', $arr = [
            'host' => '192.168.10.10',
            'port' => '3306',
            'dbname' => 'laravel',
            'username' => 'homestead',
            'password' => 'secret',
            'disable' => false,
            'options' => [],
        ])->getOption($key))->toBe($arr)
        ->and($soar->setOption($key = '-foo', $arr = ['a', 'b', 'c'])->getOption($key))->toBe($arr);
});

it('can merge option', function (): void {
    $soar = Soar::create();
    $option = $soar->mergeOption($key = 'foo', $val = 'bar')->getOption($key);

    expect($option)->toBe($val);
});

it('can get options', function (): void {
    expect(Soar::create())->getOptions()->toBeArray();
});

it('will throw an exception when call unknown method', function (): void {
    /** @noinspection PhpUndefinedMethodInspection */
    Soar::create()->foo();
})->throws(BadMethodCallException::class, 'foo');

it('can call', function (): void {
    // $prefixes = ['add', 'remove', 'only', 'set', 'merge', 'getNormalized', 'get'];
    $val = 'version';
    $version = Soar::create()->addVersion($val)->getVersion();
    expect($version)->toBe($val);

    $version = Soar::create()->setVersion($val)->removeVersion()->getVersion();
    expect($version)->toBeNull();

    $version = Soar::create()->onlyVersion()->getVersion();
    expect($version)->toBeNull();

    $version = Soar::create()->setVersion($val)->getVersion();
    expect($version)->toBe($val);

    $version = Soar::create()->mergeVersion($val)->getVersion();
    expect($version)->toBe($val);
});

it('will throw an exception when normalize invalid option', function (): void {
    (function (): array {
        return $this->getNormalizedOptions();
    })->call(Soar::create(['foo' => $this->createMock(stdClass::class)]));
})->throws(InvalidOptionException::class, 'object');

it('can normalize options', function (): void {
    $soar = Soar::create([
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
                return __CLASS__;
            }
        },
        'invoke' => new class() {
            public function __invoke(): string
            {
                return __CLASS__;
            }
        },
    ]);

    expect(function (): array {
        return $this->getNormalizedOptions();
    })->call($soar)->toBeArray();
});
