<?php

declare(strict_types=1);

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

class ConcreteListHeuristicRulesTest extends TestCase
{
    public function testJsonListHeuristicRules(): void
    {
        $soar = Soar::create();
        $jsonListHeuristicRules = $soar->jsonListHeuristicRules();

        $this->assertJson($jsonListHeuristicRules);
        $this->assertNotEmpty($jsonListHeuristicRules);
        $this->assertMatchesJsonSnapshot($jsonListHeuristicRules);
    }

    public function testArrayListHeuristicRules(): void
    {
        $soar = Soar::create();
        $arrayListHeuristicRules = $soar->arrayListHeuristicRules();

        $this->assertIsArray($arrayListHeuristicRules);
        $this->assertNotEmpty($arrayListHeuristicRules);
    }

    public function testMdListHeuristicRules(): void
    {
        $soar = Soar::create();
        $mdListHeuristicRules = $soar->mdListHeuristicRules();

        $this->assertIsString($mdListHeuristicRules);
        $this->assertNotEmpty($mdListHeuristicRules);
    }
}
