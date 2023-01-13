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
use Guanguans\SoarPHP\Exceptions\InvalidConfigException;
use Guanguans\SoarPHP\Soar;
use Guanguans\Tests\TestCase;

class HasOptionsTest extends TestCase
{
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

    public function testMergeOptions(): void
    {
        $soar = Soar::create();
        $options = [$key = 'foo' => $val = 'bar'];
        $option = $soar->mergeOptions($options)->getOption($key);

        $this->assertSame($val, $option);
    }

    public function testResetOptions(): void
    {
        $soar = Soar::create([
            '-test-dsn' => 'bar',
            'foo' => 'bar',
        ]);

        $this->assertInstanceOf(Soar::class, $soar->resetOptions());
    }

    public function testGetOptions(): void
    {
        $soar = Soar::create();

        $this->assertIsArray($soar->getOptions());
    }

    public function testGetNormalizedOptions(): void
    {
        $soar = Soar::create();

        $this->assertIsArray($soar->getNormalizedOptions());
        $this->assertIsArray($soar->getNormalizedOptions(['foo']));
    }

    public function testGetNormalizedStrOptions(): void
    {
        $soar = Soar::create();

        $this->assertIsString($soar->getNormalizedStrOptions());
    }

    public function testBadMethodCallExceptionForCall(): void
    {
        $soar = Soar::create();
        $method = 'foo';

        $this->expectException(BadMethodCallException::class);
        $this->expectExceptionMessage($method);
        $soar->{$method}();
    }

    public function testInvalidConfigExceptionForNormalizeOptions(): void
    {
        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('object');
        Soar::create(['foo' => $this->createMock(\stdClass::class)]);
    }
}
