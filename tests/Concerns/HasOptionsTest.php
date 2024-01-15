<?php

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
use Guanguans\SoarPHPTests\Fixtures\InvokeOption;
use Guanguans\SoarPHPTests\Fixtures\StringableOption;

uses(Guanguans\SoarPHPTests\TestCase::class);

test('add option', function (): void {
    $options = [$key = 'foo' => $val = 'bar'];
    $soar = Soar::create($options);
    $option = $soar->addOption($key, $addVal = 'foo')->getOption($key);

    expect($val)->toBe($option);
    $this->assertNotSame($option, $addVal);
});

test('remove option', function (): void {
    $options = [$key = 'foo' => $val = 'bar'];
    $soar = Soar::create($options);
    $option = $soar->removeOption($key)->getOption($key);

    expect($option)->toBeNull();
    $this->assertNotSame($val, $option);
});

test('only option', function (): void {
    $soar = Soar::create([
        $key1 = 'key1' => $val = 'val',
        $key2 = 'key2' => $val,
    ]);
    $soar = $soar->onlyOption($key1);

    expect($val)->toBe($soar->getOption($key1));
    $this->assertNotSame($soar->getOption($key2), $val);
    expect($soar->getOption($key2))->toBeNull();
});

test('only dsn', function (): void {
    $soar = Soar::create([
        $key1 = '-test-dsn' => $val = 'val',
        $key2 = 'key2' => $val,
    ]);
    $soar = $soar->onlyDsn();

    expect($val)->toBe($soar->getOption($key1));
    $this->assertNotSame($soar->getOption($key2), $val);
    expect($soar->getOption($key2))->toBeNull();
});

test('set option', function (): void {
    $soar = Soar::create();

    expect($soar->setOption($key = 'foo', $str = 'bar')->getOption($key))->toBe($str);

    expect($soar->setOption($key = '-online-dsn', $arr = [
        'host' => '192.168.10.10',
        'port' => '3306',
        'dbname' => 'laravel',
        'username' => 'homestead',
        'password' => 'secret',
        'disable' => false,
        'options' => [],
    ])->getOption($key))->toBe($arr);

    expect($soar->setOption($key = '-foo', $arr = ['a', 'b', 'c'])->getOption($key))->toBe($arr);
});

test('merge option', function (): void {
    $soar = Soar::create();
    $option = $soar->mergeOption($key = 'foo', $val = 'bar')->getOption($key);

    expect($option)->toBe($val);
});

test('get options', function (): void {
    $soar = Soar::create();

    expect($soar->getOptions())->toBeArray();
});

test('bad method call exception for call', function (): void {
    $soar = Soar::create();
    $method = 'foo';

    $this->expectException(BadMethodCallException::class);
    $this->expectExceptionMessage($method);
    $soar->{$method}();
});

test('call', function (): void {
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

test('invalid option exception for normalize options', function (): void {
    $this->expectException(InvalidOptionException::class);
    $this->expectExceptionMessage('object');
    (function (): array {
        return $this->getNormalizedOptions();
    })->call(Soar::create(['foo' => $this->createMock(stdClass::class)]));
});

test('normalize options', function (): void {
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
        'stringable' => new StringableOption(),
        'invoke' => new InvokeOption(),
    ]);

    expect((function (): array {
        return $this->getNormalizedOptions();
    })->call($soar))->toBeArray();
});
