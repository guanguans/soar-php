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
        $this->assertJson($jsonScore = $this->soar->jsonScore($sql = 'select * from foo'));
        $this->assertStringContainsString('Score', $jsonScore);
        $this->assertStringContainsString($sql, strtolower($jsonScore));
    }

    public function testArrayScore()
    {
        $this->assertIsArray($arrayScore = $this->soar->arrayScore('select * from foo'));
        $this->assertArrayHasKey('Score', $arrayScore[0]);
        $this->assertStringContainsString('foo', $arrayScore[0]['Sample']);
    }

    public function testHtmlScore()
    {
        $this->assertStringContainsString('<p>', $htmlScore = $this->soar->htmlScore('select * from foo'));
        $this->assertStringContainsString('分', $htmlScore);
        $this->assertStringContainsString('foo', $htmlScore);
    }

    public function testMdScore()
    {
        $this->assertStringContainsString('##', $mdScore = $this->soar->mdScore('select * from foo'));
        $this->assertStringContainsString('分', $mdScore);
        $this->assertStringContainsString('foo', $mdScore);
    }
}
