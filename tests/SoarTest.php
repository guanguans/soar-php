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

    public function testGetSoarPath()
    {
        $this->assertFileExists($this->soar->getSoarPath());
    }

    public function testSetSoarPathInvalidConfigException()
    {
        $this->expectException(InvalidConfigException::class);
        $this->soar->setSoarPath('bar.soar');

        $this->expectException(InvalidConfigException::class);
        $this->soar->setSoarPath(__FILE__);
    }

    public function testSetSoarPath()
    {
        $this->assertFileExists($soarPath = $this->soar->setSoarPath(NSA::invokeMethod($this->soar, 'getDefaultSoarPath'))->getSoarPath());
        $this->assertTrue(is_executable($soarPath));
    }

    public function testGetPdoConfig()
    {
        $this->expectException(InvalidConfigException::class);
        NSA::invokeMethod($this->soar, 'getPdoConfig');

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
        $this->assertEquals($this->soar->getOptions()['-online-dsn'], NSA::invokeMethod($this->soar, 'getPdoConfig'));

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
        $this->assertEquals($this->soar->getOptions()['-test-dsn'], NSA::invokeMethod($this->soar, 'getPdoConfig'));
    }

    public function testExec()
    {
        $this->assertStringContainsString('soar', $this->soar->exec('echo soar'));
    }

    public function testGetOptions()
    {
        $this->assertIsArray($this->soar->getOptions());
    }

    public function testSetOption()
    {
        $this->assertEquals('bar', $this->soar->setOption('foo', 'bar')->getOptions()['foo']);
    }

    public function testNormalizeToStrOptions()
    {
        $this->assertStringContainsString('-online-dsn', NSA::invokeMethod($this->soar, 'normalizeToStrOptions', [
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

        $this->assertStringContainsString('foo', NSA::invokeMethod($this->soar, 'normalizeToStrOptions', [
            'foo' => ['bar'],
        ]));
    }

    public function testNormalizeToArrOptions()
    {
        $this->assertIsArray(NSA::invokeMethod($this->soar, 'normalizeToArrOptions', [
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

        $this->assertIsArray($options = NSA::invokeMethod($this->soar, 'normalizeToArrOptions', [
            '-foo' => 'bar',
            '-bar' => ['a', 'b', 'c'],
        ]));
        $this->assertTrue(in_array('-foo=bar', $options));
        $this->assertTrue(in_array('-bar=a,b,c', $options));
    }

    public function testScore()
    {
        $this->assertIsString($this->soar->score('select * from users'));
    }

    public function testExplainInvalidConfigException()
    {
        $this->expectException(InvalidConfigException::class);
        $this->soar->explain('select * from users');
    }

    public function testSyntaxCheck()
    {
        $this->assertStringContainsString('At SQL 1 : line 1 column 5 near "selec', $this->soar->syntaxCheck('selec * from fa_users;'));
        $this->assertEmpty($this->soar->syntaxCheck('select * from fa_users;'));
    }

    public function testFingerPrint()
    {
        $this->assertStringContainsString('?', $this->soar->fingerPrint('select * from users where id = 1;'));
    }

    public function testPretty()
    {
        $this->assertStringContainsString("\n", $this->soar->pretty('select * from users where id = 1;'));
    }

    public function testMd2html()
    {
        $this->assertStringContainsString('<ul>', $html = $this->soar->md2html('* 这是一个测试'));
        $this->assertStringContainsString('<li>', $html);
    }

    public function testHelp()
    {
        OsHelper::isWindows() and $this->markTestSkipped('help is not supported on windows');
        $this->assertStringContainsString('-version', $this->soar->help());
    }
}
