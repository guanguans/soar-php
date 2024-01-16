<?php

/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use AspectMock\Test as test;
use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Soar;
use Guanguans\SoarPHP\Support\OS;

it('can get soar binary', function (): void {
    expect(Soar::create())->getSoarBinary()->toBeFile();
})->group(__DIR__, __FILE__);

it('can also get soar binary', function (): void {
    // $mock = \Mockery::mock('alias:'.OS::class)->makePartial();
    // $mock->allows('isWindows')->andReturnTrue();
    // $soar = Soar::create();
    // $this->assertFileExists($soar->getSoarBinary());
    // $this->assertStringContainsString('windows', $soar->getSoarBinary());

    // 暂存
    $originals = ['isWindows' => OS::isWindows(), 'isMacOS' => OS::isMacOS()];

    test::double(OS::class, ['isWindows' => true, 'isMacOS' => false]);
    $soar = Soar::create();
    expect($soar->getSoarBinary())->toBeFile();
    $this->assertStringContainsString('windows', $soar->getSoarBinary());

    test::double(OS::class, ['isWindows' => false, 'isMacOS' => true]);
    $soar = Soar::create();
    expect($soar->getSoarBinary())->toBeFile();
    $this->assertStringContainsString('darwin', $soar->getSoarBinary());

    test::double(OS::class, ['isWindows' => false, 'isMacOS' => false]);
    $soar = Soar::create();
    expect($soar->getSoarBinary())->toBeFile();
    $this->assertStringContainsString('linux', $soar->getSoarBinary());

    // 恢复
    test::double(OS::class, $originals);
})
    ->group(__DIR__, __FILE__)
    ->skip('This test is skipped.');

it('will throw an exception when set invalid binary', function (): void {
    Soar::create()->setSoarBinary('soar.path');
})
    ->group(__DIR__, __FILE__)
    ->throws(InvalidArgumentException::class);
