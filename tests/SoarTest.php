<?php

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests;

use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHP\Support\OS;

/**
 * @internal
 *
 * @small
 */
class SoarTest extends TestCase
{
    public function testHelp(): void
    {
        OS::isWindows() and $this->markTestSkipped('The method of help is not supported on windows.');
        $soar = Soar::create();
        $help = $soar->help();

        $this->assertStringContainsString('-version', $help);
    }

    public function testVersion(): void
    {
        $soar = Soar::create();
        $version = $soar->version();

        $this->assertStringContainsString('Version: 2023-01-21 17:22:53 +0800 0.11.0-146-gfab0463', $version);
        $this->assertStringContainsString('Branch: dev', $version);
        $this->assertStringContainsString('Compile: 2023-05-19 16:43:09 +0800 by go version go1.20.4', $version);
        $this->assertStringContainsString('GitDirty:        0', $version);
    }
}
