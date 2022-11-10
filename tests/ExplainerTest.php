<?php

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests;

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Explainer;
use Nyholm\NSA;

class ExplainerTest extends TestCase
{
    protected $explainer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->markTestSkipped(__CLASS__.' is skipped.');
        $this->explainer = new Explainer(new \PDO('sqlite::memory:'));
    }

    public function testGetPdo()
    {
        $this->assertInstanceOf(\PDO::class, $this->explainer->getPdo());
    }

    public function testSetPdo()
    {
        $this->assertEquals($pdo = new \PDO('sqlite::memory:'), $this->explainer->setPdo($pdo)->getPdo());
    }

    public function testGetNormalizedExplain()
    {
        $this->assertStringContainsString('+----', $normalizedExplain = $this->explainer->getNormalizedExplain('select * from user;'));
        $this->assertStringContainsString('EOF', $normalizedExplain);
        $this->assertStringContainsString(NSA::getConstant($this->explainer, 'EXPLAIN_HEADER'), $normalizedExplain);
    }

    public function testGetExplain()
    {
        $this->assertIsArray($this->explainer->getExplain('select * from user;'));

        $this->expectException(InvalidArgumentException::class);
        $this->explainer->getExplain('select * from user;', 'foo');
    }
}
