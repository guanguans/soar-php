<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\PackageSkeleton\Tests\Benchmark;

use Guanguans\SoarPHP\Soar;

/**
 * @beforeMethods({"setUp"})
 *
 * @warmup(1)
 *
 * @revs(10)
 *
 * @iterations(5)
 */
final class SoarBench
{
    /**
     * @var null|\Guanguans\SoarPHP\Soar
     */
    private $soar;

    public function setUp(): void
    {
        $this->soar = Soar::create();
    }

    public function benchScores(): void
    {
        $this->soar->scores('SELECT * FROM foo;');
    }
}
