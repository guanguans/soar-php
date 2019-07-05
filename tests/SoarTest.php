<?php

/*
 * This file is part of the guanguans/soar-php.
 *
 * (c) 琯琯 <yzmguanguan@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

namespace Guanguans\Tests;

use Guanguans\SoarPHP\Soar;

class SoarTest extends TestCase
{
    protected $soar;

    protected function setUp()
    {
        parent::setUp();
        $this->soar = new Soar();
    }

    public function testToDo()
    {
        $this->assertStringStartsWith('to', 'to do tests');
        $this->markTestIncomplete('to do tests');
    }
}