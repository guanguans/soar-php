<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests;

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHP\Support\OsHelper;

class SoarTest extends TestCase
{
    public function testInvalidArgumentExceptionForScores(): void
    {
        $soar = Soar::create();
        $sqls = true;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(gettype($sqls));

        $soar->scores($sqls);
    }

    public function testScores(): void
    {
        $soar = Soar::create();
        $scores = $soar->scores('select * from users;');

        $this->assertIsString($scores);
        $this->assertNotEmpty($scores);
    }

    public function testHelp(): void
    {
        OsHelper::isWindows() and $this->markTestSkipped('The method of help is not supported on windows.');
        $soar = Soar::create();
        $help = $soar->help();

        $this->assertStringContainsString('-version', $help);
    }

    public function testVersion(): void
    {
        $soar = Soar::create();
        $version = $soar->version();

        $this->assertStringContainsString('Version: 2022-11-01 23:58:57 +0800 0.11.0-144-g15f9e34', $version);
        $this->assertStringContainsString('Branch: dev', $version);
        $this->assertStringContainsString('Compile: 2023-01-09 10:38:32 +0800 by go version go1.19.3', $version);
        $this->assertStringContainsString('GitDirty:        0', $version);
    }

    public function testGetSoarPath(): void
    {
        $soar = Soar::create();

        $this->assertFileExists($soar->getSoarPath());
    }

    public function testInvalidConfigExceptionForSetSoarPath(): void
    {
        $soar = Soar::create();

        $this->expectException(InvalidArgumentException::class);
        $soar->setSoarPath('foo.soar.path');
    }
}
