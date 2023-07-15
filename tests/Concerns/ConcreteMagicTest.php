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

/**
 * @internal
 *
 * @small
 */
class ConcreteMagicTest extends TestCase
{
    public function testSleep(): void
    {
        $soar = Soar::create(require __DIR__.'/../../examples/soar.options.full.php');
        $serializedSoar = serialize($soar);
        $unserializedSoar = unserialize($serializedSoar);

        $this->assertInstanceOf(Soar::class, $unserializedSoar);
        $this->assertNotEmpty($unserializedSoar->getSoarPath());
        $this->assertNotEmpty($unserializedSoar->getOptions());
    }

    /**
     * @noinspection DebugFunctionUsageInspection
     */
    public function testSetState(): void
    {
        $soar = Soar::create(require __DIR__.'/../../examples/soar.options.full.php');
        $exportedSoarStr = var_export($soar, true);
        $exportedSoar = null;
        eval("\$exportedSoar = $exportedSoarStr;");

        $this->assertInstanceOf(Soar::class, $exportedSoar);
        $this->assertNotEmpty($exportedSoar->getSoarPath());
        $this->assertNotEmpty($exportedSoar->getOptions());
    }
}
