<?php

/** @noinspection AnonymousFunctionStaticInspection */
/** @noinspection NullPointerExceptionInspection */
/** @noinspection PhpPossiblePolymorphicInvocationInspection */
/** @noinspection PhpUnhandledExceptionInspection */
/** @noinspection StaticClosureCanBeUsedInspection */

declare(strict_types=1);

/**
 * Copyright (c) 2019-2025 guanguans<ityaozm@gmail.com>
 *
 * For the full copyright and license information, please view
 * the LICENSE file that was distributed with this source code.
 *
 * @see https://github.com/guanguans/soar-php
 */

use Guanguans\SoarPHP\Exceptions\InvalidArgumentException;
use Guanguans\SoarPHP\Soar;

it('can get soar binary', function (): void {
    expect(Soar::create())->getSoarBinary()->toBeFile();
})->group(__DIR__, __FILE__);

it('will throw InvalidArgumentException when set invalid binary', function (): void {
    Soar::create()->setSoarBinary('/');
    Soar::create()->setSoarBinary('soar.path');
})
    ->group(__DIR__, __FILE__)
    ->throws(InvalidArgumentException::class);
