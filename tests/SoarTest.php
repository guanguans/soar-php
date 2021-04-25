<?php

declare(strict_types=1);

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests;

use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHP\Support\OsHelper;

class SoarTest extends TestCase
{
    protected $soar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->soar = new Soar([
            '-soar-path' => OsHelper::isMacOS() ? __DIR__.'/../bin/soar.darwin-amd64' : __DIR__.'/../bin/soar.linux-amd64',
            '-test-dsn' => [
                'host' => '127.0.0.1',
                'port' => '3306',
                'dbname' => 'dbname',
                'username' => 'username',
                'password' => 'password',
            ],
            '-log-output' => './soar.log',
        ]);
    }

    public function testSetSoarPath()
    {
        $this->soar->setSoarPath('path/to/soar');
        $this->assertStringStartsWith('path', $this->soar->getSoarPath());
    }

    public function testGetSoarPath()
    {
        $this->soar->setSoarPath('path/to/soar');
        $this->assertStringEndsWith('soar', $this->soar->getSoarPath());
    }

    public function testSetPdoConfig()
    {
        $this->soar->setPdoConfig(['key' => 'value']);
        $this->assertArrayHasKey('key', $this->soar->getPdoConfig());
    }

    public function testGetPdoConfig()
    {
        $this->soar->setPdoConfig(['key2' => 'value2']);
        $this->assertArrayHasKey('key2', $this->soar->getPdoConfig());
    }

    public function testSetConfig()
    {
        $this->soar->setConfig(['key' => 'value']);
        $this->assertArrayHasKey('key', $this->soar->getConfig());
    }

    public function testGetConfig()
    {
        $this->soar->setConfig(['key2' => 'value2']);
        $this->assertArrayHasKey('key2', $this->soar->getConfig());
    }

    public function testGetFormatConfig()
    {
        $this->assertStringStartsWith(' -', $this->soar->getFormatConfig(['-log-output' => 'soar.log']));
        $this->assertSame(' -log-output=soar.log ', $this->soar->getFormatConfig(['-log-output' => 'soar.log']));
        $this->assertStringContainsString('{"', $this->soar->getFormatConfig([
            '-test' => [
                'key1' => 'val1',
                'key2' => 'val2',
            ],
        ]));
        $this->assertStringContainsString('"}', $this->soar->getFormatConfig([
            '-test' => [
                'key1' => 'val1',
                'key2' => 'val2',
            ],
        ]));
        $this->assertStringContainsString(':', $this->soar->getFormatConfig(
            [
                ' -test-dsn ' => [
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'dbname' => 'dbname',
                    'username' => 'usersname',
                    'password' => 'password',
                    'disable' => false,
                ],
            ]
        ));
        $this->assertStringContainsString('@', $this->soar->getFormatConfig(
            [
                '-test-dsn' => [
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'dbname' => 'dbname',
                    'username' => 'usersname',
                    'password' => 'password',
                    'disable' => false,
                ],
            ]
        ));
        $this->assertStringContainsString('/', $this->soar->getFormatConfig(
            [
                '-test-dsn' => [
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'dbname' => 'dbname',
                    'username' => 'usersname',
                    'password' => 'password',
                    'disable' => false,
                ],
            ]
        ));
        $this->assertEmpty($this->soar->getFormatConfig(
            [
                '-test-dsn' => [
                    'host' => '127.0.0.1',
                    'port' => '3306',
                    'dbname' => 'dbname',
                    'username' => 'usersname',
                    'password' => 'password',
                    'disable' => true,
                ],
            ]
        ));
    }

    public function testExec()
    {
        $this->assertStringMatchesFormat('%s', $this->soar->exec('echo soar'));
    }

    public function testScore()
    {
        $this->assertStringMatchesFormat('%A', $this->soar->score('select * from users'));
        $this->assertStringMatchesFormat('%a', $this->soar->score('select * from users'));

        $this->assertStringNotMatchesFormat('%e', $this->soar->score('select * from users'));
        $this->assertStringNotMatchesFormat('%s', $this->soar->score('select * from users'));
        $this->assertStringNotMatchesFormat('%S', $this->soar->score('select * from users'));
        $this->assertStringNotMatchesFormat('%w', $this->soar->score('select * from users'));
        $this->assertStringNotMatchesFormat('%i', $this->soar->score('select * from users'));
        $this->assertStringNotMatchesFormat('%d', $this->soar->score('select * from users'));
        $this->assertStringNotMatchesFormat('%x', $this->soar->score('select * from users'));
        $this->assertStringNotMatchesFormat('%f', $this->soar->score('select * from users'));
        $this->assertStringNotMatchesFormat('%c', $this->soar->score('select * from users'));
    }

    public function testSyntaxCheck()
    {
        $this->assertStringMatchesFormat('%A', $this->soar->syntaxCheck('selec * from fa_userss;'));
        $this->assertStringMatchesFormat('%a', $this->soar->syntaxCheck('selec * from fa_userss;'));
    }

    public function testFingerPrint()
    {
        $this->assertStringContainsString('?', $this->soar->fingerPrint('select * from users where id = 1;'));
    }

    public function testPretty()
    {
        $this->assertStringMatchesFormat('%A', $this->soar->pretty('select * from fa_userss;'));
        $this->assertStringMatchesFormat('%a', $this->soar->pretty('select * from fa_userss;'));
    }

    public function testMd2html()
    {
        $this->assertStringMatchesFormat('%A', $this->soar->md2html('## 这是一个测试'));
    }

    public function testHelp()
    {
        $this->assertStringMatchesFormat('%A', $this->soar->help('## 这是一个测试'));
    }
}
