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
use Guanguans\SoarPHP\Explainer;
use Guanguans\SoarPHP\Factory;
use Guanguans\SoarPHP\PDOConnector;
use Guanguans\SoarPHP\Support\OsHelper;
use Nyholm\NSA;

class FactoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        OsHelper::isWindows() and $this->markTestSkipped(__CLASS__);
    }

    public function testCreateExplainer(): void
    {
        $explainer = Factory::createExplainer(new \PDO('sqlite::memory:'));
        $this->assertInstanceOf(Explainer::class, $explainer);
    }

    public function testCreatePDO(): void
    {
        $this->markTestSkipped(__METHOD__);

        /** @noinspection PhpUnreachableStatementInspection */
        $pdo = Factory::createPDO([
            'host' => 'you_host',
            'port' => 'you_port',
            'dbname' => 'you_dbname',
            'username' => 'you_username',
            'password' => 'you_password',
            'options' => [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'],
            'disable' => false,
        ]);

        $this->assertInstanceOf(PDOConnector::class, $pdo);
    }

    public function testInvalidConfigExceptionForExtractConfigOfPDO(): void
    {
        $options = [
            '-test-dsn' => [
                'host' => 'you_host',
                'port' => 'you_port',
                'dbname' => 'you_dbname',
                'username' => 'you_username',
                'password' => 'you_password',
                'options' => [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'],
                'disable' => true,
            ],
            '-online-dsn' => [
                'host' => 'you_host',
                'port' => 'you_port',
                'dbname' => 'you_dbname',
                'username' => 'you_username',
                'password' => 'you_password',
                'options' => [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'],
                'disable' => true,
            ],
        ];

        $this->expectException(InvalidConfigException::class);
        $this->expectExceptionMessage('The configuration of PDO no found.');
        NSA::invokeMethod(Factory::class, 'extractConfigOfPDO', $options);
    }

    public function testExtractConfigOfPDO(): void
    {
        $options = [
            '-test-dsn' => $testDsn = [
                'host' => 'you_host',
                'port' => 'you_port',
                'dbname' => 'you_dbname',
                'username' => 'you_username',
                'password' => 'you_password',
                'options' => [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'],
                'disable' => false,
            ],
            '-online-dsn' => $onlineDsn = [
                'host' => 'you_host',
                'port' => 'you_port',
                'dbname' => 'you_dbname',
                'username' => 'you_username',
                'password' => 'you_password',
                'options' => [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'],
                'disable' => false,
            ],
        ];
        $configOfPDO = NSA::invokeMethod(Factory::class, 'extractConfigOfPDO', $options);
        $this->assertEquals($testDsn, $configOfPDO);

        $options = [
            '-test-dsn' => $testDsn = [
                'host' => 'you_host',
                'port' => 'you_port',
                'dbname' => 'you_dbname',
                'username' => 'you_username',
                'password' => 'you_password',
                'options' => [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'],
                'disable' => true,
            ],
            '-online-dsn' => $onlineDsn = [
                'host' => 'you_host',
                'port' => 'you_port',
                'dbname' => 'you_dbname',
                'username' => 'you_username',
                'password' => 'you_password',
                'options' => [\PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'],
                'disable' => false,
            ],
        ];
        $configOfPDO = NSA::invokeMethod(Factory::class, 'extractConfigOfPDO', $options);
        $this->assertEquals($onlineDsn, $configOfPDO);
    }
}
