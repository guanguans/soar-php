<?php

/** @noinspection PhpUnused */

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
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
 * @iterations(3)
 */
final class SoarBench
{
    private ?\Guanguans\SoarPHP\Soar $soar;

    public function setUp(): void
    {
        $this->soar = Soar::create();
    }

    /**
     * @noinspection PhpUnhandledExceptionInspection
     * @noinspection SqlNoDataSourceInspection
     * @noinspection SqlResolve
     */
    public function benchScores(): void
    {
        $this->soar->scores('SELECT * FROM foo;');
    }
}
