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

class WithDumpableTest extends TestCase
{
    public function testDump(): void
    {
        $soar = Soar::create([
            'foo' => 'bar',
        ]);

        $this->assertInstanceOf(Soar::class, $soar->dump('foo'));

        $functionMock = $this->getFunctionMock('\\Guanguans\\SoarPHP', 'class_exists');
        $functionMock->expects($this->any())->willReturn(false);
        $this->assertInstanceOf(Soar::class, $soar->dump('foo'));
    }
}
