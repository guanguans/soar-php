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

class WithExecutableTest extends TestCase
{
    public function testExec(): void
    {
        $soar = Soar::create();
        $exec = $soar->exec('ls');

        $this->assertIsString($exec);
        $this->assertNotEmpty($exec);
    }
}
