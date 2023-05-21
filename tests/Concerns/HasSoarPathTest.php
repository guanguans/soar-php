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

use AspectMock\Test as test;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHP\Support\OS;
use Guanguans\Tests\TestCase;

/**
 * @internal
 *
 * @small
 */
class HasSoarPathTest extends TestCase
{
    public function testGetSoarPath(): void
    {
        // $mock = \Mockery::mock('alias:'.OS::class)->makePartial();
        // $mock->allows('isWindows')->andReturnTrue();
        // $soar = Soar::create();
        // $this->assertFileExists($soar->getSoarPath());
        // $this->assertStringContainsString('windows', $soar->getSoarPath());

        $soar = Soar::create();
        $this->assertFileExists($soar->getSoarPath());

        // 暂存
        $originals = ['isWindows' => OS::isWindows(), 'isMacOS' => OS::isMacOS()];

        test::double(OS::class, ['isWindows' => true, 'isMacOS' => false]);
        $soar = Soar::create();
        $this->assertFileExists($soar->getSoarPath());
        $this->assertStringContainsString('windows', $soar->getSoarPath());

        test::double(OS::class, ['isWindows' => false, 'isMacOS' => true]);
        $soar = Soar::create();
        $this->assertFileExists($soar->getSoarPath());
        $this->assertStringContainsString('darwin', $soar->getSoarPath());

        test::double(OS::class, ['isWindows' => false, 'isMacOS' => false]);
        $soar = Soar::create();
        $this->assertFileExists($soar->getSoarPath());
        $this->assertStringContainsString('linux', $soar->getSoarPath());

        // 恢复
        test::double(OS::class, $originals);
    }

    public function testInvalidArgumentExceptionForSetSoarPath(): void
    {
        $soar = Soar::create();

        $this->expectException(InvalidArgumentException::class);
        $soar->setSoarPath('soar.path');
    }
}
