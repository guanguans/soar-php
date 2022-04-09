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

class SoarTest extends TestCase
{
    protected $soar;

    protected function setUp(): void
    {
        parent::setUp();

        $this->soar = Soar::create();
    }

    public function testExec()
    {
        $this->assertIsString($this->soar->exec('echo soar'));
    }

    public function testScore()
    {
        $this->assertIsString($this->soar->score('select * from users'));
    }

    public function testSyntaxCheck()
    {
        $this->assertIsString($this->soar->syntaxCheck('selec * from fa_userss;'));
    }

    public function testFingerPrint()
    {
        $this->assertStringContainsString('?', $this->soar->fingerPrint('select * from users where id = 1;'));
    }

    public function testPretty()
    {
        $this->assertIsString($this->soar->pretty('selec * from fa_userss;'));
    }

    public function testMd2html()
    {
        $this->assertStringContainsString('<h2>', $this->soar->md2html('## 这是一个测试'));
    }

    public function testHelp()
    {
        $this->assertIsString($this->soar->help());
    }
}
