<?php

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests\Concerns;

use Guanguans\SoarPHP\Concerns\Factory;
use Guanguans\SoarPHP\Explainer;
use Guanguans\Tests\TestCase;
use PDO;

class FactoryTest extends TestCase
{
    use Factory;

    public function testCreateExplainer()
    {
        $this->assertInstanceOf(Explainer::class, $this->createExplainer(new PDO('sqlite::memory:')));
    }
}
