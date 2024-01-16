<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection UnnecessaryAssertionInspection */

declare(strict_types=1);

/**
 * This file is part of the guanguans/soar-php.
 *
 * (c) guanguans <ityaozm@gmail.com>
 *
 * This source file is subject to the MIT license that is bundled.
 */

use Guanguans\SoarPHP\Soar;

it('can dump self with additional params', function (): void {
    expect(Soar::create(['foo' => 'bar']))->dump('foo')->toBeInstanceOf(Soar::class);

    $mockObject = $this->getFunctionMock(class_namespace(Soar::class), 'class_exists');
    $mockObject->expects($this->any())->willReturn(false);
    expect(Soar::create(['foo' => 'bar']))->dump('foo')->toBeInstanceOf(Soar::class);
})->group(__DIR__, __FILE__);
