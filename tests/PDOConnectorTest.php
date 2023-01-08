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

use Guanguans\SoarPHP\PDOConnector;
use Guanguans\SoarPHP\Support\OsHelper;

class PDOConnectorTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
        OsHelper::isWindows() and $this->markTestSkipped(__CLASS__);
    }

    public function testConnect(): void
    {
        $connect1 = PDOConnector::connect('sqlite::memory:');
        $connect2 = PDOConnector::connect('sqlite::memory:');

        $this->assertInstanceOf(\PDO::class, $connect1);
        $this->assertInstanceOf(\PDO::class, $connect2);
        $this->assertEquals($connect1, $connect2);
    }

    public function testClose(): void
    {
        $connect = PDOConnector::connect('sqlite::memory:');
        PDOConnector::close();

        $this->assertInstanceOf(\PDO::class, $connect);
    }

    public function testConstruct(): void
    {
        $this->markTestSkipped(__METHOD__);

        /** @noinspection PhpUnreachableStatementInspection */
        $this->expectError();
        $this->expectErrorMessage(
            "Call to protected Guanguans\SoarPHP\PDOConnector::__construct() from"
        );
        // new PDOConnector();
    }
}
