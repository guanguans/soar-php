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
use Guanguans\Tests\Fixtures\InvokeOption;
use Guanguans\Tests\Fixtures\StringableOption;
use Guanguans\Tests\TestCase;

/**
 * @internal
 *
 * @small
 */
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

    public function testOnlyDsn(): void
    {
        $soar = Soar::create([
            $key1 = '-test-dsn' => $val = 'val',
            $key2 = 'key2' => $val,
        ]);
        $soar = $soar->onlyDsn();

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
    }

    public function testInvalidOptionExceptionForNormalizeOptions(): void
    {
        $this->expectException(InvalidOptionException::class);
        $this->expectExceptionMessage('object');
        (function (): array {
            return $this->getNormalizedOptions();
        })->call(Soar::create(['foo' => $this->createMock(\stdClass::class)]));
    }

    public function testNormalizeOptions(): void
    {
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

        $this->assertIsArray(
            (function (): array {
                return $this->getNormalizedOptions();
            })->call($soar)
        );
    }
}
