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
class HasSudoPasswordTest extends TestCase
{
    public function testSetSudoPassword(): void
    {
        $soar = Soar::create();
        $soar->setSudoPassword($sudoPassword = 'foo');

        $this->assertSame($sudoPassword, $soar->getSudoPassword());
    }

    public function testGetEscapedSudoPassword(): void
    {
        $soar = Soar::create();
        $escapedSudoPassword = (function (Soar $soar): string {
            return $soar->getEscapedSudoPassword();
        })->call($soar, $soar);

        $this->assertIsString($escapedSudoPassword);
    }
}
