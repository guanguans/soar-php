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

use Guanguans\SoarPHP\Contracts\Explainer;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Exceptions\InvalidConfigException;
use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHP\Support\OsHelper;

class SoarTest extends TestCase
{
    public function testScore(): void
    {
        $soar = Soar::create();
        $score = $soar->score('select * from users;');

        $this->assertIsString($score);
    }

    public function testInvalidConfigExceptionForExplain(): void
    {
        $soar = Soar::create();

        $this->expectException(InvalidConfigException::class);
        $soar->explain('select * from users;');
    }

    public function testSyntaxCheck(): void
    {
        $soar = Soar::create();

        $syntaxCheck = $soar->syntaxCheck('selec * from fa_users;');
        $this->assertStringContainsString(
            'At SQL 1 : line 1 column 5 near "selec',
            $syntaxCheck
        );
        OsHelper::isWindows() or $this->assertMatchesSnapshot($syntaxCheck);

        $this->assertEmpty($soar->syntaxCheck('select * from fa_users;'));
    }

    public function testFingerPrint(): void
    {
        $soar = Soar::create();
        $fingerPrint = trim($soar->fingerPrint('select * from users where id = 1;'));

        $this->assertSame('select * from users where id = ?', $fingerPrint);
        $this->assertMatchesSnapshot($fingerPrint);
    }

    public function testPretty(): void
    {
        $soar = Soar::create();
        $pretty = $soar->pretty('select * from users where id = 1;');

        $this->assertStringContainsString("\n", $pretty);
        $this->assertStringContainsString('  ', $pretty);
        OsHelper::isWindows() or $this->assertMatchesSnapshot($pretty);
    }

    public function testMd2html(): void
    {
        OsHelper::isWindows() and $this->markTestSkipped(__METHOD__);

        $soar = Soar::create();
        $html = $soar->md2html('* 这是一个测试');

        $this->assertStringContainsString(
            <<<'html'
<ul>
<li>这是一个测试</li>
</ul>
html
            ,
            $html
        );
        $this->assertMatchesSnapshot($html);
    }

    public function testListTestSqls(): void
    {
        $soar = Soar::create();
        $listTestSqls = $soar->listTestSqls();

        $this->assertIsString($listTestSqls);
        $this->assertNotEmpty($listTestSqls);
    }

    public function testHelp(): void
    {
        $soar = Soar::create();
        OsHelper::isWindows() and $this->markTestSkipped('The method of help is not supported on windows.');

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
        $soar->setSoarPath('foo.soar');
    }

    public function testSetExplainer(): void
    {
        $soar = Soar::create();

        $this->assertInstanceOf(Soar::class, $soar->setExplainer($this->createMock(Explainer::class)));
    }
}
