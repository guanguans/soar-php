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

use Guanguans\SoarPHP\Concerns\Factory;
use Guanguans\SoarPHP\Explainer;
use Guanguans\Tests\TestCase;
use PDO;

class FactoryTest extends TestCase
{
    use Factory;

    /**
     * @return never
     */
    public function testCreateExplainer(): void
    {
        $this->markTestSkipped(__METHOD__.' is skipped.');
        $this->assertInstanceOf(Explainer::class, $this->createExplainer(new PDO('sqlite::memory:')));
    }
}
