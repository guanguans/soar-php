<?php

/** @noinspection NullPointerExceptionInspection */
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

use Guanguans\SoarPHP\Soar;

it('can set sudo password', function (): void {
    expect(Soar::create())
        ->setSudoPassword($sudoPassword = 'foo')
        ->getSudoPassword()->toBe($sudoPassword);
})->group(__DIR__, __FILE__);

it('can get escaped sudo password', function (): void {
    expect(fn (Soar $soar): string => $soar->getEscapedSudoPassword())->call($soar = Soar::create(), $soar)->toBeString();
})->group(__DIR__, __FILE__);
