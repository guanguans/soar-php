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

class ConcreteListRewriteRulesTest extends TestCase
{
    public function testJsonListRewriteRules(): void
    {
        $soar = Soar::create();
        $jsonListRewriteRules = $soar->jsonListRewriteRules();

        $this->assertJson($jsonListRewriteRules);
        $this->assertNotEmpty($jsonListRewriteRules);
        $this->assertMatchesJsonSnapshot($jsonListRewriteRules);
    }

    public function testArrayListRewriteRules(): void
    {
        $soar = Soar::create();
        $arrayListRewriteRules = $soar->arrayListRewriteRules();

        $this->assertIsArray($arrayListRewriteRules);
        $this->assertNotEmpty($arrayListRewriteRules);
    }

    public function testMdListRewriteRules(): void
    {
        $soar = Soar::create();
        $mdListRewriteRules = $soar->mdListRewriteRules();

        $this->assertIsString($mdListRewriteRules);
        $this->assertNotEmpty($mdListRewriteRules);
    }
}
