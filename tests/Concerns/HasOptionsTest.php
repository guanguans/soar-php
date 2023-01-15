<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests\Concerns;

use Guanguans\SoarPHP\Exceptions\BadMethodCallException;
use Guanguans\SoarPHP\Exceptions\InvalidOptionException;
use Guanguans\SoarPHP\Soar;
use Guanguans\Tests\TestCase;

class HasOptionsTest extends TestCase
{
    public function testAddOption(): void
    {
        $options = [$key = 'foo' => $val = 'bar'];
        $soar = Soar::create($options);
        $option = $soar->addOption($key, $addVal = 'foo')->getOption($key);

        $this->assertSame($option, $val);
        $this->assertNotSame($option, $addVal);
    }

    public function testRemoveOption(): void
    {
        $options = [$key = 'foo' => $val = 'bar'];
        $soar = Soar::create($options);
        $option = $soar->removeOption($key)->getOption($key);

        $this->assertNull($option);
        $this->assertNotSame($val, $option);
    }

    public function testOnlyOption(): void
    {
        $soar = Soar::create([
            $key1 = 'key1' => $val = 'val',
            $key2 = 'key2' => $val,
        ]);
        $soar = $soar->onlyOption($key1);

        $this->assertSame($soar->getOption($key1), $val);
        $this->assertNotSame($soar->getOption($key2), $val);
        $this->assertNull($soar->getOption($key2));
    }

    public function testSetOption(): void
    {
        $soar = Soar::create();

        $this->assertSame(
            $str = 'bar',
            $soar->setOption($key = 'foo', $str)->getOption($key)
        );

        $this->assertSame(
            $arr = [
                'host' => '192.168.10.10',
                'port' => '3306',
                'dbname' => 'laravel',
                'username' => 'homestead',
                'password' => 'secret',
                'disable' => false,
                'options' => [],
            ],
            $soar->setOption($key = '-online-dsn', $arr)->getOption($key)
        );

        $this->assertSame(
            $arr = ['a', 'b', 'c'],
            $soar->setOption($key = '-foo', $arr)->getOption($key)
        );
    }

    public function testMergeOption(): void
    {
        $soar = Soar::create();
        $option = $soar->mergeOption($key = 'foo', $val = 'bar')->getOption($key);

        $this->assertSame($val, $option);
    }

    public function testGetNormalizedOptions(): void
    {
        $soar = Soar::create();

        $this->assertIsArray($soar->getNormalizedOptions());
    }

    public function testGetNormalizedOption(): void
    {
        $soar = Soar::create();

        $this->assertNull($soar->getNormalizedOption('foo'));
    }

    public function testGetSerializedNormalizedOptions(): void
    {
        $soar = Soar::create();

        $this->assertIsString($soar->getSerializedNormalizedOptions());
    }

    public function testGetOptions(): void
    {
        $soar = Soar::create();

        $this->assertIsArray($soar->getOptions());
    }

    public function testBadMethodCallExceptionForCall(): void
    {
        $soar = Soar::create();
        $method = 'foo';

        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage($method);
        $soar->{$method}();
    }

    public function testCall(): void
    {
        // $prefixes = ['add', 'remove', 'only', 'set', 'merge', 'getNormalized', 'get'];

        $val = 'version';
        $version = Soar::create()->addVersion($val)->getVersion();
        $this->assertSame($val, $version);

        $version = Soar::create()->setVersion($val)->removeVersion()->getVersion();
        $this->assertNull($version);

        $version = Soar::create()->onlyVersion()->getVersion();
        $this->assertNull($version);

        $version = Soar::create()->setVersion($val)->getVersion();
        $this->assertSame($val, $version);

        $version = Soar::create()->mergeVersion($val)->getVersion();
        $this->assertSame($val, $version);

        $version = Soar::create()->setVersion($val)->getNormalizedVersion();
        $this->assertSame("-version=$val", $version);

        $version = Soar::create()->getNormalizedVersion();
        $this->assertNull($version);
    }

    public function testInvalidOptionExceptionForNormalizeOptions(): void
    {
        $this->expectException(InvalidOptionException::class);
        $this->expectExceptionMessage('object');
        Soar::create(['foo' => $this->createMock(\stdClass::class)]);
    }
}
