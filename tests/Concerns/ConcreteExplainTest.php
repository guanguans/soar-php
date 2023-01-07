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

use Guanguans\SoarPHP\Exceptions\InvalidConfigException;
use Guanguans\SoarPHP\Soar;
use Guanguans\Tests\TestCase;

class ConcreteExplainTest extends TestCase
{
    public function testMdExplain(): void
    {
        $soar = Soar::create();

        $this->expectException(InvalidConfigException::class);
        $soar->mdExplain('select * from users;');
    }

    public function testHtmlExplain(): void
    {
        $soar = Soar::create();

        $this->expectException(InvalidConfigException::class);
        $soar->htmlExplain('select * from users;');
    }
}
