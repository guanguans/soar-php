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
    // $mock = Mockery::mock('alias:'.OS::class)->makePartial();
    // $mock->allows('isWindows')->andReturnTrue();
    // expect(Soar::create())->getSoarBinary()->toBeFile()->toContain('windows');

    // 暂存
    $originals = ['isWindows' => OS::isWindows(), 'isMacOS' => OS::isMacOS()];

    test::double(OS::class, ['isWindows' => true, 'isMacOS' => false]);
    expect(Soar::create())->getSoarBinary()->toBeFile()->toContain('windows');

    test::double(OS::class, ['isWindows' => false, 'isMacOS' => true]);
    expect(Soar::create())->getSoarBinary()->toBeFile()->toContain('darwin');

    test::double(OS::class, ['isWindows' => false, 'isMacOS' => false]);
    expect(Soar::create())->getSoarBinary()->toBeFile()->toContain('linux');

    // 恢复
    test::double(OS::class, $originals);
})
    ->group(__DIR__, __FILE__)
    ->skip('This test is skipped.');

it('will throw InvalidArgumentException when set invalid binary', function (): void {
    Soar::create()->setSoarBinary('soar.path');
})
    ->group(__DIR__, __FILE__)
    ->throws(InvalidArgumentException::class);
