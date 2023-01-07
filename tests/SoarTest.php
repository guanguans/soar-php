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
use Guanguans\SoarPHP\Exceptions\InvalidConfigException;
use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHP\Support\OsHelper;
use Nyholm\NSA;

class SoarTest extends TestCase
{
    protected $soar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->soar = Soar::create();
    }

    public function testGetSoarPath(): void
    {
        $this->assertFileExists($this->soar->getSoarPath());
    }

    public function testSetSoarPathInvalidConfigException(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->soar->setSoarPath('bar.soar');

        $this->expectException(InvalidArgumentException::class);
        $this->soar->setSoarPath(__FILE__);
    }

    public function testSetSoarPath(): void
    {
        $this->assertFileExists($soarPath = $this->soar->setSoarPath(NSA::invokeMethod($this->soar, 'getDefaultSoarPath'))->getSoarPath());
        $this->assertTrue(is_executable($soarPath));
    }

    public function testGetPdoConfig(): void
    {
        $this->markTestSkipped(__CLASS__);
        $this->expectException(InvalidConfigException::class);
        NSA::invokeMethod($this->soar, 'extractConfigOfPDO', $this->soar->getOptions());

        $this->soar->setOption(
            '-online-dsn',
            $onlineDsn = [
                'host' => '192.168.10.10',
                'port' => '3306',
                'dbname' => 'laravel',
                'username' => 'homestead',
                'password' => 'secret',
                'disable' => false,
                'options' => [],
            ]
        );
        $this->assertEquals($this->soar->getOptions()['-online-dsn'], NSA::invokeMethod($this->soar, 'extractConfigOfPDO', $this->soar->getOptions()));

        $this->soar->setOption(
            '-test-dsn',
            $testDsn = [
                'host' => '192.168.10.10',
                'port' => '3306',
                'dbname' => 'laravel',
                'username' => 'homestead',
                'password' => 'secret',
                'disable' => false,
            ]
        );
        $this->assertEquals($this->soar->getOptions()['-test-dsn'], NSA::invokeMethod($this->soar, 'extractConfigOfPDO', $this->soar->getOptions()));
    }

    public function testExec(): void
    {
        $this->assertStringContainsString('soar', $this->soar->exec('echo soar'));
    }

    public function testGetOptions(): void
    {
        $this->assertIsArray($this->soar->getOptions());
    }

    public function testSetOption(): void
    {
        $this->assertSame('bar', $this->soar->setOption('foo', 'bar')->getOptions()['foo']);
    }

    public function testNormalizeToArrOptions(): void
    {
        $this->assertIsArray(NSA::invokeMethod($this->soar, 'normalizeOptions', [
            '-online-dsn' => [
                'host' => '192.168.10.10',
                'port' => '3306',
                'dbname' => 'laravel',
                'username' => 'homestead',
                'password' => 'secret',
                'disable' => false,
                'options' => [],
            ],
        ]));

        $this->assertIsArray($options = NSA::invokeMethod($this->soar, 'normalizeOptions', [
            '-foo' => 'bar',
            '-bar' => ['a', 'b', 'c'],
        ]));
        $this->assertContains('-foo=bar', $options);
        $this->assertContains('-bar=a,b,c', $options);
    }

    public function testScore(): void
    {
        $this->assertIsString($this->soar->score('select * from users'));
    }

    public function testExplainInvalidConfigException(): void
    {
        $this->expectException(InvalidConfigException::class);
        $this->soar->explain('select * from users');
    }

    public function testSyntaxCheck(): void
    {
        $this->assertStringContainsString('At SQL 1 : line 1 column 5 near "selec', $this->soar->syntaxCheck('selec * from fa_users;'));
        $this->assertEmpty($this->soar->syntaxCheck('select * from fa_users;'));
    }

    public function testFingerPrint(): void
    {
        $this->assertStringContainsString('?', $this->soar->fingerPrint('select * from users where id = 1;'));
    }

    public function testPretty(): void
    {
        $this->assertStringContainsString("\n", $this->soar->pretty('select * from users where id = 1;'));
    }

    public function testMd2html(): void
    {
        $this->assertStringContainsString('<ul>', $html = $this->soar->md2html('* 这是一个测试'));
        $this->assertStringContainsString('<li>', $html);
    }

    public function testHelp(): void
    {
        OsHelper::isWindows() and $this->markTestSkipped('help is not supported on windows');
        $this->assertStringContainsString('-version', $this->soar->help());
    }
}
