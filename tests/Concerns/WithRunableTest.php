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

use Guanguans\SoarPHP\Exceptions\ProcessFailedException;
use Guanguans\SoarPHP\Soar;
use Guanguans\Tests\TestCase;

class WithRunableTest extends TestCase
{
    public function testProcessFailedExceptionForExec(): void
    {
        $commandOfError = 'xxx';

        $this->expectException(ProcessFailedException::class);
        $this->expectExceptionMessage($commandOfError);
        Soar::create()->setOnlySyntaxCheck(false)->setQuery($commandOfError)->mustRun();
    }

    public function testExec(): void
    {
        $soar = Soar::create();
        $exec = $soar->mustRun('--help');

        $this->assertIsString($exec);
        $this->assertNotEmpty($exec);
    }
}
