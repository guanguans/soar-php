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

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Soar;
use Guanguans\Tests\TestCase;

class HasSoarPathTest extends TestCase
{
    public function testGetSoarPath(): void
    {
        $soar = Soar::create();

        $this->assertFileExists($soar->getSoarPath());
    }

    public function testInvalidArgumentExceptionForSetSoarPath(): void
    {
        $soar = Soar::create();

        $this->expectException(InvalidArgumentException::class);
        $soar->setSoarPath('soar.path');
    }
}
