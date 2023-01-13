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
use Guanguans\SoarPHP\Exceptions\ProcessFailedException;
use Guanguans\SoarPHP\Soar;
use Guanguans\Tests\TestCase;

class WithRunableTest extends TestCase
{
    public function testInvalidArgumentExceptionForExec(): void
    {
        $soar = Soar::create();
        $optionsOfError = true;

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(gettype($optionsOfError));
        $soar->run($optionsOfError);
    }

    public function testProcessFailedExceptionForExec(): void
    {
        $soar = Soar::create();
        $optionsOfError = 'optionsOfError';

        $this->expectException(ProcessFailedException::class);
        $this->expectExceptionMessage($optionsOfError);
        $soar->setOnlySyntaxCheck(true)->setQuery($optionsOfError)->run();
    }

    public function testExec(): void
    {
        $soar = Soar::create();
        $exec = $soar->run('-version');

        $this->assertIsString($exec);
    }
}
