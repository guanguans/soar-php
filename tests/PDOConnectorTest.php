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

class PDOConnectorTest extends TestCase
{
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

    public function testClone(): void
    {
        $this->markTestSkipped(__METHOD__);

        $this->expectError();
        $this->expectErrorMessage(
            'Trying to clone an uncloneable object of class Guanguans\SoarPHP\PDOConnector'
        );

        // clone PDOConnector::connect('sqlite::memory:');
    }
}
