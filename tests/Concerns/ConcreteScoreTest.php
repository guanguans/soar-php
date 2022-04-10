<?php

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests\Concerns;

use Guanguans\SoarPHP\Soar;
use Guanguans\Tests\TestCase;

class ConcreteScoreTest extends TestCase
{
    protected $soar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->soar = Soar::create();
    }

    public function testJsonScore()
    {
        $this->assertJson($this->soar->jsonScore('select * from foo;'));
    }

    public function testArrayScore()
    {
        $this->assertIsArray($this->soar->arrayScore('select * from foo;'));
    }

    public function testHtmlScore()
    {
        $this->assertStringContainsString('<p>', $this->soar->htmlScore('select * from foo;'));
    }

    public function testMdScore()
    {
        $this->assertStringContainsString('##', $this->soar->mdScore('select * from foo;'));
    }
}
