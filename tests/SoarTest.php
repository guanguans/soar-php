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

        $scores = $soar->scores(['select * from a; select * from b', 'select * from c', 'select * from d']);
        $this->assertIsString($scores);
        $this->assertNotEmpty($scores);

        $soar = Soar::create(require __DIR__.'/../soar.options.full.php');
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

    public function testDump(): void
    {
        $soar = Soar::create([
            'foo' => 'bar',
        ]);

        $this->assertInstanceOf(Soar::class, $soar->dump('foo'));

        $functionMock = $this->getFunctionMock('\\Guanguans\\SoarPHP', 'class_exists');
        $functionMock->expects($this->any())->willReturn(false);
        $this->assertInstanceOf(Soar::class, $soar->dump('foo'));
    }

    public function testSleep(): void
    {
        $soar = Soar::create(require __DIR__.'/../soar.options.full.php');
        $serializedSoar = serialize($soar);
        $unserializedSoar = unserialize($serializedSoar);

        $this->assertInstanceOf(Soar::class, $unserializedSoar);
        $this->assertNotEmpty($unserializedSoar->getSoarPath());
        $this->assertNotEmpty($unserializedSoar->getOptions());
        $this->assertNotEmpty($unserializedSoar->getNormalizedOptions());
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     */
    public function testSetState(): void
    {
        $soar = Soar::create(require __DIR__.'/../soar.options.full.php');
        $exportedSoarStr = var_export($soar, true);
        eval("\$exportedSoar = $exportedSoarStr;");

        $this->assertInstanceOf(Soar::class, $exportedSoar);
        $this->assertNotEmpty($exportedSoar->getSoarPath());
        $this->assertNotEmpty($exportedSoar->getOptions());
        $this->assertNotEmpty($exportedSoar->getNormalizedOptions());
    }
}
