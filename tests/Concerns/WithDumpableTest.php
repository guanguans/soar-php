<?php

/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */
/** @noinspection UnnecessaryAssertionInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

use Guanguans\SoarPHP\Soar;

it('can dump self with additional params', function (): void {
    expect(Soar::create(['foo' => 'bar']))->dump('foo')->toBeInstanceOf(Soar::class);

    $mockObject = $this->getFunctionMock(class_namespace(Soar::class), 'class_exists');
    $mockObject->expects($this->any())->willReturn(false);
    expect(Soar::create(['foo' => 'bar']))->dump('foo')->toBeInstanceOf(Soar::class);
})->group(__DIR__, __FILE__);
