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
        $this->assertFileExists($this->soar->setSoarPath(__DIR__.'/../bin/soar.linux-amd64')->getSoarPath());
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

    public function testNormalizeOptions()
    {
        $this->assertStringContainsString('-online-dsn', NSA::invokeMethod($this->soar, 'normalizeOptions', [
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

        $this->assertStringContainsString('foo', NSA::invokeMethod($this->soar, 'normalizeOptions', [
            'foo' => ['bar'],
        ]));
    }

    public function testScore()
    {
        $this->assertIsString($this->soar->score('select * from users'));
    }

    public function testExplainInvalidArgumentException()
    {
        $this->expectException(InvalidArgumentException::class);
        $this->soar->explain('select * from users', 'json');
    }

    public function testExplainInvalidConfigException()
    {
        $this->expectException(InvalidConfigException::class);
        $this->soar->explain('select * from users', 'md');
    }

    public function testSyntaxCheck()
    {
        $this->assertStringContainsString('At SQL 1 : line 1 column 5 near "selec * from fa_userss"', $this->soar->syntaxCheck('selec * from fa_userss;'));
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
        $this->assertStringContainsString('<h2>', $this->soar->md2html('## 这是一个测试'));
    }

    public function testHelp()
    {
        $this->assertStringContainsString('-version', $this->soar->help());
    }
}
