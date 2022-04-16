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
use Guanguans\SoarPHP\Support\OsHelper;
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
        $this->assertIsArray($arrayScore = $this->soar->arrayScore('select * from `foo`; select * from `bar` where `name`="soar";'));
        $this->assertCount(2, $arrayScore);
        var_export($arrayScore);

        $this->assertArrayHasKey('ID', $score = $arrayScore[0]);
        $this->assertArrayHasKey('Fingerprint', $score);
        $this->assertArrayHasKey('Score', $score);
        $this->assertArrayHasKey('Sample', $score);
        $this->assertArrayHasKey('Explain', $score);
        $this->assertArrayHasKey('HeuristicRules', $score);
        $this->assertArrayHasKey('IndexRules', $score);
        $this->assertArrayHasKey('Tables', $score);

        $this->assertIsInt($score['Score']);
        $this->assertStringContainsString('select', $score['Sample']);
        $this->assertEmpty($score['Explain']);
        $this->assertEmpty($score['IndexRules']);
        if (! OsHelper::isWindows()) {
            $this->assertIsArray($tables = $score['Tables']);
            $this->assertNotEmpty($tables);
        }

        $this->assertIsArray($heuristicRules = $score['HeuristicRules']);
        $this->assertNotEmpty($heuristicRules);
        $this->assertIsArray($heuristicRule = $heuristicRules[0]);
        $this->assertArrayHasKey('Item', $heuristicRule);
        $this->assertArrayHasKey('Severity', $heuristicRule);
        $this->assertArrayHasKey('Summary', $heuristicRule);
        $this->assertArrayHasKey('Content', $heuristicRule);
        $this->assertArrayHasKey('Case', $heuristicRule);
        $this->assertArrayHasKey('Position', $heuristicRule);
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
